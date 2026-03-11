{{-- resources/views/admin/peta.blade.php --}}
@extends('layouts.AdminLayout')
@section('title', 'Peta Sebaran — Sistem Patroli Mudik')

@push('styles')
@include('components.admin-shared-styles')
<style>
#admin-map {
    height: calc(100vh - 52px - 2rem - 56px - 74px - 1rem);
    min-height: 360px;
}
@media (max-width: 640px) {
    #admin-map { height: 55vh; min-height: 280px; }
}

/* Legend */
.map-legend {
    display: flex; gap: 1rem; flex-wrap: wrap;
    padding: .625rem 1rem;
    border-top: 1px solid var(--border);
    background: #fafbff;
}
.legend-item { display: flex; align-items: center; gap: 6px; font-size: .72rem; color: var(--muted); }
.legend-dot  { width: 11px; height: 11px; border-radius: 50%; border: 2.5px solid #f5a623; flex-shrink: 0; }
.legend-dot.blue  { background: #1a3a6b; }
.legend-dot.green { background: #059669; border-color: #34d399; }

/* Counter badge */
.map-count {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1rem; font-weight: 700;
    color: var(--navy);
}
.map-count span { font-weight: 400; font-size: .75rem; color: var(--muted); margin-left: 3px; }
</style>
@endpush

@section('content')

@include('components.navbar-admin-dashboard', ['activePage' => 'peta'])

<div class="wrap">

    {{-- ── Filter ── --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:#059669"></div>
                Filter Peta
            </div>
            <span class="ph-hint" id="map-counter">Memuat marker...</span>
        </div>
        <form id="filter-form" method="GET" action="{{ route('admin.peta') }}">
            <div class="fb">
                <div class="fg">
                    {{-- NIK --}}
                    <div>
                        <label class="fl">Cari NIK</label>
                        <input type="text" name="nik" id="f-nik" value="{{ request('nik') }}"
                            class="fi" placeholder="Nomor induk kependudukan...">
                    </div>

                    {{-- Kecamatan --}}
                    <div>
                        <label class="fl">Kecamatan</label>
                        <select name="kecamatan" id="f-kecamatan" class="fi">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->nama }}"
                                    {{ request('kecamatan') == $kec->nama ? 'selected' : '' }}>
                                    {{ $kec->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- RT & RW --}}
                    <div>
                        <span class="fi-group-label">RT &amp; RW</span>
                        <div class="fi-rt-rw">
                            <input type="text" name="rt" id="f-rt" value="{{ request('rt') }}"
                                class="fi" placeholder="RT" inputmode="numeric"
                                oninput="this.value=this.value.replace(/\D/g,'')">
                            <input type="text" name="rw" id="f-rw" value="{{ request('rw') }}"
                                class="fi" placeholder="RW" inputmode="numeric"
                                oninput="this.value=this.value.replace(/\D/g,'')">
                        </div>
                        <p class="fi-hint">004 / 04 / 4 dianggap sama</p>
                    </div>

                    <div class="fa">
                        <button type="button" class="btn-s" onclick="applyFilter()">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Terapkan
                        </button>
                        <button type="button" class="btn-r" onclick="resetFilter()">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ── Peta ── --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:#059669"></div>
                Sebaran Lokasi Rumah
            </div>
            <span class="ph-hint">Klik marker untuk detail</span>
        </div>
        <div id="admin-map"></div>
        <div class="map-legend">
            <div class="legend-item">
                <div class="legend-dot blue"></div>
                Rumah terdaftar
            </div>
            <div class="legend-item" style="margin-left:auto">
                <span id="marker-count" class="map-count">— <span>marker</span></span>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ── Dropdown ──────────────────────────────────────────────────────────────────
function toggleDropdown(e) {
    e.stopPropagation();
    document.getElementById('wilayah-btn').classList.toggle('open');
    document.getElementById('wilayah-menu').classList.toggle('open');
}
document.addEventListener('click', function () {
    document.getElementById('wilayah-btn')?.classList.remove('open');
    document.getElementById('wilayah-menu')?.classList.remove('open');
});

// ── Peta ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('admin-map').setView([-7.1751, 110.4028], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

    const icon = L.divIcon({
        html: '<div style="width:11px;height:11px;background:#1a3a6b;border-radius:50%;border:2.5px solid #f5a623;box-shadow:0 2px 5px rgba(0,0,0,.4)"></div>',
        iconSize: [11, 11], iconAnchor: [5, 5], className: ''
    });

    let layerGroup = L.layerGroup().addTo(map);

    function buildParams() {
        const p = new URLSearchParams();
        const nik = document.getElementById('f-nik').value.trim();
        const kec = document.getElementById('f-kecamatan').value;
        const rt  = document.getElementById('f-rt').value.trim();
        const rw  = document.getElementById('f-rw').value.trim();
        if (nik) p.set('nik', nik);
        if (kec) p.set('kecamatan', kec);
        if (rt)  p.set('rt', rt);
        if (rw)  p.set('rw', rw);
        return p;
    }

    function loadMarkers() {
        document.getElementById('map-counter').textContent = 'Memuat...';
        document.getElementById('marker-count').innerHTML  = '— <span>marker</span>';
        layerGroup.clearLayers();

        fetch('/admin/api/map-data?' + buildParams())
            .then(r => r.json())
            .then(data => {
                if (!data.length) {
                    document.getElementById('map-counter').textContent = 'Tidak ada data';
                    document.getElementById('marker-count').innerHTML  = '0 <span>marker</span>';
                    return;
                }

                const bounds = [];
                data.forEach(r => {
                    L.marker([r.latitude, r.longitude], { icon })
                        .bindPopup(`
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;min-width:200px;font-size:12px;line-height:1.6">
                                <p style="font-weight:700;color:#0a1628;margin-bottom:5px;font-size:13px">${r.nama_pemilik}</p>
                                <p style="color:#64748b;margin-bottom:2px">NIK: <b style="color:#374151">${r.nik}</b></p>
                                <p style="color:#64748b;margin-bottom:2px">
                                    Kec. <b style="color:#1e4a8a">${r.kecamatan}</b>
                                    · RT <b>${r.rt}</b>/RW <b>${r.rw}</b>
                                </p>
                                <p style="color:#64748b;font-size:11px;margin-bottom:4px">${r.alamat_lengkap ?? ''}</p>
                                <div style="margin-top:6px;padding-top:6px;border-top:1px solid #e2e6ee">
                                    <p style="font-weight:600;color:#1a3a6b;font-size:11px">
                                        ${r.tanggal_mulai_mudik} s/d ${r.tanggal_selesai_mudik}
                                    </p>
                                </div>
                            </div>`)
                        .addTo(layerGroup);
                    bounds.push([r.latitude, r.longitude]);
                });

                map.fitBounds(bounds, { padding: [40, 40] });

                const n = data.length;
                document.getElementById('map-counter').textContent = n + ' titik ditemukan';
                document.getElementById('marker-count').innerHTML  = n + ' <span>marker</span>';
            })
            .catch(() => {
                document.getElementById('map-counter').textContent = 'Gagal memuat data';
            });
    }

    // Load awal dengan filter dari URL jika ada
    loadMarkers();

    // Expose ke tombol form
    window.applyFilter = function () { loadMarkers(); };
    window.resetFilter = function () {
        document.getElementById('f-nik').value = '';
        document.getElementById('f-kecamatan').value = '';
        document.getElementById('f-rt').value = '';
        document.getElementById('f-rw').value = '';
        loadMarkers();
    };
});
</script>
@endpush