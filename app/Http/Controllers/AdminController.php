<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\RumahMudik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    const KABUPATEN = 'Kabupaten Semarang';

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
        $request->validate(['password' => 'required']);

        if ($request->password === config('app.admin_password', 'admin123')) {
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

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        // Urutkan: terbaru (default) atau terlama
        $sort = $request->input('sort', 'terbaru');
        $query->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc');

        $rumahList  = $query->paginate(15)->withQueryString();

        $kecamatans = Kecamatan::whereHas('kabupaten', function ($q) {
            $q->where('nama', self::KABUPATEN);
        })->orderBy('nama')->get();

        return view('admin.dashboard', compact('rumahList', 'kecamatans', 'sort'));
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

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }
        if ($request->filled('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        return response()->json($query->get());
    }
}