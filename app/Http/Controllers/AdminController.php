<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\RumahMudik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // ─── Auth ───────────────────────────────────────────────────────────────

    public function loginForm()
    {
        if (Session::get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $adminPassword = config('app.admin_password', 'admin123');

        if ($request->password === $adminPassword) {
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Password salah.'])->withInput();
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    // ─── Dashboard ──────────────────────────────────────────────────────────

    public function dashboard(Request $request)
    {
        $query = RumahMudik::query();

        // Filter kabupaten
        if ($request->filled('kabupaten')) {
            $query->where('kabupaten', $request->kabupaten);
        }

        // Filter kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Cari berdasarkan NIK
        if ($request->filled('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        $rumahList   = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $kabupatens  = Kabupaten::orderBy('nama')->get();
        $kecamatans  = collect();

        if ($request->filled('kabupaten')) {
            $kab = Kabupaten::where('nama', $request->kabupaten)->first();
            if ($kab) {
                $kecamatans = $kab->kecamatans()->orderBy('nama')->get();
            }
        }

        return view('admin.dashboard', compact('rumahList', 'kabupatens', 'kecamatans'));
    }

    public function show(RumahMudik $rumah)
    {
        return view('admin.detail', compact('rumah'));
    }

    // ─── API: semua titik untuk peta ────────────────────────────────────────

    public function mapData(Request $request)
    {
        $query = RumahMudik::select(
            'id', 'nik', 'nama_pemilik', 'latitude', 'longitude',
            'alamat_lengkap', 'rt', 'rw', 'kabupaten', 'kecamatan',
            'tanggal_mulai_mudik', 'tanggal_selesai_mudik'
        );

        if ($request->filled('kabupaten')) {
            $query->where('kabupaten', $request->kabupaten);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        return response()->json($query->get());
    }
}
