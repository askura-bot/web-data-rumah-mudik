{{-- Views/admin/detail --}}
@extends('layouts.AdminLayout')
@section('title', 'Detail — ' . $rumah->nama_pemilik)

@push('styles')
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    background: #f0f2f7;
    color: #1a1a2e;
    -webkit-text-size-adjust: 100%;
}
:root {
    --navy:   #0a1628;
    --blue:   #1a3a6b;
    --blue2:  #1e4a8a;
    --accent: #f5a623;
    --surf:   #f0f2f7;
    --border: #e2e6ee;
    --text:   #1a1a2e;
    --muted:  #64748b;
    --green:  #059669;
    --white:  #ffffff;
    --shadow: 0 1px 4px rgba(0,0,0,.07);
}

/* ── TOPBAR ─────────────────────── */
.topbar {
    background: var(--navy);
    position: sticky; top: 0; z-index: 999;
    border-bottom: 2px solid rgba(245,166,35,.3);
    box-shadow: 0 2px 12px rgba(0,0,0,.5);
}
.topbar-in {
    max-width: 900px; margin: 0 auto;
    padding: 0 1rem; height: 52px;
    display: flex; align-items: center; gap: 10px;
}
.btn-back {
    width: 32px; height: 32px; flex-shrink: 0;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.6); text-decoration: none;
    transition: all .2s;
}
.btn-back:hover { background: rgba(255,255,255,.14); color: #fff; }
.topbar-logo {
    width: 28px; height: 28px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--blue), #0d1f3c);
    border: 1.5px solid rgba(245,166,35,.4);
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
}
.topbar-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: .88rem; font-weight: 700; color: #fff;
    letter-spacing: .05em; text-transform: uppercase;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    flex: 1; min-width: 0;
}
.topbar-sub { font-size: .6rem; color: rgba(255,255,255,.35); }
@media (max-width: 400px) { .topbar-sub { display: none; } }

/* ── WRAP ───────────────────────── */
.wrap {
    max-width: 900px; margin: 0 auto;
    padding: 1rem; display: flex; flex-direction: column; gap: 1rem;
}

/* ── PANEL ──────────────────────── */
.panel {
    background: var(--white);
    border-radius: 14px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ph {
    padding: .75rem 1.125rem;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 7px;
    background: linear-gradient(135deg, #f8f9ff, #fff);
}
.ph-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.ph-title { font-weight: 700; font-size: .8rem; color: var(--text); }
.ph-sub { font-size: .68rem; color: var(--muted); margin-left: auto; }

/* ── PEMILIK HEADER ─────────────── */
.pemilik-head {
    padding: 1.25rem 1.125rem 1rem;
    display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;
    border-bottom: 1px solid var(--border);
}
.pemilik-nama {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1.4rem; font-weight: 800; color: var(--text);
    letter-spacing: .02em; line-height: 1.1;
}
.pemilik-nik {
    font-family: monospace; font-size: .78rem;
    color: var(--muted); margin-top: 4px; display: block;
}
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .68rem; font-weight: 600;
    padding: 3px 10px; border-radius: 99px; margin-top: 6px;
}
.status-badge.aktif {
    background: #dcfce7; color: #166534;
    border: 1px solid #bbf7d0;
}
.status-badge.selesai {
    background: #f1f5f9; color: #475569;
    border: 1px solid #e2e8f0;
}
.status-badge.belum {
    background: #fef9ec; color: #92400e;
    border: 1px solid #fde68a;
}

/* ── FOTO FULL ──────────────────── */
.foto-full-wrap {
    padding: 1rem 1.125rem;
    border-bottom: 1px solid var(--border);
}
.foto-full-inner {
    position: relative;
    background: #f8f9fb;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    overflow: hidden;
    cursor: zoom-in;
    max-height: 320px;
    display: flex; align-items: center; justify-content: center;
}
.foto-full-inner img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .3s ease;
}
.foto-full-inner:hover img { transform: scale(1.02); }
.foto-zoom-hint {
    position: absolute; bottom: 8px; right: 8px;
    background: rgba(0,0,0,.45); color: #fff;
    font-size: .65rem; font-weight: 600;
    padding: 4px 8px; border-radius: 6px;
    display: flex; align-items: center; gap: 4px;
    backdrop-filter: blur(4px); pointer-events: none;
}
.no-foto-box {
    padding: 2rem 1rem;
    text-align: center; color: var(--muted);
    border-bottom: 1px solid var(--border);
}
.no-foto-ic {
    width: 48px; height: 48px;
    background: var(--surf); border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 8px;
}

