<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

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

    // ─── Dashboard (redirect ke data) ───────────────────────────────────────

    public function dashboard(Request $request)
    {
        return redirect()->route('admin.data');
    }

    // ─── Halaman Data Rumah ──────────────────────────────────────────────────

    public function data(Request $request)
    {
        $query = RumahMudik::query();

        $this->applyFilters($query, $request);

        $sort = $request->input('sort', 'terbaru');
        $query->orderBy('created_at', $sort === 'terlama' ? 'asc' : 'desc');

        $rumahList  = $query->paginate(15)->withQueryString();
        $kecamatans = $this->getKecamatans();

        return view('admin.data', compact('rumahList', 'kecamatans', 'sort'));
    }

    // ─── Halaman Peta ────────────────────────────────────────────────────────

    public function peta(Request $request)
    {
        $kecamatans = $this->getKecamatans();
        return view('admin.peta', compact('kecamatans'));
    }

    // ─── Detail ─────────────────────────────────────────────────────────────

    public function show(RumahMudik $rumah)
    {
        return view('admin.detail', compact('rumah'));
    }

    // ─── API: titik peta (dipakai halaman peta & data) ──────────────────────

    public function mapData(Request $request)
    {
        $query = RumahMudik::select(
            'id', 'nik', 'nama_pemilik', 'latitude', 'longitude',
            'alamat_lengkap', 'rt', 'rw', 'kabupaten', 'kecamatan',
            'tanggal_mulai_mudik', 'tanggal_selesai_mudik'
        );

        $this->applyFilters($query, $request);

        return response()->json($query->get());
    }

    // ─── Helper: terapkan filter ke query ───────────────────────────────────

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        if ($request->filled('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        // RT: normalisasi — buang leading zeros, lalu cocokkan angka intinya
        // Contoh: input "004" → cari angka 4
        // Cocok dengan "4", "04", "004", "0004" di database
        if ($request->filled('rt')) {
            $rtNorm = ltrim($request->rt, '0') ?: '0';
            $query->whereRaw(
                "CAST(rt AS INTEGER) = ?",
                [(int) $rtNorm]
            );
        }

        if ($request->filled('rw')) {
            $rwNorm = ltrim($request->rw, '0') ?: '0';
            $query->whereRaw(
                "CAST(rw AS INTEGER) = ?",
                [(int) $rwNorm]
            );
        }
    }

    // ─── Helper: ambil kecamatan ─────────────────────────────────────────────

    private function getKecamatans()
    {
        return Kecamatan::whereHas('kabupaten', function ($q) {
            $q->where('nama', self::KABUPATEN);
        })->orderBy('nama')->get();
    }
}