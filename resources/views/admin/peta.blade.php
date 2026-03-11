{{-- resources/views/admin/peta.blade.php --}}
@extends('layouts.AdminLayout')
@section('title', 'Peta Sebaran — Sistem Patroli Mudik')

@push('styles')
@include('components.admin-shared-styles')
<style>
/* Hapus padding default popup Leaflet */
.popup-clean .leaflet-popup-content-wrapper {
    padding: 0;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(0,0,0,.18);
}
.popup-clean .leaflet-popup-content {
    margin: 0;
    width: 240px !important;
}
.popup-clean .leaflet-popup-tip-container {
    margin-top: -1px;
}

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

    @include('components.stats-cards-admin-dasboard')

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

                    {{-- Kelurahan (dinamis) --}}
                    <div>
                        <label class="fl">Kelurahan / Desa</label>
                        <select name="kelurahan" id="f-kelurahan" class="fi">
                            <option value="">Semua Kelurahan</option>
                            @if(request('kelurahan'))
                                <option value="{{ request('kelurahan') }}" selected>{{ request('kelurahan') }}</option>
                            @endif
                        </select>
                    </div>

                    {{-- RT & RW --}}
                    <div>
                        <span class="fi-group-label">RT &amp; <p class="fi-hint">004 / 04 / 4 dianggap sama</p> </span>
                        <div class="fi-rt-rw">
                            <input type="text" name="rt" id="f-rt" value="{{ request('rt') }}"
                                class="fi" placeholder="RT" inputmode="numeric"
                                oninput="this.value=this.value.replace(/\D/g,'')">
                            <input type="text" name="rw" id="f-rw" value="{{ request('rw') }}"
                                class="fi" placeholder="RW" inputmode="numeric"
                                oninput="this.value=this.value.replace(/\D/g,'')">
                        </div>
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
                <svg width="15" height="25" viewBox="0 0 28 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 0C6.268 0 0 6.268 0 14C0 24.5 14 36 14 36C14 36 28 24.5 28 14C28 6.268 21.732 0 14 0Z" fill="#1a3a6b" stroke="#f5a623" stroke-width="2"/>
                    <circle cx="14" cy="14" r="5" fill="white" opacity="0.9"/>
                </svg>
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
// Fungsi untuk memuat kelurahan berdasarkan kecamatan
function fetchKelurahan(kecamatanNama) {
    const kelurahanSelect = document.getElementById('f-kelurahan');
    
    // Reset dropdown
    kelurahanSelect.innerHTML = '<option value="">Semua Kelurahan</option>';
    
    if (!kecamatanNama) {
        return;
    }

    kelurahanSelect.disabled = true;

    fetch(`{{ route('admin.api.kelurahans') }}?kecamatan=${encodeURIComponent(kecamatanNama)}`)
        .then(response => response.json())
        .then(data => {
            kelurahanSelect.disabled = false;
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.nama;
                option.textContent = item.nama;
                kelurahanSelect.appendChild(option);
            });

            // Set nilai selected jika ada parameter kelurahan di URL
            const urlParams = new URLSearchParams(window.location.search);
            const selectedKel = urlParams.get('kelurahan');
            if (selectedKel) {
                kelurahanSelect.value = selectedKel;
            }
        })
        .catch(error => {
            console.error('Gagal memuat kelurahan:', error);
            kelurahanSelect.disabled = false;
        });
}

// Event listener untuk perubahan kecamatan
document.getElementById('f-kecamatan').addEventListener('change', function() {
    fetchKelurahan(this.value);
});

// Saat halaman dimuat, jika sudah ada kecamatan terpilih, muat kelurahan
document.addEventListener('DOMContentLoaded', function() {
    const kecamatanSelect = document.getElementById('f-kecamatan');
    if (kecamatanSelect.value) {
        fetchKelurahan(kecamatanSelect.value);
    }
});

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

// Format "2025-03-28T00:00:00" → "28 Mar 2025"
function formatTanggal(str) {
    if (!str) return '—';
    const d = new Date(str);
    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
}

