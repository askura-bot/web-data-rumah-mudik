@extends('layouts.AdminLayout')
@section('title', 'Manajemen Kecamatan — Sistem Patroli Mudik')

@push('styles')
<style>
/* ── Reuse dashboard variables dengan palette baru ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    background: #f0f2f7;
    color: #1a1a2e;
}
:root {
    --navy:   #1C1C1C;   /* Blackboard */
    --blue:   #3B3B3B;   /* Rich Grey */
    --blue2:  #FFE002;   /* Golden Yellow */
    --accent: #FFB606;   /* Intense Fire */
    --gold-dark: #B28228; /* University of California Gold */
    --surf:   #F5F5F5;
    --border: #E0E0E0;
    --text:   #1C1C1C;
    --muted:  #6B7280;
    --green:  #FFB606;   /* Intense Fire untuk success */
    --red:    #B28228;   /* Gold-dark untuk warning/delete */
    --white:  #FFFFFF;
    --radius: 12px;
    --shadow: 0 1px 4px rgba(0,0,0,.07);
}

/* ── Topbar (disesuaikan dengan palette) ── */
.topbar {
    background: var(--navy);
    position: sticky; top: 0; z-index: 999;
    border-bottom: 2px solid var(--accent);
    box-shadow: 0 2px 12px rgba(0,0,0,.5);
}
.topbar-in {
    max-width: 1400px; margin: 0 auto;
    padding: 0 1rem; height: 52px;
    display: flex; align-items: center; justify-content: space-between; gap: .5rem;
}
.t-brand { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; }
.t-logo {
    width: 32px; height: 32px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.t-logo svg path { fill: var(--navy); } /* Ubah warna bintang jadi hitam agar kontras */
.t-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: .9rem; font-weight: 700;
    color: #fff; letter-spacing: .05em; text-transform: uppercase;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block;
}
.t-sub { font-size: .6rem; color: rgba(255,255,255,.35); display: block; margin-top: 1px; }
.t-right { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.t-out {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .72rem; font-weight: 600;
    color: rgba(255,255,255,.6);
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 7px; padding: 5px 11px;
    text-decoration: none; transition: all .2s; white-space: nowrap;
}
.t-out:hover { color: #fff; background: rgba(255,255,255,.13); }
.t-back {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .72rem; font-weight: 600;
    color: rgba(255,255,255,.7);
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 7px; padding: 5px 11px;
    text-decoration: none; transition: all .2s; white-space: nowrap;
}
.t-back:hover { color: #fff; background: rgba(255,255,255,.15); }

/* ── Wrap ── */
.wrap { max-width: 1400px; margin: 0 auto; padding: 1rem; display: flex; flex-direction: column; gap: 1rem; }

/* ── Page header breadcrumb ── */
.page-hd {
    display: flex; align-items: center; justify-content: space-between;
    gap: .75rem; flex-wrap: wrap;
}
.breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: .72rem; color: var(--muted);
}
.breadcrumb a { color: var(--blue2); text-decoration: none; font-weight: 600; }
.breadcrumb a:hover { text-decoration: underline; }
.breadcrumb-sep { color: #cbd5e1; }
.page-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1.3rem; font-weight: 800;
    color: var(--navy); letter-spacing: .03em;
}

/* ── Alert ── */
.alert {
    padding: .75rem 1rem;
    border-radius: var(--radius);
    font-size: .8rem; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
}
.alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #166534; }
.alert-error   { background: #fff5f5; border: 1.5px solid #fecaca; color: #991b1b; }

/* ── Panel ── */
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
    display: flex; align-items: center; justify-content: space-between; gap: 8px;
    background: linear-gradient(135deg, #f8f9ff, #fff);
    flex-wrap: wrap;
}
.ph-title {
    display: flex; align-items: center; gap: 7px;
    font-weight: 700; font-size: .82rem; color: var(--text);
}
.ph-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.ph-hint { font-size: .68rem; color: var(--muted); }

/* ── Add form ── */
.add-form { padding: 1rem; border-bottom: 1px solid var(--border); background: #fafbff; }
.add-row { display: flex; gap: .625rem; align-items: flex-end; }
.add-row .fi-wrap { flex: 1; }
.fl { display: block; font-size: .67rem; font-weight: 700; color: var(--muted); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 4px; }
.fi {
    width: 100%; padding: 8px 11px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .8rem; font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text); background: #fff; outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.fi:focus { border-color: var(--blue2); box-shadow: 0 0 0 3px rgba(255,224,2,.1); }
.fi.error { border-color: var(--red); }
.fi-err { font-size: .68rem; color: var(--red); margin-top: 3px; }
.btn-add {
    padding: 8px 18px;
    background: var(--navy); color: #fff;
    font-size: .78rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
    border: none; border-radius: 8px; cursor: pointer;
    display: inline-flex; align-items: center; gap: 5px;
    white-space: nowrap; transition: background .2s; flex-shrink: 0;
}
.btn-add:hover { background: var(--blue); }

/* ── Filter bar ── */
.filter-bar { padding: .75rem 1rem; border-bottom: 1px solid var(--border); display: flex; gap: .5rem; }
.search-wrap { position: relative; flex: 1; max-width: 320px; }
.search-wrap svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
.search-input {
    width: 100%; padding: 7px 11px 7px 32px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .78rem; font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text); background: #fff; outline: none;
    transition: border-color .2s;
}
.search-input:focus { border-color: var(--blue2); }
.btn-search {
    padding: 7px 14px;
    background: var(--surf); color: var(--muted);
    font-size: .75rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer;
    display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;
    transition: all .2s; text-decoration: none;
}
.btn-search:hover { color: var(--text); border-color: #bac0cc; }
.btn-search.active { background: var(--navy); color: #fff; border-color: var(--navy); }

/* ── Table ── */
.tbl-wrap { width: 100%; overflow-x: auto; }
table { width: 100%; border-collapse: collapse; min-width: 500px; }
thead tr { background: linear-gradient(135deg, #fafafa, #f5f5f5); }
th {
    padding: 9px 12px; text-align: left;
    font-size: .65rem; font-weight: 700; color: var(--muted);
    letter-spacing: .07em; text-transform: uppercase;
    white-space: nowrap; border-bottom: 1.5px solid var(--border);
}
td {
    padding: 10px 12px; border-bottom: 1px solid #f0f2f6;
    vertical-align: middle;
}
tr:last-child td { border-bottom: none; }
tbody tr:hover { background: rgba(255,182,6,0.05); }

.kec-name { font-weight: 600; font-size: .85rem; color: var(--text); }
.kec-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 9px;
    background: rgba(255,224,2,0.1); color: var(--navy);
    font-size: .69rem; font-weight: 600; border-radius: 99px;
}
.act-row { display: flex; gap: 6px; }

/* Edit inline form */
.edit-form { display: none; }
.edit-form.open { display: flex; gap: 6px; align-items: center; }
.edit-input {
    flex: 1; padding: 6px 10px;
    border: 1.5px solid var(--blue2); border-radius: 7px;
    font-size: .8rem; font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none; color: var(--text);
    box-shadow: 0 0 0 3px rgba(255,224,2,.1);
}
.btn-save {
    padding: 6px 12px;
    background: var(--green); color: #fff;
    font-size: .73rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
    border: none; border-radius: 7px; cursor: pointer;
    display: inline-flex; align-items: center; gap: 4px;
    transition: opacity .2s; white-space: nowrap;
}
.btn-save:hover { opacity: .85; }
.btn-cancel {
    padding: 6px 10px;
    background: var(--surf); color: var(--muted);
    font-size: .73rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid var(--border); border-radius: 7px; cursor: pointer;
    transition: all .2s;
}
.btn-cancel:hover { color: var(--text); }
.btn-edit {
    padding: 5px 11px;
    background: rgba(255,224,2,0.1); color: var(--navy);
    font-size: .72rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid rgba(255,224,2,0.3); border-radius: 7px; cursor: pointer;
    display: inline-flex; align-items: center; gap: 4px;
    transition: all .2s; white-space: nowrap;
}
.btn-edit:hover { background: rgba(255,224,2,0.2); }
.btn-del {
    padding: 5px 11px;
    background: rgba(178,130,40,0.1); color: var(--gold-dark);
    font-size: .72rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid rgba(178,130,40,0.3); border-radius: 7px; cursor: pointer;
    display: inline-flex; align-items: center; gap: 4px;
    transition: all .2s; white-space: nowrap;
}
.btn-del:hover { background: rgba(178,130,40,0.2); }

/* ── Empty ── */
.empty-wrap { padding: 3rem 1rem; text-align: center; color: var(--muted); }
.empty-ico {
    width: 48px; height: 48px; background: var(--surf); border-radius: 12px;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;
}

/* ── Pagination ── */
.pagi { padding: 10px 14px; border-top: 1px solid var(--border); }
.pagi nav { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; }

/* ── Delete modal ── */
.modal-bg {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.45); z-index: 1000;
    align-items: center; justify-content: center; padding: 1rem;
}
.modal-bg.open { display: flex; }
.modal {
    background: #fff; border-radius: 16px;
    padding: 1.5rem; width: 100%; max-width: 380px;
    box-shadow: 0 20px 60px rgba(0,0,0,.25);
    animation: modalIn .2s ease;
}
@keyframes modalIn { from { transform: scale(.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.modal-ico {
    width: 44px; height: 44px; border-radius: 12px;
    background: rgba(178,130,40,0.1); display: flex; align-items: center; justify-content: center;
    margin-bottom: .75rem;
}
.modal-ico svg { stroke: var(--gold-dark); }
.modal-title { font-weight: 800; font-size: .95rem; color: var(--navy); margin-bottom: 4px; }
.modal-body  { font-size: .78rem; color: var(--muted); line-height: 1.5; margin-bottom: 1rem; }
.modal-name  { font-weight: 700; color: var(--text); }
.modal-acts  { display: flex; gap: .5rem; }
.btn-confirm {
    flex: 1; padding: 9px;
    background: var(--red); color: #fff;
    font-size: .8rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
    border: none; border-radius: 9px; cursor: pointer; transition: opacity .2s;
}
.btn-confirm:hover { opacity: .85; }
.btn-cancel-modal {
    flex: 1; padding: 9px;
    background: var(--surf); color: var(--muted);
    font-size: .8rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid var(--border); border-radius: 9px; cursor: pointer; transition: all .2s;
}
.btn-cancel-modal:hover { color: var(--text); }

@media (max-width: 480px) {
    .add-row { flex-direction: column; }
    .btn-add { width: 100%; justify-content: center; }
}
</style>
@endpush

@section('content')

{{-- ── TOPBAR ── --}}
<div class="topbar">
    <div class="topbar-in">
        <div class="t-brand">
            <div class="t-logo">
                <img src="{{ asset('image/logo-libas.png') }}" alt="Logo Polrestabes Semarang">
            </div>
            <div>
                <span class="t-title">Sistem Patroli Mudik Libas</span>
                <span class="t-sub">Kab. Semarang · Lebaran 1446 H</span>
            </div>
        </div>
        <div class="t-right">
            <a href="{{ route('admin.data') }}" class="t-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.logout') }}" class="t-out">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </a>
        </div>
    </div>
</div>

<div class="wrap">

    {{-- Breadcrumb & Page Title --}}
    <div class="page-hd">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.data') }}">Dashboard</a>
                <span class="breadcrumb-sep">›</span>
                <span>Manajemen Wilayah</span>
                <span class="breadcrumb-sep">›</span>
                <span style="color:var(--text);font-weight:600">Kecamatan</span>
            </div>
            <div class="page-title" style="margin-top:4px">Manajemen Kecamatan</div>
        </div>
        <a href="{{ route('admin.wilayah.kelurahan') }}" class="btn-search" style="border-color:var(--blue2);color:var(--blue2)">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Kelola Kelurahan
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Main Panel --}}
    <div class="panel">
        {{-- Panel Header --}}
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:var(--blue2)"></div>
                Daftar Kecamatan
                <span style="font-weight:400;color:var(--muted);font-size:.72rem">({{ $kecamatans->total() }})</span>
            </div>
            <span class="ph-hint">Kab. Semarang terkunci</span>
        </div>

        {{-- Tambah Kecamatan --}}
        <div class="add-form">
            <form method="POST" action="{{ route('admin.wilayah.kecamatan.store') }}">
                @csrf
                <div class="add-row">
                    <div class="fi-wrap">
                        <label class="fl">Tambah Kecamatan Baru</label>
                        <input type="text" name="nama"
                            value="{{ old('nama') }}"
                            class="fi {{ $errors->has('nama') ? 'error' : '' }}"
                            placeholder="Nama kecamatan...">
                        @error('nama')<p class="fi-err">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-add">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>
            </form>
        </div>

        {{-- Filter / Search --}}
        <form method="GET" action="{{ route('admin.wilayah.kecamatan') }}">
            <div class="filter-bar">
                <div class="search-wrap">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="search-input" placeholder="Cari nama kecamatan...">
                </div>
                <button type="submit" class="btn-search active">Cari</button>
                @if(request('search'))
                    <a href="{{ route('admin.wilayah.kecamatan') }}" class="btn-search">Reset</a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kecamatan</th>
                        <th>Jumlah Kelurahan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kecamatans as $kec)
                    <tr id="row-kec-{{ $kec->id }}">
                        <td style="color:var(--muted);font-size:.68rem">
                            {{ $loop->iteration + ($kecamatans->currentPage() - 1) * $kecamatans->perPage() }}
                        </td>
                        <td>
                            {{-- View mode --}}
                            <span class="kec-name view-mode-{{ $kec->id }}">{{ $kec->nama }}</span>

                            {{-- Edit inline form --}}
                            <form method="POST" action="{{ route('admin.wilayah.kecamatan.update', $kec) }}"
                                  class="edit-form" id="edit-form-{{ $kec->id }}">
                                @csrf @method('PUT')
                                <input type="text" name="nama" value="{{ $kec->nama }}"
                                    class="edit-input" required>
                                <button type="submit" class="btn-save">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan
                                </button>
                                <button type="button" class="btn-cancel"
                                    onclick="cancelEdit({{ $kec->id }})">Batal</button>
                            </form>
                        </td>
                        <td>
                            <span class="kec-badge">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $kec->kelurahans_count }} kelurahan
                            </span>
                        </td>
                        <td>
                            <div class="act-row view-mode-{{ $kec->id }}">
                                <button class="btn-edit" onclick="startEdit({{ $kec->id }})">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <button class="btn-del"
                                    onclick="openDeleteModal({{ $kec->id }}, '{{ addslashes($kec->nama) }}', {{ $kec->kelurahans_count }})">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-wrap">
                                <div class="empty-ico">
                                    <svg width="22" height="22" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                </div>
                                <p style="font-size:.82rem">Belum ada kecamatan terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kecamatans->hasPages())
        <div class="pagi">{{ $kecamatans->links() }}</div>
        @endif
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal-bg" id="delete-modal">
    <div class="modal">
        <div class="modal-ico">
            <svg width="20" height="20" fill="none" stroke="#B28228" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="modal-title">Hapus Kecamatan?</div>
        <p class="modal-body" id="modal-body-text">Apakah Anda yakin ingin menghapus kecamatan ini?</p>
        <div class="modal-acts">
            <button class="btn-cancel-modal" onclick="closeDeleteModal()">Batal</button>
            <form id="delete-form" method="POST" style="flex:1">
                @csrf @method('DELETE')
                <button type="submit" class="btn-confirm" style="width:100%">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function startEdit(id) {
    document.querySelectorAll('.view-mode-' + id).forEach(el => el.style.display = 'none');
    document.getElementById('edit-form-' + id).classList.add('open');
}
function cancelEdit(id) {
    document.querySelectorAll('.view-mode-' + id).forEach(el => el.style.display = '');
    document.getElementById('edit-form-' + id).classList.remove('open');
}

function openDeleteModal(id, nama, kelCount) {
    const modal = document.getElementById('delete-modal');
    const form  = document.getElementById('delete-form');
    const body  = document.getElementById('modal-body-text');

    form.action = `/admin/wilayah/kecamatan/${id}`;

    if (kelCount > 0) {
        body.innerHTML = `Kecamatan <span class="modal-name">${nama}</span> memiliki <b>${kelCount} kelurahan</b> dan tidak dapat dihapus. Hapus semua kelurahan di dalamnya terlebih dahulu.`;
        document.querySelector('.btn-confirm').style.display = 'none';
    } else {
        body.innerHTML = `Kecamatan <span class="modal-name">${nama}</span> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.`;
        document.querySelector('.btn-confirm').style.display = '';
    }

    modal.classList.add('open');
}
function closeDeleteModal() {
    document.getElementById('delete-modal').classList.remove('open');
}
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endpush