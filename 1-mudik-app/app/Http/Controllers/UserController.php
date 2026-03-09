<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\RumahMudik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $kabupatens = Kabupaten::orderBy('nama')->get();
        return view('user.form', compact('kabupatens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'                    => 'required|digits:16',
            'nama_pemilik'           => 'required|string|max:255',
            'latitude'               => 'required|numeric|between:-90,90',
            'longitude'              => 'required|numeric|between:-180,180',
            'alamat_lengkap'         => 'required|string',
            'rt'                     => 'required|string|max:5',
            'rw'                     => 'required|string|max:5',
            'kabupaten'              => 'required|string',
            'kecamatan'              => 'required|string',
            'tanggal_mulai_mudik'    => 'required|date',
            'tanggal_selesai_mudik'  => 'required|date|after_or_equal:tanggal_mulai_mudik',
            'foto_rumah'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nik.required'                   => 'NIK wajib diisi.',
            'nik.digits'                     => 'NIK harus 16 digit.',
            'nama_pemilik.required'          => 'Nama pemilik wajib diisi.',
            'latitude.required'              => 'Titik lokasi wajib dipilih di peta.',
            'longitude.required'             => 'Titik lokasi wajib dipilih di peta.',
            'alamat_lengkap.required'        => 'Alamat lengkap wajib diisi.',
            'rt.required'                    => 'RT wajib diisi.',
            'rw.required'                    => 'RW wajib diisi.',
            'kabupaten.required'             => 'Kabupaten wajib dipilih.',
            'kecamatan.required'             => 'Kecamatan wajib dipilih.',
            'tanggal_mulai_mudik.required'   => 'Tanggal mulai mudik wajib diisi.',
            'tanggal_selesai_mudik.required' => 'Tanggal selesai mudik wajib diisi.',
            'tanggal_selesai_mudik.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_rumah')) {
            $fotoPath = $request->file('foto_rumah')->store('rumah', 'public');
        }

        RumahMudik::create([
            ...$validated,
            'foto_rumah' => $fotoPath,
        ]);

        return redirect()->route('user.success')->with('success', 'Data rumah mudik berhasil disimpan!');
    }

    public function success()
    {
        return view('user.success');
    }

    // API: Ambil kecamatan berdasarkan kabupaten (untuk dropdown dinamis)
    public function getKecamatan(Request $request)
    {
        $kabupatenNama = $request->query('kabupaten');
        $kabupaten = Kabupaten::where('nama', $kabupatenNama)->first();

        if (!$kabupaten) {
            return response()->json([]);
        }

        $kecamatans = Kecamatan::where('kabupaten_id', $kabupaten->id)
            ->orderBy('nama')
            ->get(['nama']);

        return response()->json($kecamatans);
    }
}
