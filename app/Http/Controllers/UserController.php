<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\RumahMudik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const KABUPATEN = 'Kabupaten Semarang';

    public function index()
    {
        $kecamatans = Kecamatan::whereHas('kabupaten', function ($q) {
            $q->where('nama', self::KABUPATEN);
        })->orderBy('nama')->get();

        return view('user.form', compact('kecamatans'));
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
            'kecamatan'              => 'required|string',
            'tanggal_mulai_mudik'    => 'required|date',
            'tanggal_selesai_mudik'  => 'required|date|after_or_equal:tanggal_mulai_mudik',
            'foto_rumah_compressed'  => 'nullable|string', // base64 dari canvas
        ], [
            'nik.required'                         => 'NIK wajib diisi.',
            'nik.digits'                           => 'NIK harus 16 digit.',
            'nama_pemilik.required'                => 'Nama pemilik wajib diisi.',
            'latitude.required'                    => 'Titik lokasi wajib dipilih di peta.',
            'longitude.required'                   => 'Titik lokasi wajib dipilih di peta.',
            'alamat_lengkap.required'              => 'Alamat lengkap wajib diisi.',
            'rt.required'                          => 'RT wajib diisi.',
            'rw.required'                          => 'RW wajib diisi.',
            'kecamatan.required'                   => 'Kecamatan wajib dipilih.',
            'tanggal_mulai_mudik.required'         => 'Tanggal mulai mudik wajib diisi.',
            'tanggal_selesai_mudik.required'       => 'Tanggal selesai mudik wajib diisi.',
            'tanggal_selesai_mudik.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        // ── Simpan foto dari base64 (sudah dikompres di frontend) ──────────────
        $fotoPath = null;
        $base64 = $request->input('foto_rumah_compressed');

        if ($base64 && str_starts_with($base64, 'data:image/jpeg;base64,')) {
            $imageData = base64_decode(substr($base64, strlen('data:image/jpeg;base64,')));
            $filename  = 'rumah/' . uniqid('foto_', true) . '.jpg';
            Storage::disk('public')->put($filename, $imageData);
            $fotoPath = $filename;
        }

        RumahMudik::create([
            'nik'                   => $validated['nik'],
            'nama_pemilik'          => $validated['nama_pemilik'],
            'latitude'              => $validated['latitude'],
            'longitude'             => $validated['longitude'],
            'alamat_lengkap'        => $validated['alamat_lengkap'],
            'rt'                    => $validated['rt'],
            'rw'                    => $validated['rw'],
            'kabupaten'             => self::KABUPATEN,
            'kecamatan'             => $validated['kecamatan'],
            'tanggal_mulai_mudik'   => $validated['tanggal_mulai_mudik'],
            'tanggal_selesai_mudik' => $validated['tanggal_selesai_mudik'],
            'foto_rumah'            => $fotoPath,
        ]);

        return redirect()->route('user.success')->with('success', 'Data rumah mudik berhasil disimpan!');
    }

    public function success()
    {
        return view('user.success');
    }
}