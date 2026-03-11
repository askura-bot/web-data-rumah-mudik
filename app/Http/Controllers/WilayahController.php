<?php
// app/Http/Controllers/WilayahController.php
namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    // ─── KECAMATAN ────────────────────────────────────────────────────────────

    public function kecamatanIndex(Request $request)
    {
        $query = Kecamatan::withCount('kelurahans')->orderBy('nama');

        if ($request->filled('search')) {
            $query->where('nama', 'ilike', '%' . $request->search . '%');
        }

        $kecamatans = $query->paginate(20)->withQueryString();

        return view('admin.kecamatan-index', compact('kecamatans'));
    }

    public function kecamatanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kecamatan,nama',
        ], [
            'nama.required' => 'Nama kecamatan wajib diisi.',
            'nama.unique'   => 'Kecamatan dengan nama tersebut sudah ada.',
        ]);

        Kecamatan::create([
            'kabupaten_id' => \App\Models\Kabupaten::where('nama', 'Kabupaten Semarang')->value('id'),
            'nama'         => $request->nama,
        ]);

        return back()->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function kecamatanUpdate(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kecamatan,nama,' . $kecamatan->id,
        ], [
            'nama.required' => 'Nama kecamatan wajib diisi.',
            'nama.unique'   => 'Kecamatan dengan nama tersebut sudah ada.',
        ]);

        $kecamatan->update(['nama' => $request->nama]);

        return back()->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function kecamatanDestroy(Kecamatan $kecamatan)
    {
        // Cek apakah ada kelurahan atau rumah_mudik yang terkait
        if ($kecamatan->kelurahans()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kecamatan yang masih memiliki kelurahan.');
        }

        $kecamatan->delete();

        return back()->with('success', 'Kecamatan berhasil dihapus.');
    }

    // ─── KELURAHAN ────────────────────────────────────────────────────────────

    public function kelurahanIndex(Request $request)
    {
        $query = Kelurahan::with('kecamatan')->orderBy('nama');

        if ($request->filled('search')) {
            $query->where('nama', 'ilike', '%' . $request->search . '%');
        }

        if ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        }

        $kelurahans  = $query->paginate(20)->withQueryString();
        $kecamatans  = Kecamatan::orderBy('nama')->get();

        return view('admin.kelurahan-index', compact('kelurahans', 'kecamatans'));
    }

    public function kelurahanStore(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'nama'         => 'required|string|max:100',
        ], [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'kecamatan_id.exists'   => 'Kecamatan tidak valid.',
            'nama.required'         => 'Nama kelurahan wajib diisi.',
        ]);

        // Cek duplikat dalam kecamatan yang sama
        $exists = Kelurahan::where('kecamatan_id', $request->kecamatan_id)
            ->where('nama', $request->nama)->exists();

        if ($exists) {
            return back()
                ->with('error', 'Kelurahan dengan nama tersebut sudah ada di kecamatan ini.')
                ->withInput(); // withInput sudah membawa kecamatan_id otomatis
        }

        Kelurahan::create([
            'kecamatan_id' => $request->kecamatan_id,
            'nama'         => $request->nama,
        ]);

        // Flash kecamatan_id ke session agar dropdown tidak reset setelah sukses
        return back()
            ->with('success', 'Kelurahan berhasil ditambahkan.')
            ->with('last_kecamatan_id', $request->kecamatan_id);
    }

    public function kelurahanUpdate(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'nama'         => 'required|string|max:100',
        ], [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'nama.required'         => 'Nama kelurahan wajib diisi.',
        ]);

        // Cek duplikat dalam kecamatan, kecuali dirinya sendiri
        $exists = Kelurahan::where('kecamatan_id', $request->kecamatan_id)
            ->where('nama', $request->nama)
            ->where('id', '!=', $kelurahan->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Kelurahan dengan nama tersebut sudah ada di kecamatan ini.');
        }

        $kelurahan->update([
            'kecamatan_id' => $request->kecamatan_id,
            'nama'         => $request->nama,
        ]);

        return back()->with('success', 'Kelurahan berhasil diperbarui.');
    }

    public function kelurahanDestroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();
        return back()->with('success', 'Kelurahan berhasil dihapus.');
    }
}