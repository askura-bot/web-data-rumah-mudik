@extends('layouts.app')
@section('title', 'Dashboard Admin')

@push('styles')
<style>
    #admin-map { height: 450px; }
    .filter-input {
        @apply px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-500;
    }
</style>
@endpush

@section('content')
{{-- Navbar Admin --}}
<nav class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between sticky top-0 z-50">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-slate-700 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <span class="font-700 text-sm">Admin Panel – Rumah Mudik</span>
    </div>
    <div class="flex items-center gap-4">
        <span class="text-xs text-slate-400">{{ $rumahList->total() }} data terdaftar</span>
        <a href="{{ route('admin.logout') }}"
            class="text-xs bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded-lg transition">Keluar</a>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- ── Filter ── --}}
    <form method="GET" action="{{ route('admin.dashboard') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- NIK --}}
            <div>
                <label class="block text-xs font-600 text-gray-600 mb-1.5">Cari NIK</label>
                <input type="text" name="nik" value="{{ request('nik') }}"
                    class="filter-input w-full" placeholder="Masukkan NIK...">
            </div>

            {{-- Kabupaten --}}
            <div>
                <label class="block text-xs font-600 text-gray-600 mb-1.5">Kabupaten / Kota</label>
                <select name="kabupaten" id="filter_kabupaten" class="filter-input w-full">
                    <option value="">Semua Kabupaten</option>
                    @foreach($kabupatens as $kab)
                        <option value="{{ $kab->nama }}" {{ request('kabupaten') == $kab->nama ? 'selected' : '' }}>
                            {{ $kab->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kecamatan --}}
            <div>
                <label class="block text-xs font-600 text-gray-600 mb-1.5">Kecamatan</label>
                <select name="kecamatan" id="filter_kecamatan" class="filter-input w-full">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatans as $kec)
                        <option value="{{ $kec->nama }}" {{ request('kecamatan') == $kec->nama ? 'selected' : '' }}>
                            {{ $kec->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Actions --}}
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white text-sm font-600 py-2 px-4 rounded-lg transition">
                    Filter
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-600 py-2 px-4 rounded-lg transition">
                    Reset
                </a>
            </div>
        </div>
    </form>

    {{-- ── Peta ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-700 text-gray-800 text-sm flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Sebaran Titik Rumah
            </h2>
            <span class="text-xs text-gray-400">Klik marker untuk detail</span>
        </div>
        <div id="admin-map"></div>
    </div>

    {{-- ── Tabel ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-700 text-gray-800 text-sm">
                Daftar Rumah ({{ $rumahList->total() }} data)
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">#</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">NIK</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">Nama Pemilik</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">Kabupaten</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">Kecamatan</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">RT/RW</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">Mudik</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">Foto</th>
                        <th class="px-4 py-3 font-600 text-gray-600 text-xs">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($rumahList as $rumah)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $loop->iteration + ($rumahList->currentPage() - 1) * $rumahList->perPage() }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-700">{{ $rumah->nik }}</td>
                        <td class="px-4 py-3 font-500 text-gray-800">{{ $rumah->nama_pemilik }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $rumah->kabupaten }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ $rumah->kecamatan }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">RT {{ $rumah->rt }} / RW {{ $rumah->rw }}</td>
                        <td class="px-4 py-3 text-xs">
                            <div class="text-gray-600">{{ $rumah->tanggal_mulai_mudik->format('d M') }}</div>
                            <div class="text-gray-400">s/d {{ $rumah->tanggal_selesai_mudik->format('d M Y') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($rumah->foto_rumah)
                                <img src="{{ Storage::url($rumah->foto_rumah) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200" alt="">
                            @else
                                <span class="text-gray-300 text-xs">–</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.show', $rumah) }}"
                                class="inline-flex items-center gap-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-600 px-3 py-1.5 rounded-lg transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center text-gray-400 text-sm">
                            Belum ada data yang sesuai filter
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if($rumahList->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $rumahList->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// ─── Peta Admin ──────────────────────────────────────────────────────────────
const adminMap = L.map('admin-map').setView([-7.0051, 110.4381], 11);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors', maxZoom: 19
}).addTo(adminMap);

const markerIcon = L.divIcon({
    html: `<div style="background:#dc2626;width:14px;height:14px;border-radius:50%;border:2px solid white;box-shadow:0 1px 4px rgba(0,0,0,0.4)"></div>`,
    iconSize: [14, 14], iconAnchor: [7, 7],
});

// Ambil data dari API dengan filter yang aktif
const params = new URLSearchParams({
    @if(request('kabupaten')) kabupaten: '{{ request('kabupaten') }}', @endif
    @if(request('kecamatan')) kecamatan: '{{ request('kecamatan') }}', @endif
    @if(request('nik'))       nik: '{{ request('nik') }}',           @endif
});

fetch(`/admin/api/map-data?${params}`)
    .then(r => r.json())
    .then(data => {
        if (!data.length) return;
        const bounds = [];
        data.forEach(rumah => {
            const m = L.marker([rumah.latitude, rumah.longitude], { icon: markerIcon }).addTo(adminMap);
            m.bindPopup(`
                <div style="font-family:'Plus Jakarta Sans',sans-serif;min-width:200px">
                    <p style="font-weight:700;margin-bottom:4px">${rumah.nama_pemilik}</p>
                    <p style="font-size:11px;color:#666;margin-bottom:2px">NIK: ${rumah.nik}</p>
                    <p style="font-size:11px;color:#666;margin-bottom:2px">${rumah.kecamatan}, ${rumah.kabupaten}</p>
                    <p style="font-size:11px;color:#666">RT ${rumah.rt}/RW ${rumah.rw}</p>
                    <p style="font-size:11px;color:#059669;margin-top:4px">
                        ${rumah.tanggal_mulai_mudik} – ${rumah.tanggal_selesai_mudik}
                    </p>
                </div>
            `);
            bounds.push([rumah.latitude, rumah.longitude]);
        });
        adminMap.fitBounds(bounds, { padding: [30, 30] });
    });

// ─── Filter Kecamatan Dinamis ─────────────────────────────────────────────────
document.getElementById('filter_kabupaten').addEventListener('change', async function () {
    const kecSel = document.getElementById('filter_kecamatan');
    kecSel.innerHTML = '<option value="">Semua Kecamatan</option>';
    if (!this.value) return;

    try {
        const res  = await fetch(`/api/kecamatan?kabupaten=${encodeURIComponent(this.value)}`);
        const data = await res.json();
        data.forEach(kec => {
            const opt = document.createElement('option');
            opt.value = kec.nama;
            opt.textContent = kec.nama;
            kecSel.appendChild(opt);
        });
    } catch (e) {}
});
</script>
@endpush