/* ── DATA GRID ──────────────────── */
.data-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
}
.data-grid .cell {
    padding: .875rem 1.125rem;
    border-bottom: 1px solid var(--border);
    border-right: 1px solid var(--border);
}
.data-grid .cell:nth-child(even) { border-right: none; }
.data-grid .cell:nth-last-child(-n+2) { border-bottom: none; }
/* last row odd count fix */
.data-grid .cell.full {
    grid-column: 1 / -1;
    border-right: none;
}
.cell-lbl {
    font-size: .65rem; font-weight: 700;
    color: var(--muted); letter-spacing: .06em;
    text-transform: uppercase; margin-bottom: 4px;
    display: flex; align-items: center; gap: 5px;
}
.cell-lbl svg { flex-shrink: 0; }
.cell-val {
    font-size: .84rem; font-weight: 600; color: var(--text);
    line-height: 1.4;
}
.cell-val.mono { font-family: monospace; font-size: .8rem; }
.cell-val.green { color: var(--green); }
.cell-val.accent { color: #92400e; }

@media (max-width: 480px) {
    .data-grid { grid-template-columns: 1fr; }
    .data-grid .cell { border-right: none; }
    .data-grid .cell:nth-last-child(-n+2) { border-bottom: 1px solid var(--border); }
    .data-grid .cell:last-child { border-bottom: none; }
    .pemilik-head { flex-direction: column; gap: .75rem; }
}

/* ── MAP ────────────────────────── */
#detail-map { height: 360px; }
@media (max-width: 640px) { #detail-map { height: 260px; } }

/* ── COORD BAR ──────────────────── */
.coord-bar {
    padding: .625rem 1.125rem;
    background: var(--surf);
    border-top: 1px solid var(--border);
    display: flex; align-items: center; gap: 8px;
    flex-wrap: wrap;
}
.coord-pill {
    font-family: monospace; font-size: .72rem;
    color: var(--blue2); background: rgba(26,58,107,.07);
    border: 1px solid rgba(26,58,107,.15);
    border-radius: 99px; padding: 3px 10px;
    white-space: nowrap;
}
.coord-lbl { font-size: .68rem; color: var(--muted); }

/* ── LIGHTBOX ───────────────────── */
.lightbox {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,.88);
    align-items: center; justify-content: center;
    padding: 1rem;
    cursor: zoom-out;
}
.lightbox.open { display: flex; }
.lightbox img {
    max-width: 100%; max-height: 90vh;
    border-radius: 10px;
    object-fit: contain;
    box-shadow: 0 8px 40px rgba(0,0,0,.6);
    cursor: default;
}
.lb-close {
    position: absolute; top: 1rem; right: 1rem;
    width: 36px; height: 36px;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
    border-radius: 8px; color: #fff;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .2s;
}
.lb-close:hover { background: rgba(255,255,255,.2); }
</style>
@endpush

@section('content')

@php
    $today = \Carbon\Carbon::today();
    $mulai = $rumah->tanggal_mulai_mudik;
    $selesai = $rumah->tanggal_selesai_mudik;
    if ($today->between($mulai, $selesai)) {
        $statusLabel = 'Sedang Mudik';
        $statusClass = 'aktif';
    } elseif ($today->lt($mulai)) {
        $statusLabel = 'Belum Berangkat';
        $statusClass = 'belum';
    } else {
        $statusLabel = 'Sudah Kembali';
        $statusClass = 'selesai';
    }
@endphp

{{-- TOPBAR --}}
<div class="topbar">
    <div class="topbar-in">
        <a href="{{ route('admin.data') }}" class="btn-back" title="Kembali">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="topbar-logo">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                <path fill="#f5a623" d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
            </svg>
        </div>
        <div style="min-width:0;flex:1">
            <div class="topbar-title">Detail Rumah Mudik</div>
            <div class="topbar-sub">{{ $rumah->nama_pemilik }}</div>
        </div>
    </div>
</div>

<div class="wrap">

    {{-- ═══ PANEL: INFO PEMILIK ═══ --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-dot" style="background:var(--blue2)"></div>
            <span class="ph-title">Informasi Pemilik</span>
            <span class="ph-sub">ID #{{ $rumah->id }}</span>
        </div>

        {{-- Nama + Status --}}
        <div class="pemilik-head">
            <div>
                <div class="pemilik-nama">{{ $rumah->nama_pemilik }}</div>
                <span class="pemilik-nik">NIK: {{ $rumah->nik }}</span>
                <span class="status-badge {{ $statusClass }}">
                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>
                    {{ $statusLabel }}
                </span>
            </div>
        </div>

        {{-- Foto Rumah Full --}}
        @if($rumah->foto_rumah)
        <div class="foto-full-wrap">
            <div class="foto-full-inner" id="foto-trigger">
                <img src="{{ Storage::url($rumah->foto_rumah) }}" alt="Foto Rumah {{ $rumah->nama_pemilik }}">
                <div class="foto-zoom-hint">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Klik untuk perbesar
                </div>
            </div>
        </div>
        @else
        <div class="no-foto-box">
            <div class="no-foto-ic">
                <svg width="20" height="20" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p style="font-size:.78rem">Foto rumah tidak tersedia</p>
        </div>
        @endif

        {{-- Data Grid --}}
        <div class="data-grid">
            <div class="cell full">
                <div class="cell-lbl">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Alamat Lengkap
                </div>
                <div class="cell-val">{{ $rumah->alamat_lengkap }}</div>
            </div>
            <div class="cell">
                <div class="cell-lbl">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                    RT / RW
                </div>
                <div class="cell-val">RT {{ $rumah->rt }} / RW {{ $rumah->rw }}</div>
            </div>
            <div class="cell">
                <div class="cell-lbl">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Kecamatan
                </div>
                <div class="cell-val">{{ $rumah->kecamatan }}</div>
            </div>
            <div class="cell">
                <div class="cell-lbl">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    Kabupaten
                </div>
                <div class="cell-val">{{ $rumah->kabupaten }}</div>
            </div>
            <div class="cell">
                <div class="cell-lbl">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Jadwal Mudik
                </div>
                <div class="cell-val green">
                    {{ $mulai->format('d M Y') }} – {{ $selesai->format('d M Y') }}
                </div>
            </div>
            <div class="cell">
                <div class="cell-lbl">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Didaftarkan
                </div>
                <div class="cell-val">{{ $rumah->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- ═══ PANEL: PETA ═══ --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-dot" style="background:#059669"></div>
            <span class="ph-title">Titik Lokasi Rumah</span>
        </div>
        <div id="detail-map"></div>
        <div class="coord-bar">
            <span class="coord-lbl">Koordinat:</span>
            <span class="coord-pill">{{ $rumah->latitude }}, {{ $rumah->longitude }}</span>
            <a href="https://www.google.com/maps?q={{ $rumah->latitude }},{{ $rumah->longitude }}"
               target="_blank"
               style="margin-left:auto;display:inline-flex;align-items:center;gap:4px;font-size:.68rem;font-weight:600;color:var(--blue2);text-decoration:none;padding:3px 8px;border-radius:6px;border:1px solid rgba(26,58,107,.2);background:rgba(26,58,107,.05);transition:all .2s"
               onmouseover="this.style.background='rgba(26,58,107,.1)'"
               onmouseout="this.style.background='rgba(26,58,107,.05)'">
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Buka di Google Maps
            </a>
        </div>
    </div>

</div>

{{-- LIGHTBOX --}}
@if($rumah->foto_rumah)
<div class="lightbox" id="lightbox" onclick="closeLb()">
    <button class="lb-close" onclick="closeLb()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    <img src="{{ Storage::url($rumah->foto_rumah) }}" alt="Foto Rumah" onclick="event.stopPropagation()">
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Peta Detail ──────────────────────────────────────────
    const lat = {{ $rumah->latitude }};
    const lng = {{ $rumah->longitude }};
    const map = L.map('detail-map').setView([lat, lng], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

    const icon = L.divIcon({
        html: `<div style="
            width:18px;height:18px;
            background:var(--navy,#0a1628);
            border-radius:50%;
            border:3px solid #f5a623;
            box-shadow:0 2px 8px rgba(0,0,0,.45)">
        </div>`,
        iconSize: [18,18], iconAnchor: [9,9], className: ''
    });

    L.marker([lat, lng], { icon }).addTo(map)
        .bindPopup(`
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;min-width:180px;line-height:1.5">
                <p style="font-weight:700;color:#0a1628;margin-bottom:4px">{{ $rumah->nama_pemilik }}</p>
                <p style="color:#64748b">{{ $rumah->alamat_lengkap }}</p>
            </div>`)
        .openPopup();

    // ── Lightbox ─────────────────────────────────────────────
    const trigger = document.getElementById('foto-trigger');
    if (trigger) {
        trigger.addEventListener('click', () => {
            document.getElementById('lightbox').classList.add('open');
            document.body.style.overflow = 'hidden';
        });
    }
});

function closeLb() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLb();
});
</script>
@endpush