// ── Peta ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('admin-map').setView([-7.1751, 110.4028], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

    // Hapus const icon = L.divIcon(...) yang lama, ganti dengan:
    let _pinId = 0;
    function makeIcon() {
        const id = 'pg' + (++_pinId);
        return L.divIcon({
            html: `<svg width="28" height="36" viewBox="0 0 28 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="${id}" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#1e4a8a"/>
                        <stop offset="100%" stop-color="#0a1628"/>
                    </linearGradient>
                </defs>
                <path d="M14 0C6.268 0 0 6.268 0 14C0 24.5 14 36 14 36C14 36 28 24.5 28 14C28 6.268 21.732 0 14 0Z"
                    fill="url(#${id})" stroke="#f5a623" stroke-width="2"/>
                <circle cx="14" cy="14" r="5" fill="white" opacity="0.9"/>
            </svg>`,
            iconSize:   [28, 36],
            iconAnchor: [14, 36],
            popupAnchor:[0, -38],
            className:  ''
        });
    }

    let layerGroup = L.layerGroup().addTo(map);

    function buildParams() {
    const p = new URLSearchParams();
    const nik = document.getElementById('f-nik').value.trim();
    const kec = document.getElementById('f-kecamatan').value;
    const kel = document.getElementById('f-kelurahan').value; // tambahan
    const rt  = document.getElementById('f-rt').value.trim();
    const rw  = document.getElementById('f-rw').value.trim();
    if (nik) p.set('nik', nik);
    if (kec) p.set('kecamatan', kec);
    if (kel) p.set('kelurahan', kel); // tambahan
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
                    L.marker([r.latitude, r.longitude], { icon: makeIcon() })
                        .bindPopup(`
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;width:240px;font-size:12px;line-height:1.5;overflow:hidden">

                                {{-- Foto rumah --}}
                                ${r.foto_rumah
                                    ? `<div style="margin:-1px -1px 10px -1px;height:110px;overflow:hidden;border-radius:4px 4px 0 0">
                                        <img src="/storage/${r.foto_rumah}"
                                            style="width:100%;height:100%;object-fit:cover;display:block">
                                    </div>`
                                    : `<div style="margin:-1px -1px 10px -1px;height:80px;background:linear-gradient(135deg,#e8edf5,#f0f4ff);display:flex;align-items:center;justify-content:center;border-radius:4px 4px 0 0">
                                        <svg width="32" height="32" fill="none" stroke="#94a3b8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>`
                                }

                                {{-- Nama --}}
                                <div style="padding:0 12px">
                                    <p style="font-weight:800;color:#0a1628;font-size:13px;margin-bottom:8px;line-height:1.3">
                                        ${r.nama_pemilik}
                                    </p>

                                    {{-- NIK --}}
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:5px">
                                        <svg width="11" height="11" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" style="flex-shrink:0">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                                        </svg>
                                        <span style="color:#64748b">NIK: </span>
                                        <span style="font-family:monospace;font-weight:600;color:#374151;font-size:11px">${r.nik}</span>
                                    </div>

                                    {{-- Kecamatan + RT/RW --}}
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:5px">
                                        <svg width="11" height="11" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" style="flex-shrink:0">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span style="color:#1e4a8a;font-weight:600">${r.kecamatan}</span>
                                        <span style="color:#cbd5e1">·</span>
                                        <span style="color:#64748b">RT <b style="color:#374151">${r.rt}</b> / RW <b style="color:#374151">${r.rw}</b></span>
                                    </div>

                                    {{-- Alamat --}}
                                    <div style="display:flex;gap:6px;margin-bottom:8px">
                                        <svg width="11" height="11" fill="none" stroke="#94a3b8" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:2px">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        <span style="color:#64748b;font-size:11px;line-height:1.4">${r.alamat_lengkap ?? '—'}</span>
                                    </div>

                                    {{-- Jadwal mudik --}}
                                    <div style="background:#f0f4ff;border-radius:7px;padding:6px 9px;margin-bottom:10px;display:flex;align-items:center;gap:6px">
                                        <svg width="11" height="11" fill="none" stroke="#1e4a8a" viewBox="0 0 24 24" style="flex-shrink:0">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span style="font-size:11px;font-weight:600;color:#1e4a8a">
                                            ${formatTanggal(r.tanggal_mulai_mudik)}
                                            <span style="font-weight:400;color:#64748b">s/d</span>
                                            ${formatTanggal(r.tanggal_selesai_mudik)}
                                        </span>
                                    </div>

                                    {{-- Tombol detail --}}
                                    <a href="/admin/rumah/${r.id}"
                                        style="display:flex;align-items:center;justify-content:center;gap:5px;
                                            width:100%;padding:7px;margin-bottom:10px;
                                            background:#0a1628;color:#fff;
                                            font-size:11px;font-weight:700;
                                            border-radius:8px;text-decoration:none;
                                            transition:background .2s"
                                        onmouseover="this.style.background='#1a3a6b'"
                                        onmouseout="this.style.background='#0a1628'">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail Rumah
                                    </a>
                                </div>
                            </div>`, {
                                maxWidth: 260,
                                padding: 0,       // hilangkan padding default Leaflet
                                className: 'popup-clean'
                            })
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
    document.getElementById('f-kelurahan').innerHTML = '<option value="">Semua Kelurahan</option>'; // reset dropdown
    document.getElementById('f-rt').value = '';
    document.getElementById('f-rw').value = '';
    loadMarkers();
    };
});
</script>
@endpush