<?php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
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

    /**
     * AJAX — kembalikan daftar kelurahan berdasarkan kecamatan_id
     */
    public function getKelurahans(Request $request)
    {
        $request->validate(['kecamatan_id' => 'required|exists:kecamatan,id']);

        $kelurahans = Kelurahan::where('kecamatan_id', $request->kecamatan_id)
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($kelurahans);
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
            'kecamatan_id'           => 'required|exists:kecamatan,id',
            'kelurahan_id'           => 'required|exists:kelurahan,id',
            'tanggal_mulai_mudik'    => 'required|date',
            'tanggal_selesai_mudik'  => 'required|date|after_or_equal:tanggal_mulai_mudik',
            'foto_rumah_compressed'  => 'nullable|string',
        ], [
            'nik.required'                         => 'NIK wajib diisi.',
            'nik.digits'                           => 'NIK harus 16 digit.',
            'nama_pemilik.required'                => 'Nama pemilik wajib diisi.',
            'latitude.required'                    => 'Titik lokasi wajib dipilih di peta.',
            'longitude.required'                   => 'Titik lokasi wajib dipilih di peta.',
            'alamat_lengkap.required'              => 'Alamat lengkap wajib diisi.',
            'rt.required'                          => 'RT wajib diisi.',
            'rw.required'                          => 'RW wajib diisi.',
            'kecamatan_id.required'                => 'Kecamatan wajib dipilih.',
            'kecamatan_id.exists'                  => 'Kecamatan tidak valid.',
            'kelurahan_id.required'                => 'Kelurahan/Desa wajib dipilih.',
            'kelurahan_id.exists'                  => 'Kelurahan tidak valid.',
            'tanggal_mulai_mudik.required'         => 'Tanggal mulai mudik wajib diisi.',
            'tanggal_selesai_mudik.required'       => 'Tanggal selesai mudik wajib diisi.',
            'tanggal_selesai_mudik.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);

        // Ambil nama dari relasi (simpan string ke kolom, lebih portabel)
        $kecamatan = Kecamatan::findOrFail($validated['kecamatan_id']);
        $kelurahan = Kelurahan::findOrFail($validated['kelurahan_id']);

        // ── Simpan foto dari base64 ────────────────────────────────────────────
        $fotoPath = null;
        $base64   = $request->input('foto_rumah_compressed');

        if ($base64 && str_starts_with($base64, 'data:image/jpeg;base64,')) {
            $imageData = base64_decode(substr($base64, strlen('data:image/jpeg;base64,')));
            $filename  = 'rumah/' . uniqid('foto_', true) . '.jpg';
            Storage::disk('public')->put($filename, $imageData);
            $fotoPath  = $filename;
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
            'kecamatan'             => $kecamatan->nama,
            'kelurahan'             => $kelurahan->nama,
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