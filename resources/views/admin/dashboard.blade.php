{{-- Views/admin/dashboard --}}
@extends('layouts.AdminLayout')
@section('title', 'Dashboard — Sistem Patroli Mudik')

@push('styles')
<style>
/* ═══════════════════════════════════════════════════
   RESET & BASE
═══════════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    background: #f0f2f7;
    color: #1a1a2e;
    -webkit-text-size-adjust: 100%;
}

/* ═══════════════════════════════════════════════════
   CSS VARIABLES
═══════════════════════════════════════════════════ */
:root {
    --navy:    #0a1628;
    --blue:    #1a3a6b;
    --blue2:   #1e4a8a;
    --accent:  #f5a623;
    --surf:    #f0f2f7;
    --border:  #e2e6ee;
    --text:    #1a1a2e;
    --muted:   #64748b;
    --green:   #059669;
    --white:   #ffffff;
    --radius:  12px;
    --shadow:  0 1px 4px rgba(0,0,0,.07);
}

/* ═══════════════════════════════════════════════════
   TOPBAR
═══════════════════════════════════════════════════ */
.topbar {
    background: var(--navy);
    position: sticky;
    top: 0;
    z-index: 999;
    border-bottom: 2px solid rgba(245,166,35,.3);
    box-shadow: 0 2px 12px rgba(0,0,0,.5);
}
.topbar-in {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
}
.t-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
    flex: 1;
}
.t-logo {
    width: 32px; height: 32px;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--blue), #0d1f3c);
    border: 1.5px solid rgba(245,166,35,.45);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
}
.t-text { min-width: 0; }
.t-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: .9rem; font-weight: 700;
    color: #fff; letter-spacing: .05em; text-transform: uppercase;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    display: block;
}
.t-sub {
    font-size: .6rem; color: rgba(255,255,255,.35);
    display: block; margin-top: 1px;
}
.t-right {
    display: flex; align-items: center; gap: 6px;
    flex-shrink: 0;
}
.t-badge {
    font-size: .68rem; font-weight: 600;
    color: var(--accent);
    background: rgba(245,166,35,.12);
    border: 1px solid rgba(245,166,35,.25);
    border-radius: 99px; padding: 3px 10px;
    white-space: nowrap;
}
.t-out {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .72rem; font-weight: 600;
    color: rgba(255,255,255,.6);
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 7px; padding: 5px 11px;
    text-decoration: none; transition: all .2s;
    white-space: nowrap;
}
.t-out:hover { color: #fff; background: rgba(255,255,255,.13); }
.t-out-txt { display: none; }

/* ── Wilayah dropdown ── */
.t-dropdown {
    position: relative;
}
.t-nav {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .72rem; font-weight: 600;
    color: rgba(255,255,255,.7);
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 7px; padding: 5px 10px;
    cursor: pointer; transition: all .2s; white-space: nowrap;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.t-nav:hover, .t-nav.open { color: #fff; background: rgba(255,255,255,.15); }
.t-nav-txt { display: none; }
@media (min-width: 500px) { .t-nav-txt { display: inline; } }
.t-chevron {
    transition: transform .2s;
    opacity: .6;
}
.t-nav.open .t-chevron { transform: rotate(180deg); opacity: 1; }

.t-menu {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: #fff;
    border: 1px solid #e2e6ee;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,.18);
    min-width: 210px;
    overflow: hidden;
    z-index: 1000;
    animation: menuDrop .15s ease;
}
.t-menu.open { display: block; }
@keyframes menuDrop {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.t-menu-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; text-decoration: none;
    transition: background .15s;
    border-bottom: 1px solid #f0f2f6;
}
.t-menu-item:last-child { border-bottom: none; }
.t-menu-item:hover { background: #f5f7ff; }
.t-menu-ico {
    width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.t-menu-label { font-size: .8rem; font-weight: 700; color: #0a1628; }
.t-menu-hint  { font-size: .67rem; color: #64748b; margin-top: 1px; }

@media (min-width: 500px) { .t-out-txt { display: inline; } }
@media (max-width: 499px) { .t-badge { display: none; } }
@media (max-width: 380px) { .t-sub { display: none; } }

/* ═══════════════════════════════════════════════════
   PAGE WRAPPER
═══════════════════════════════════════════════════ */
.wrap {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* ═══════════════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════════════ */
.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem;
}
.sc {
    background: var(--white);
    border-radius: var(--radius);
    padding: .875rem 1rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    display: flex; align-items: center; gap: 12px;
}
.sc-ico {
    width: 40px; height: 40px;
    border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.sc-ico.blue  { background: rgba(26,58,107,.1);  color: var(--blue2); }
.sc-ico.amber { background: rgba(245,166,35,.12); color: #c47d0e; }
.sc-ico.green { background: rgba(5,150,105,.1);  color: var(--green); }
.sc-val {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1.6rem; font-weight: 800;
    color: var(--text); line-height: 1;
    display: block;
}
.sc-lbl {
    font-size: .68rem; color: var(--muted);
    font-weight: 500; margin-top: 2px;
    display: block;
}

@media (max-width: 480px) {
    .stats { gap: .5rem; }
    .sc { padding: .75rem; gap: 8px; border-radius: 10px; }
    .sc-ico { width: 34px; height: 34px; border-radius: 8px; }
    .sc-ico svg { width: 15px; height: 15px; }
    .sc-val { font-size: 1.3rem; }
    .sc-lbl { font-size: .62rem; }
}

/* ═══════════════════════════════════════════════════
   PANEL
═══════════════════════════════════════════════════ */
.panel {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.ph {
    padding: .75rem 1rem;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    justify-content: space-between; gap: 8px;
    flex-wrap: wrap;
    background: linear-gradient(135deg, #f8f9ff 0%, #fff 100%);
}
.ph-title {
    display: flex; align-items: center; gap: 7px;
    font-weight: 700; font-size: .82rem; color: var(--text);
}
.ph-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.ph-hint { font-size: .68rem; color: var(--muted); }

/* ═══════════════════════════════════════════════════
   FILTER
═══════════════════════════════════════════════════ */
.fb { padding: .875rem 1rem; }
.fg {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr auto;
    gap: .625rem;
    align-items: end;
}
.fl {
    display: block; font-size: .67rem; font-weight: 700;
    color: var(--muted); letter-spacing: .06em;
    text-transform: uppercase; margin-bottom: 4px;
}
.fi {
    width: 100%; padding: 8px 11px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .8rem; font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text); background: #fff; outline: none;
    transition: border-color .2s, box-shadow .2s;
    -webkit-appearance: none; appearance: none;
}
.fi:focus {
    border-color: var(--blue2);
    box-shadow: 0 0 0 3px rgba(30,74,138,.1);
}
select.fi {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 9px center;
    background-size: 15px;
    padding-right: 30px;
    cursor: pointer;
}
.fa { display: flex; gap: .5rem; align-items: flex-end; }
.btn-s {
    flex: 1; padding: 8px 14px;
    background: var(--navy); color: #fff;
    font-size: .78rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
    border: none; border-radius: 8px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    white-space: nowrap; transition: background .2s;
}
.btn-s:hover { background: var(--blue); }
.btn-r {
    flex: 1; padding: 8px 12px;
    background: var(--surf); color: var(--muted);
    font-size: .78rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    white-space: nowrap; text-decoration: none; transition: all .2s;
}
.btn-r:hover { color: var(--text); border-color: #bac0cc; }

@media (max-width: 860px) {
    .fg { grid-template-columns: 1fr 1fr; }
    .fa { grid-column: 1 / -1; }
}
@media (max-width: 480px) {
    .fb { padding: .75rem; }
    .fg { grid-template-columns: 1fr; gap: .5rem; }
    .fa { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
}

/* ═══════════════════════════════════════════════════
   MAP
═══════════════════════════════════════════════════ */
#admin-map { height: 400px; }
@media (max-width: 640px) { #admin-map { height: 240px; } }

/* ═══════════════════════════════════════════════════
   SORT TOGGLE
═══════════════════════════════════════════════════ */
.sort-tgl {
    display: inline-flex; align-items: center;
    border: 1.5px solid var(--border); border-radius: 8px;
    overflow: hidden; background: var(--surf); flex-shrink: 0;
}
.srt {
    padding: 5px 10px; font-size: .7rem; font-weight: 600;
    color: var(--muted); background: none; border: none;
    cursor: pointer; display: flex; align-items: center; gap: 4px;
    transition: all .15s; white-space: nowrap; text-decoration: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.srt:hover { background: #eaecf5; color: var(--text); }
.srt.on { background: var(--navy); color: #fff; }
.srt-sep { width: 1px; background: var(--border); align-self: stretch; }

/* ═══════════════════════════════════════════════════
   TABLE — horizontal scroll on mobile
═══════════════════════════════════════════════════ */
.tbl-wrap {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
/* Hint scrollable on small screen */
.tbl-hint {
    display: none;
    padding: 6px 1rem;
    font-size: .67rem;
    color: var(--muted);
    background: #fffbf2;
    border-bottom: 1px solid #f5e8cc;
    gap: 5px;
    align-items: center;
}
@media (max-width: 767px) { .tbl-hint { display: flex; } }

table {
    width: 100%;
    min-width: 700px; /* ensures scroll kicks in before cramping */
    border-collapse: collapse;
}
thead tr { background: linear-gradient(135deg, #f0f4ff, #f8f9fb); }
th {
    padding: 9px 12px;
    text-align: left;
    font-size: .65rem; font-weight: 700;
    color: var(--muted); letter-spacing: .07em; text-transform: uppercase;
    white-space: nowrap; border-bottom: 1.5px solid var(--border);
}
td {
    padding: 10px 12px;
    border-bottom: 1px solid #f0f2f6;
    vertical-align: middle;
}
tr:last-child td { border-bottom: none; }
tbody tr { transition: background .12s; }
tbody tr:hover { background: #f5f7ff; }

.nik    { font-family: monospace; font-size: .77rem; color: #374151; }
.nama   { font-weight: 600; font-size: .82rem; color: var(--text); }
.kec-b  {
    display: inline-block; padding: 2px 9px;
    background: rgba(26,58,107,.08); color: var(--blue2);
    font-size: .69rem; font-weight: 600;
    border-radius: 99px; white-space: nowrap;
}
.rtrw  { font-size: .73rem; color: var(--muted); white-space: nowrap; }
.d1    { font-size: .76rem; font-weight: 600; color: var(--text); white-space: nowrap; }
.d2    { font-size: .69rem; color: var(--muted); white-space: nowrap; }
.tc    { font-size: .69rem; color: var(--muted); white-space: nowrap; }
.nbadge {
    display: inline-block;
    font-size: .63rem; background: #dcfce7; color: #166534;
    padding: 1px 6px; border-radius: 99px; font-weight: 600; margin-top: 3px;
}
.fthumb {
    width: 36px; height: 36px; border-radius: 7px;
    object-fit: cover; border: 1.5px solid var(--border); display: block;
}
.nofoto {
    width: 36px; height: 36px; border-radius: 7px;
    background: var(--surf); border: 1.5px dashed #cdd2dc;
    display: flex; align-items: center; justify-content: center;
}
.btn-det {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 12px; background: var(--navy); color: #fff;
    font-size: .7rem; font-weight: 600;
    border-radius: 7px; text-decoration: none;
    transition: background .2s; white-space: nowrap;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.btn-det:hover { background: var(--blue); }

/* ═══════════════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════════════ */
.empty-wrap {
    padding: 3rem 1rem; text-align: center; color: var(--muted);
}
.empty-ico {
    width: 50px; height: 50px;
    background: var(--surf); border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
}
.empty-txt { font-size: .85rem; }

/* ═══════════════════════════════════════════════════
   PAGINATION
═══════════════════════════════════════════════════ */
.pagi { padding: 10px 14px; border-top: 1px solid var(--border); }
.pagi nav { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; }
</style>
@endpush


{{-- Navbar --}}
@include('components.navbar-admin-dashboard')
    
{{-- Content --}}
@section('content')

<div class="wrap">

    {{-- ════ STAT CARDS ════ --}}
    @php
        $today   = \Carbon\Carbon::today();
        $total   = \App\Models\RumahMudik::count();
        $aktif   = \App\Models\RumahMudik::whereDate('tanggal_mulai_mudik', '<=', $today)
                        ->whereDate('tanggal_selesai_mudik', '>=', $today)->count();
        $hariIni = \App\Models\RumahMudik::whereDate('created_at', $today)->count();
    @endphp
    <div class="stats">
        <div class="sc">
            <div class="sc-ico blue">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <span class="sc-val">{{ $total }}</span>
                <span class="sc-lbl">Total Rumah</span>
            </div>
        </div>
        <div class="sc">
            <div class="sc-ico amber">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <span class="sc-val">{{ $aktif }}</span>
                <span class="sc-lbl">Sedang Mudik</span>
            </div>
        </div>
        <div class="sc">
            <div class="sc-ico green">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <span class="sc-val">{{ $hariIni }}</span>
                <span class="sc-lbl">Hari Ini</span>
            </div>
        </div>
    </div>

    {{-- ════ FILTER ════ --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:var(--blue2)"></div>
                Filter & Pencarian
            </div>
        </div>
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <div class="fb">
                <div class="fg">
                    <div>
                        <label class="fl">Cari NIK</label>
                        <input type="text" name="nik" value="{{ request('nik') }}" class="fi" placeholder="Masukkan NIK...">
                    </div>
                    <div>
                        <label class="fl">Kecamatan</label>
                        <select name="kecamatan" class="fi">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->nama }}" {{ request('kecamatan') == $kec->nama ? 'selected' : '' }}>
                                    {{ $kec->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="fl">Urutkan</label>
                        <select name="sort" class="fi">
                            <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Data Terbaru</option>
                            <option value="terlama" {{ $sort === 'terlama' ? 'selected' : '' }}>Data Terlama</option>
                        </select>
                    </div>
                    <div class="fa">
                        <button type="submit" class="btn-s">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cari
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn-r">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ════ PETA ════ --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:#059669"></div>
                Sebaran Lokasi Rumah
            </div>
            <span class="ph-hint">Klik marker untuk detail</span>
        </div>
        <div id="admin-map"></div>
    </div>

    {{-- ════ TABEL ════ --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:var(--accent)"></div>
                Data Rumah
                <span style="font-weight:400;color:var(--muted);font-size:.72rem">({{ $rumahList->total() }})</span>
            </div>
            <div class="sort-tgl">
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru', 'page' => 1]) }}"
                class="srt {{ $sort === 'terbaru' ? 'on' : '' }}">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                    </svg>
                    Data Terbaru
                </a>
                <div class="srt-sep"></div>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'terlama', 'page' => 1]) }}"
                class="srt {{ $sort === 'terlama' ? 'on' : '' }}">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                    </svg>
                    Data Terlama
                </a>
            </div>
        </div>

        {{-- Hint geser di mobile --}}
        <div class="tbl-hint">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Geser kanan/kiri untuk melihat semua kolom
        </div>

        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIK</th>
                        <th>Nama Pemilik</th>
                        <th>Kecamatan</th>
                        <th>RT / RW</th>
                        <th>Jadwal Mudik</th>
                        <th>Foto</th>
                        <th>Didaftarkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rumahList as $rumah)
                    @php $isNew = $rumah->created_at->diffInHours(now()) <= 24; @endphp
                    <tr>
                        <td style="color:var(--muted);font-size:.68rem">
                            {{ $loop->iteration + ($rumahList->currentPage() - 1) * $rumahList->perPage() }}
                        </td>
                        <td><span class="nik">{{ $rumah->nik }}</span></td>
                        <td><span class="nama">{{ $rumah->nama_pemilik }}</span></td>
                        <td><span class="kec-b">{{ $rumah->kecamatan }}</span></td>
                        <td><span class="rtrw">{{ $rumah->rt }} / {{ $rumah->rw }}</span></td>
                        <td>
                            <div class="d1">{{ $rumah->tanggal_mulai_mudik->format('d M Y') }}</div>
                            <div class="d2">s/d {{ $rumah->tanggal_selesai_mudik->format('d M Y') }}</div>
                        </td>
                        <td>
                            @if($rumah->foto_rumah)
                                <img src="{{ Storage::url($rumah->foto_rumah) }}" class="fthumb" alt="">
                            @else
                                <div class="nofoto">
                                    <svg width="14" height="14" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="tc">{{ $rumah->created_at->format('d M Y') }}</div>
                            <div class="tc">{{ $rumah->created_at->format('H:i') }}</div>
                            @if($isNew)<span class="nbadge">Baru</span>@endif
                        </td>
                        <td>
                            <a href="{{ route('admin.show', $rumah) }}" class="btn-det">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-wrap">
                                <div class="empty-ico">
                                    <svg width="22" height="22" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <p class="empty-txt">Belum ada data yang sesuai filter</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rumahList->hasPages())
        <div class="pagi">{{ $rumahList->links() }}</div>
        @endif
    </div>

</div>{{-- .wrap --}}

@endsection

{{-- Script.JS --}}
@push('scripts')
<script>

    // Dropdown Wilayah
    function toggleDropdown() {
        const btn  = document.querySelector('.t-nav');
        const menu = document.getElementById('wilayah-menu');
        btn.classList.toggle('open');
        menu.classList.toggle('open');
    }
    // Tutup saat klik di luar
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('wilayah-dropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            document.querySelector('.t-nav')?.classList.remove('open');
            document.getElementById('wilayah-menu')?.classList.remove('open');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('admin-map').setView([-7.1751, 110.4028], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors', maxZoom: 19
        }).addTo(map);

        const icon = L.divIcon({
            html: '<div style="width:11px;height:11px;background:#1a3a6b;border-radius:50%;border:2.5px solid #f5a623;box-shadow:0 2px 5px rgba(0,0,0,.4)"></div>',
            iconSize: [11,11], iconAnchor: [5,5], className: ''
        });

        const p = new URLSearchParams({
            @if(request('kecamatan')) kecamatan: '{{ request('kecamatan') }}', @endif
            @if(request('nik'))       nik: '{{ request('nik') }}',             @endif
        });

        fetch('/admin/api/map-data?' + p)
            .then(r => r.json())
            .then(data => {
                if (!data.length) return;
                const bounds = [];
                data.forEach(r => {
                    L.marker([r.latitude, r.longitude], { icon }).addTo(map)
                        .bindPopup(`
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;min-width:190px;font-size:12px;line-height:1.5">
                                <p style="font-weight:700;color:#0a1628;margin-bottom:5px;font-size:13px">${r.nama_pemilik}</p>
                                <p style="color:#64748b;margin-bottom:2px">NIK: <b style="color:#374151">${r.nik}</b></p>
                                <p style="color:#64748b;margin-bottom:2px">Kec. ${r.kecamatan} · RT ${r.rt}/RW ${r.rw}</p>
                                <div style="margin-top:6px;padding-top:6px;border-top:1px solid #e2e6ee">
                                    <p style="font-weight:600;color:#1a3a6b;font-size:11px">${r.tanggal_mulai_mudik} s/d ${r.tanggal_selesai_mudik}</p>
                                </div>
                            </div>`);
                    bounds.push([r.latitude, r.longitude]);
                });
                map.fitBounds(bounds, { padding: [40, 40] });
            });
    });

</script>
@endpush