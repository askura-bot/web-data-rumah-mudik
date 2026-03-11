@extends('layouts.AdminLayout')
@section('title', 'Manajemen Kelurahan — Sistem Patroli Mudik')

@push('styles')
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px; background: #f0f2f7; color: #1a1a2e;
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

/* Topbar */
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
.t-logo svg path { fill: var(--navy); }
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
    text-decoration: none; transition: all .2s;
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

/* Wrap */
.wrap { max-width: 1400px; margin: 0 auto; padding: 1rem; display: flex; flex-direction: column; gap: 1rem; }

/* Page Header */
.page-hd { display: flex; align-items: center; justify-content: space-between; gap: .75rem; flex-wrap: wrap; }
.breadcrumb { display: flex; align-items: center; gap: 6px; font-size: .72rem; color: var(--muted); }
.breadcrumb a { color: var(--blue2); text-decoration: none; font-weight: 600; }
.breadcrumb a:hover { text-decoration: underline; }
.breadcrumb-sep { color: #cbd5e1; }
.page-title { font-family: 'Barlow Condensed', sans-serif; font-size: 1.3rem; font-weight: 800; color: var(--navy); letter-spacing: .03em; }

/* Alerts */
.alert { padding: .75rem 1rem; border-radius: var(--radius); font-size: .8rem; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #166534; }
.alert-error   { background: #fff5f5; border: 1.5px solid #fecaca; color: #991b1b; }

/* Panel */
.panel { background: var(--white); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.ph { padding: .75rem 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 8px; background: linear-gradient(135deg, #f8f9ff, #fff); flex-wrap: wrap; }
.ph-title { display: flex; align-items: center; gap: 7px; font-weight: 700; font-size: .82rem; color: var(--text); }
.ph-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }

/* Add Form */
.add-form { padding: 1rem; border-bottom: 1px solid var(--border); background: #fafbff; }
.add-grid { display: grid; grid-template-columns: 1fr 1fr auto; gap: .625rem; align-items: end; }
.fl { display: block; font-size: .67rem; font-weight: 700; color: var(--muted); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 4px; }
.fi {
    width: 100%; padding: 8px 11px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .8rem; font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text); background: #fff; outline: none;
    transition: border-color .2s, box-shadow .2s;
    -webkit-appearance: none; appearance: none;
}
.fi:focus { border-color: var(--blue2); box-shadow: 0 0 0 3px rgba(255,224,2,.1); }
.fi.error { border-color: var(--red); }
.fi-err { font-size: .68rem; color: var(--red); margin-top: 3px; }
select.fi {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 9px center; background-size: 15px; padding-right: 30px; cursor: pointer;
}
.btn-add {
    padding: 8px 18px;
    background: var(--navy); color: #fff;
    font-size: .78rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
    border: none; border-radius: 8px; cursor: pointer;
    display: inline-flex; align-items: center; gap: 5px;
    white-space: nowrap; transition: background .2s; flex-shrink: 0;
}
.btn-add:hover { background: var(--blue); }

/* Filter bar */
.filter-bar { padding: .75rem 1rem; border-bottom: 1px solid var(--border); display: flex; gap: .5rem; flex-wrap: wrap; }
.search-wrap { position: relative; flex: 1; min-width: 180px; max-width: 260px; }
.search-wrap svg { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
.search-input { width: 100%; padding: 7px 11px 7px 32px; border: 1.5px solid var(--border); border-radius: 8px; font-size: .78rem; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); background: #fff; outline: none; transition: border-color .2s; }
.search-input:focus { border-color: var(--blue2); }
.kec-filter { padding: 7px 30px 7px 10px; border: 1.5px solid var(--border); border-radius: 8px; font-size: .78rem; font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fff; color: var(--text); outline: none; cursor: pointer; -webkit-appearance: none; appearance: none; min-width: 160px; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 9px center; background-size: 15px; }
.kec-filter:focus { border-color: var(--blue2); }
.btn-search { padding: 7px 14px; background: var(--surf); color: var(--muted); font-size: .75rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif; border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; transition: all .2s; text-decoration: none; }
.btn-search:hover { color: var(--text); border-color: #bac0cc; }
.btn-search.active { background: var(--navy); color: #fff; border-color: var(--navy); }

/* Table */
.tbl-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
.tbl-hint { display: none; padding: 6px 1rem; font-size: .67rem; color: var(--muted); background: #fffbf2; border-bottom: 1px solid #f5e8cc; gap: 5px; align-items: center; }
@media (max-width: 640px) { .tbl-hint { display: flex; } }
table { width: 100%; border-collapse: collapse; min-width: 560px; }
thead tr { background: linear-gradient(135deg, #fafafa, #f5f5f5); }
th { padding: 9px 12px; text-align: left; font-size: .65rem; font-weight: 700; color: var(--muted); letter-spacing: .07em; text-transform: uppercase; white-space: nowrap; border-bottom: 1.5px solid var(--border); }
td { padding: 10px 12px; border-bottom: 1px solid #f0f2f6; vertical-align: middle; }
tr:last-child td { border-bottom: none; }
tbody tr:hover { background: rgba(255,182,6,0.05); }

.kel-name { font-weight: 600; font-size: .84rem; color: var(--text); }
.kec-tag {
    display: inline-flex; align-items: center; gap: 3px;
    padding: 2px 9px;
    background: rgba(255,224,2,0.1);
    color: var(--navy);
    font-size: .69rem; font-weight: 600; border-radius: 99px; white-space: nowrap;
}
.act-row { display: flex; gap: 6px; }

/* Inline edit */
.edit-form { display: none; }
.edit-form.open { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
.edit-input {
    flex: 1; min-width: 120px; padding: 6px 10px;
    border: 1.5px solid var(--blue2); border-radius: 7px;
    font-size: .8rem; font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none; color: var(--text);
    box-shadow: 0 0 0 3px rgba(255,224,2,.1);
}
.edit-select {
    padding: 6px 28px 6px 8px;
    border: 1.5px solid var(--blue2); border-radius: 7px;
    font-size: .78rem; font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: #fff; color: var(--text); outline: none;
    min-width: 130px; -webkit-appearance: none; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 7px center; background-size: 14px;
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
.btn-cancel-edit {
    padding: 6px 10px;
    background: var(--surf); color: var(--muted);
    font-size: .73rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1.5px solid var(--border); border-radius: 7px; cursor: pointer;
    transition: all .2s;
}
.btn-cancel-edit:hover { color: var(--text); }
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

/* Empty */
.empty-wrap { padding: 3rem 1rem; text-align: center; color: var(--muted); }
.empty-ico { width: 48px; height: 48px; background: var(--surf); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; }

/* Pagination */
.pagi { padding: 10px 14px; border-top: 1px solid var(--border); }
.pagi nav { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; }

/* Modal */
.modal-bg { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 1000; align-items: center; justify-content: center; padding: 1rem; }
.modal-bg.open { display: flex; }
.modal { background: #fff; border-radius: 16px; padding: 1.5rem; width: 100%; max-width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,.25); animation: modalIn .2s ease; }
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

@media (max-width: 640px) {
    .add-grid { grid-template-columns: 1fr; }
    .btn-add { width: 100%; justify-content: center; }
}
</style>
@endpush

@section('content')

{{-- Topbar --}}
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

    {{-- Breadcrumb --}}
    <div class="page-hd">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.data') }}">Dashboard</a>
                <span class="breadcrumb-sep">›</span>
                <a href="{{ route('admin.wilayah.kecamatan') }}">Kecamatan</a>
                <span class="breadcrumb-sep">›</span>
                <span style="color:var(--text);font-weight:600">Kelurahan</span>
            </div>
            <div class="page-title" style="margin-top:4px">Manajemen Kelurahan / Desa</div>
        </div>
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
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:var(--accent)"></div>
                Daftar Kelurahan / Desa
                <span style="font-weight:400;color:var(--muted);font-size:.72rem">({{ $kelurahans->total() }})</span>
            </div>
        </div>

        {{-- Tambah Kelurahan --}}
        <div class="add-form">
            <form method="POST" action="{{ route('admin.wilayah.kelurahan.store') }}">
                @csrf
                <div class="add-grid">
                    <div>
                        <label class="fl">Kecamatan <span style="color:#ef4444">*</span></label>
                        <select name="kecamatan_id" id="select-kecamatan"
                            class="fi {{ $errors->has('kecamatan_id') ? 'error' : '' }}" required>
                            <option value="">Pilih Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}"
                                    {{ (old('kecamatan_id', session('last_kecamatan_id')) == $kec->id) ? 'selected' : '' }}>
                                    {{ $kec->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')<p class="fi-err">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="fl">Nama Kelurahan / Desa <span style="color:#ef4444">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                            class="fi {{ $errors->has('nama') ? 'error' : '' }}"
                            placeholder="Nama kelurahan/desa..." id="input-nama" autofocus>
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

        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.wilayah.kelurahan') }}">
            <div class="filter-bar">
                <div class="search-wrap">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="search-input" placeholder="Cari nama kelurahan...">
                </div>
                <select name="kecamatan_id" class="kec-filter">
                    <option value="">Semua Kecamatan</option>
                    @foreach($kecamatans as $kec)
                        <option value="{{ $kec->id }}" {{ request('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                            {{ $kec->nama }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-search active">Cari</button>
                @if(request('search') || request('kecamatan_id'))
                    <a href="{{ route('admin.wilayah.kelurahan') }}" class="btn-search">Reset</a>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="tbl-hint">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            Geser untuk melihat semua kolom
        </div>
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelurahan / Desa</th>
                        <th>Kecamatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelurahans as $kel)
                    <tr id="row-kel-{{ $kel->id }}">
                        <td style="color:var(--muted);font-size:.68rem">
                            {{ $loop->iteration + ($kelurahans->currentPage() - 1) * $kelurahans->perPage() }}
                        </td>
                        <td>
                            {{-- View mode --}}
                            <span class="kel-name view-kel-{{ $kel->id }}">{{ $kel->nama }}</span>

                            {{-- Edit form --}}
                            <form method="POST" action="{{ route('admin.wilayah.kelurahan.update', $kel) }}"
                                  class="edit-form" id="edit-kel-{{ $kel->id }}">
                                @csrf @method('PUT')
                                <select name="kecamatan_id" class="edit-select" required>
                                    @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id }}"
                                            {{ $kel->kecamatan_id == $kec->id ? 'selected' : '' }}>
                                            {{ $kec->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="nama" value="{{ $kel->nama }}"
                                    class="edit-input" required>
                                <button type="submit" class="btn-save">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan
                                </button>
                                <button type="button" class="btn-cancel-edit"
                                    onclick="cancelEditKel({{ $kel->id }})">Batal</button>
                            </form>
                        </td>
                        <td>
                            <span class="kec-tag view-kel-{{ $kel->id }}">
                                {{ $kel->kecamatan->nama ?? '—' }}
                            </span>
                        </td>
                        <td>
                            <div class="act-row view-kel-{{ $kel->id }}">
                                <button class="btn-edit" onclick="startEditKel({{ $kel->id }})">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <button class="btn-del"
                                    onclick="openDeleteKel({{ $kel->id }}, '{{ addslashes($kel->nama) }}')">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p style="font-size:.82rem">Belum ada kelurahan terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kelurahans->hasPages())
        <div class="pagi">{{ $kelurahans->links() }}</div>
        @endif
    </div>

</div>

{{-- Delete Modal --}}
<div class="modal-bg" id="delete-modal-kel">
    <div class="modal">
        <div class="modal-ico">
            <svg width="20" height="20" fill="none" stroke="#B28228" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="modal-title">Hapus Kelurahan?</div>
        <p class="modal-body" id="kel-modal-body">Kelurahan ini akan dihapus permanen.</p>
        <div class="modal-acts">
            <button class="btn-cancel-modal" onclick="closeDeleteKel()">Batal</button>
            <form id="delete-kel-form" method="POST" style="flex:1">
                @csrf @method('DELETE')
                <button type="submit" class="btn-confirm" style="width:100%">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-focus input nama jika kecamatan sudah terpilih saat halaman load
document.addEventListener('DOMContentLoaded', function () {
    const kecSelect = document.getElementById('select-kecamatan');
    const namaInput = document.getElementById('input-nama');

    if (kecSelect && kecSelect.value && namaInput) {
        namaInput.focus();
    }
});
function startEditKel(id) {
    document.querySelectorAll('.view-kel-' + id).forEach(el => el.style.display = 'none');
    document.getElementById('edit-kel-' + id).classList.add('open');
}
function cancelEditKel(id) {
    document.querySelectorAll('.view-kel-' + id).forEach(el => el.style.display = '');
    document.getElementById('edit-kel-' + id).classList.remove('open');
}
function openDeleteKel(id, nama) {
    document.getElementById('delete-kel-form').action = `/admin/wilayah/kelurahan/${id}`;
    document.getElementById('kel-modal-body').innerHTML =
        `Kelurahan <span class="modal-name">${nama}</span> akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.`;
    document.getElementById('delete-modal-kel').classList.add('open');
}
function closeDeleteKel() {
    document.getElementById('delete-modal-kel').classList.remove('open');
}
document.getElementById('delete-modal-kel').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteKel();
});
</script>
@endpush