{{-- resources/Views/user/form.blade.php --}}
@extends('layouts.app')
@section('title', 'Daftar Rumah Mudik — Kabupaten Semarang')

@push('styles')
<style>
/* ── Google Fonts ─────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ── CSS Variables – Color Palette Baru ───────── */
:root {
    --primary:       #D70608;   /* merah terang */
    --primary-dark:  #E60102;   /* merah lebih gelap */
    --accent:        #DB8138;   /* oranye/karat */
    --accent-light:  #FDCFB8;   /* peach muda */
    --light-bg:      #FDFDFE;   /* putih bersih */
    --ink:           #1a1a2e;
    --muted:         #6b7280;

    --primary-rgb:   215, 6, 8; /* rgb(215,6,8) */
}

body { background: var(--light-bg); font-family: 'Plus Jakarta Sans', sans-serif; }

/* ── Hero ─────────────────────────────────────── */
.hero {
    background: var(--primary);
    position: relative;
    overflow: hidden;
    padding: 3rem 1rem 5rem;
}

/* Ornamen ketupat SVG background */
.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M30 0l30 30-30 30L0 30z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    background-size: 60px 60px;
}

/* Bintang dekoratif kanan */
.hero::after {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(219,129,56,0.25) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-wave {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 48px;
    overflow: hidden;
}
.hero-wave svg { width: 100%; height: 100%; }

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(219,129,56,0.2);   /* accent dengan opacity */
    border: 1px solid rgba(219,129,56,0.4);
    color: #fff;                         /* teks putih agar kontras */
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 99px;
    margin-bottom: 1rem;
}

.hero h1 {
    font-family: 'Lora', serif;
    font-size: clamp(1.6rem, 5vw, 2.4rem);
    font-weight: 700;
    color: #ffffff;
    line-height: 1.2;
    position: relative;
    z-index: 1;
}

.hero p {
    color: rgba(255,255,255,0.75);
    font-size: 0.9rem;
    margin-top: 0.5rem;
    position: relative;
    z-index: 1;
}

/* Ornamen bintang kecil */
.star-deco {
    position: absolute;
    z-index: 1;
}
.star-deco svg {
    opacity: 0.3;
    stroke: var(--accent);  /* warna oranye */
}

/* ── Step Cards ───────────────────────────────── */
.step-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 2px 16px rgba(0,0,0,0.05);
    animation: slideUp 0.4s ease both;
    position: relative;
    overflow: hidden;
}
.step-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    border-radius: 20px 20px 0 0;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
.step-card:nth-child(1) { animation-delay: 0.05s; }
.step-card:nth-child(2) { animation-delay: 0.10s; }
.step-card:nth-child(3) { animation-delay: 0.15s; }
.step-card:nth-child(4) { animation-delay: 0.20s; }
.step-card:nth-child(5) { animation-delay: 0.25s; }

.step-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 1.25rem;
}
.step-num {
    width: 28px; height: 28px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(var(--primary-rgb), 0.35);
}
.step-num.optional {
    background: linear-gradient(135deg, #9ca3af, #6b7280);
    box-shadow: 0 2px 6px rgba(107,114,128,0.3);
}
.step-title {
    font-weight: 700;
    color: var(--ink);
    font-size: 0.95rem;
}
.step-subtitle {
    font-size: 0.75rem;
    color: var(--muted);
    font-weight: 400;
    margin-left: 2px;
}

/* ── Form Inputs ──────────────────────────────── */
.field-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}
.field-label .req { color: #ef4444; }

.field-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.875rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--ink);
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    appearance: none;
}
.field-input:focus {
    border-color: var(--primary-dark);
    box-shadow: 0 0 0 3px rgba(230,1,2,0.12);  /* primary-dark dengan opacity */
}
.field-input.error { border-color: #f87171; }
.field-input.readonly {
    background: #f9fafb;
    color: #9ca3af;
    cursor: not-allowed;
}
.field-input::placeholder { color: #c4c9d4; }

select.field-input {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 18px;
    padding-right: 40px;
    cursor: pointer;
}

.field-hint { font-size: 0.72rem; color: #9ca3af; margin-top: 4px; }
.field-error { font-size: 0.72rem; color: #ef4444; margin-top: 4px; }

/* ── Kabupaten locked field ───────────────────── */
.locked-field {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    background: #f9fafb;
    font-size: 0.875rem;
    color: #6b7280;
}
.locked-field .lock-icon { color: var(--primary-dark); flex-shrink: 0; }

/* ── Peta ─────────────────────────────────────── */
#map {
    height: 360px;
    border-radius: 14px;
    border: 1.5px solid #e5e7eb;
    overflow: hidden;
    margin-bottom: 1rem;
}
.coord-box {
    display: flex;
    gap: 10px;
    margin-bottom: 1rem;
}
.coord-item {
    flex: 1;
    padding: 8px 12px;
    background: var(--accent-light);      /* peach */
    border: 1px solid rgba(215,6,8,0.15);  /* primary dengan opacity */
    border-radius: 10px;
}
.coord-label { font-size: 10px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em; }
.coord-value { font-size: 12px; color: #374151; margin-top: 2px; font-family: monospace; }

.geocode-spinner {
    display: none;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: var(--primary-dark);
    font-weight: 600;
}
.geocode-spinner.active { display: flex; }
.spinner-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--primary-dark);
    animation: pulse 1.2s ease-in-out infinite;
}
.spinner-dot:nth-child(2) { animation-delay: 0.2s; }
.spinner-dot:nth-child(3) { animation-delay: 0.4s; }
@keyframes pulse {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
    40% { transform: scale(1); opacity: 1; }
}

/* ── Upload Foto ──────────────────────────────── */
.upload-zone {
    border: 2px dashed #d1d5db;
    border-radius: 14px;
    padding: 2rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    position: relative;
}
.upload-zone:hover {
    border-color: var(--primary-dark);
    background: var(--accent-light);
}
.upload-zone.has-file { border-style: solid; border-color: var(--primary-dark); }

/* ── Submit Button ────────────────────────────── */
.btn-submit {
    width: 100%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 14px 24px;
    border-radius: 16px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform 0.15s, box-shadow 0.15s;
    box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.35);
    position: relative;
    overflow: hidden;
}
.btn-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(219,129,56,0.15), transparent);
    opacity: 0;
    transition: opacity 0.2s;
}
.btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(var(--primary-rgb), 0.4); }
.btn-submit:hover::before { opacity: 1; }
.btn-submit:active { transform: translateY(0); }

/* ── Error Banner ─────────────────────────────── */
.error-banner {
    background: #fff5f5;
    border: 1.5px solid #fecaca;
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}

/* ── Footer note ──────────────────────────────── */
.footer-note {
    text-align: center;
    font-size: 0.75rem;
    color: #9ca3af;
    margin-top: 0.5rem;
    padding-bottom: 2rem;
}

.logo-circle {
    width: 140px;
    height: 140px;
    background: var(--light-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border: 2px solid var(--accent); /* biar tidak menyatu */
}
.logo-circle img {
    width: 70%; /* atau atur sesuai */
    height: auto;
    object-fit: contain;
}

/* ── Responsive ───────────────────────────────── */
@media (max-width: 640px) {
    .step-card { padding: 1.25rem; }
    .hero { padding-bottom: 4rem; }
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════
     HERO HEADER with LOGO
══════════════════════════════════════════════ --}}
<div class="hero">

    {{-- Ornamen bintang --}}
    <div class="star-deco" style="top:16px;left:16px">
        <svg width="40" height="40" viewBox="0 0 40 40"><polygon points="20,2 24,14 37,14 27,22 31,35 20,27 9,35 13,22 3,14 16,14" fill="none" stroke="var(--accent)" stroke-width="1.5"/></svg>
    </div>
    <div class="star-deco" style="bottom:60px;left:10%">
        <svg width="24" height="24" viewBox="0 0 40 40"><polygon points="20,2 24,14 37,14 27,22 31,35 20,27 9,35 13,22 3,14 16,14" fill="none" stroke="var(--accent)" stroke-width="1.5"/></svg>
    </div>
    <div class="star-deco" style="top:30px;right:12%">
        <svg width="32" height="32" viewBox="0 0 40 40"><polygon points="20,2 24,14 37,14 27,22 31,35 20,27 9,35 13,22 3,14 16,14" fill="none" stroke="var(--accent)" stroke-width="1.5"/></svg>
    </div>

    <div style="max-width:640px;margin:0 auto;text-align:center;position:relative;z-index:2">
        <div class="hero-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Lebaran 1446 H
        </div>
        <div class="logo-circle">
            <img src="{{ asset('image/logo-libas.png') }}" alt="Logo Polrestabes Semarang">
        </div>
        <h1>Titipkan Keamanan<br>Rumah Anda</h1>
        <p>Daftarkan rumah yang ditinggal mudik agar dapat<br>dipantau oleh petugas keamanan setempat</p>
    </div>

    {{-- Wave SVG --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 48" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,48 L0,24 C240,0 480,48 720,24 C960,0 1200,48 1440,24 L1440,48 Z" fill="var(--light-bg)"/>
        </svg>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     FORM (konten sama, hanya warna menyesuaikan variabel)
══════════════════════════════════════════════ --}}
<div style="max-width:640px;margin:0 auto;padding:2rem 1rem;">

    @if($errors->any())
    <div class="error-banner">
        <p style="font-size:0.85rem;font-weight:700;color:#dc2626;margin-bottom:4px">
            ⚠ Terdapat kesalahan pada form:
        </p>
        <ul style="list-style:disc;padding-left:1.2rem;font-size:0.8rem;color:#ef4444">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:flex;flex-direction:column;gap:1.25rem">

        {{-- ══ 1. DATA PEMILIK ══════════════════════════ --}}
        <div class="step-card">
            <div class="step-header">
                <div class="step-num">1</div>
                <div>
                    <div class="step-title">Data Pemilik</div>
                    <div class="step-subtitle">Identitas sesuai KTP</div>
                </div>
            </div>

            <div style="display:grid;gap:1rem">
                <div>
                    <label class="field-label">NIK <span class="req">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}"
                        class="field-input @error('nik') error @enderror"
                        placeholder="16 digit Nomor Induk Kependudukan"
                        maxlength="16" pattern="\d{16}"
                        oninput="this.value=this.value.replace(/\D/g,'')" required>
                    <p class="field-hint">NIK digunakan sebagai identifikasi unik — 1 NIK bisa mendaftarkan lebih dari 1 rumah</p>
                    @error('nik')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field-label">Nama Lengkap Pemilik <span class="req">*</span></label>
                    <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}"
                        class="field-input @error('nama_pemilik') error @enderror"
                        placeholder="Nama sesuai KTP" required>
                    @error('nama_pemilik')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- ══ 2. TITIK LOKASI ══════════════════════════ --}}
        <div class="step-card">
            <div class="step-header">
                <div class="step-num">2</div>
                <div>
                    <div class="step-title">Titik Lokasi Rumah</div>
                    <div class="step-subtitle">Geser pin untuk akurasi lebih baik</div>
                </div>
            </div>

            <div id="map"></div>

            <div class="coord-box">
                <div class="coord-item">
                    <div class="coord-label">Latitude</div>
                    <div class="coord-value" id="lat-display">—</div>
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" required>
                </div>
                <div class="coord-item">
                    <div class="coord-label">Longitude</div>
                    <div class="coord-value" id="lng-display">—</div>
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" required>
                </div>
            </div>

            <div>
                <label class="field-label" style="display:flex;align-items:center;gap:8px">
                    Alamat Lengkap <span class="req">*</span>
                    <span class="geocode-spinner" id="geocoding_status">
                        <span class="spinner-dot"></span>
                        <span class="spinner-dot"></span>
                        <span class="spinner-dot"></span>
                        Mengambil alamat...
                    </span>
                </label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3"
                    class="field-input @error('alamat_lengkap') error @enderror"
                    style="resize:vertical"
                    placeholder="Terisi otomatis dari titik peta, atau ketik manual" required>{{ old('alamat_lengkap') }}</textarea>
                @error('alamat_lengkap')<p class="field-error">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ══ 3. WILAYAH ════════════════════════════════ --}}
        <div class="step-card">
            <div class="step-header">
                <div class="step-num">3</div>
                <div>
                    <div class="step-title">Wilayah</div>
                    <div class="step-subtitle">RT, RW, kecamatan, dan kelurahan</div>
                </div>
            </div>

            {{-- RT / RW --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem">
                <div>
                    <label class="field-label">RT <span class="req">*</span></label>
                    <input type="text" name="rt" value="{{ old('rt') }}"
                        class="field-input @error('rt') error @enderror"
                        placeholder="cth: 001" maxlength="5" required>
                    @error('rt')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field-label">RW <span class="req">*</span></label>
                    <input type="text" name="rw" value="{{ old('rw') }}"
                        class="field-input @error('rw') error @enderror"
                        placeholder="cth: 003" maxlength="5" required>
                    @error('rw')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Kabupaten (locked) --}}
            <div style="margin-bottom:1rem">
                <label class="field-label">Kabupaten / Kota</label>
                <div class="locked-field">
                    <svg class="lock-icon" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Kab. Semarang
                </div>
                <input type="hidden" name="kabupaten" value="Kabupaten Semarang">
            </div>

            {{-- Kecamatan + Kelurahan --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">

                {{-- Kecamatan --}}
                <div>
                    <label class="field-label">Kecamatan <span class="req">*</span></label>
                    <select name="kecamatan_id" id="kecamatan_select"
                        class="field-input @error('kecamatan_id') error @enderror" required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}"
                                {{ old('kecamatan_id') == $kec->id ? 'selected' : '' }}>
                                {{ $kec->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')<p class="field-error">{{ $message }}</p>@enderror
                </div>

                {{-- Kelurahan — diisi via AJAX --}}
                <div>
                    <label class="field-label">Kelurahan / Desa <span class="req">*</span></label>
                    <div style="position:relative">
                        <select name="kelurahan_id" id="kelurahan_select"
                            class="field-input @error('kelurahan_id') error @enderror"
                            disabled required>
                            <option value="">— Pilih kecamatan dulu —</option>
                        </select>
                        {{-- Spinner saat loading --}}
                        <div id="kel_spinner" style="
                            display:none;
                            position:absolute;
                            right:36px; top:50%;
                            transform:translateY(-50%);
                            gap:3px;
                            align-items:center;
                        ">
                            <span class="spinner-dot"></span>
                            <span class="spinner-dot"></span>
                            <span class="spinner-dot"></span>
                        </div>
                    </div>
                    @error('kelurahan_id')<p class="field-error">{{ $message }}</p>@enderror
                </div>

            </div>
        </div>

        {{-- ══ 4. JADWAL MUDIK ═══════════════════════════ --}}
        <div class="step-card">
            <div class="step-header">
                <div class="step-num">4</div>
                <div>
                    <div class="step-title">Jadwal Mudik</div>
                    <div class="step-subtitle">Periode rumah ditinggalkan</div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div>
                    <label class="field-label">Tanggal Berangkat <span class="req">*</span></label>
                    <input type="date" name="tanggal_mulai_mudik" value="{{ old('tanggal_mulai_mudik') }}"
                        class="field-input @error('tanggal_mulai_mudik') error @enderror" required>
                    @error('tanggal_mulai_mudik')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="field-label">Estimasi Kembali <span class="req">*</span></label>
                    <input type="date" name="tanggal_selesai_mudik" value="{{ old('tanggal_selesai_mudik') }}"
                        class="field-input @error('tanggal_selesai_mudik') error @enderror" required>
                    @error('tanggal_selesai_mudik')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Info banner --}}
            <div style="margin-top:1rem;display:flex;gap:10px;padding:10px 14px;background:var(--accent-light);border-radius:10px;border:1px solid rgba(219,129,56,0.25)">
                <svg style="flex-shrink:0;margin-top:1px" width="16" height="16" fill="none" stroke="var(--accent)" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p style="font-size:0.75rem;color:#92650a;line-height:1.5">
                    Data jadwal ini akan digunakan oleh petugas untuk menentukan jadwal patroli di sekitar rumah Anda.
                </p>
            </div>
        </div>

        {{-- ══ 5. FOTO RUMAH ═════════════════════════════ --}}
        <div class="step-card">
            <div class="step-header">
                <div class="step-num optional">5</div>
                <div>
                    <div class="step-title">Foto Rumah <span style="font-weight:400;font-size:0.8rem;color:#9ca3af">(opsional)</span></div>
                    <div class="step-subtitle">Membantu petugas mengenali rumah</div>
                </div>
            </div>

            <div class="upload-zone" id="upload-zone" onclick="document.getElementById('foto_rumah').click()">
                {{-- State: processing --}}
                <div id="foto_processing" style="display:none">
                    <div style="width:48px;height:48px;border-radius:12px;background:var(--accent-light);display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" style="animation:spin 1s linear infinite">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <p style="font-size:0.85rem;font-weight:600;color:var(--primary)">Mengompres gambar...</p>
                </div>

                {{-- State: preview --}}
                <div id="foto_preview" style="display:none;margin-bottom:10px">
                    <img id="preview_img" style="max-height:160px;border-radius:10px;object-fit:cover;margin:0 auto;display:block" src="" alt="">
                    {{-- Info ukuran --}}
                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:10px">
                        <span id="size_before" style="font-size:11px;color:#9ca3af;text-decoration:line-through"></span>
                        <svg width="12" height="12" fill="none" stroke="#34d399" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        <span id="size_after" style="font-size:11px;font-weight:700;color:#059669"></span>
                        <span id="size_saving" style="font-size:10px;background:#d1fae5;color:#065f46;padding:2px 7px;border-radius:99px;font-weight:700"></span>
                    </div>
                    <p style="font-size:11px;color:#9ca3af;margin-top:6px">Klik untuk ganti foto</p>
                </div>

                {{-- State: placeholder --}}
                <div id="foto_placeholder">
                    <div style="width:48px;height:48px;background:var(--accent-light);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 10px">
                        <svg width="22" height="22" fill="none" stroke="var(--primary)" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p style="font-size:0.85rem;font-weight:600;color:#374151">Klik untuk pilih foto</p>
                    <p style="font-size:0.75rem;color:#9ca3af;margin-top:4px">JPG, PNG atau WebP · Otomatis dikompres</p>
                </div>

                {{-- Input file asli (hanya untuk trigger picker, tidak disubmit) --}}
                <input type="file" id="foto_rumah" accept="image/*" style="display:none">
            </div>

            {{-- Hidden input yang menyimpan hasil kompres (base64) → dikirim ke server --}}
            <input type="hidden" name="foto_rumah_compressed" id="foto_rumah_compressed">
        </div>

        </div>{{-- end cards --}}

        {{-- ══ SUBMIT ════════════════════════════════════ --}}
        <div style="margin-top:1.5rem">
            <button type="submit" class="btn-submit">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Daftarkan Rumah Mudik Saya
            </button>
            <p class="footer-note">Data Anda aman dan hanya digunakan untuk keperluan patroli keamanan</p>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

// ─── Peta Leaflet ─────────────────────────────────────────────────────────────
let map, marker;
const defaultCenter = [-7.1751, 110.4028]; // Kabupaten Semarang
const primaryColor = '#D70608';
const primaryDark  = '#E60102';

function initMap(lat, lng) {
    map = L.map('map', { zoomControl: true }).setView([lat, lng], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19,
    }).addTo(map);

    const icon = L.divIcon({
        html: `<div style="
            width:32px;height:32px;
            background:linear-gradient(135deg, ${primaryColor}, ${primaryDark});
            border-radius:50% 50% 50% 0;
            transform:rotate(-45deg);
            border:3px solid white;
            box-shadow:0 3px 10px rgba(215,6,8,0.5)">
        </div>`,
        iconSize: [32, 32], iconAnchor: [16, 32],
        className: '',
    });

    marker = L.marker([lat, lng], { draggable: true, icon }).addTo(map);
    updateCoords(lat, lng);
    reverseGeocode(lat, lng);

    marker.on('dragend', function (e) {
        const pos = e.target.getLatLng();
        updateCoords(pos.lat, pos.lng);
        reverseGeocode(pos.lat, pos.lng);
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateCoords(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
}

function updateCoords(lat, lng) {
    document.getElementById('latitude').value  = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);
    document.getElementById('lat-display').textContent = lat.toFixed(6);
    document.getElementById('lng-display').textContent = lng.toFixed(6);
}

let geocodeTimeout;
function reverseGeocode(lat, lng) {
    clearTimeout(geocodeTimeout);
    const spinner = document.getElementById('geocoding_status');
    spinner.classList.add('active');
    geocodeTimeout = setTimeout(async () => {
        try {
            const resp = await fetch(
                `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&addressdetails=1`,
                { headers: { 'Accept-Language': 'id' } }
            );
            const data = await resp.json();
            if (data.display_name) {
                document.getElementById('alamat_lengkap').value = data.display_name;
            }
        } catch (err) {
            console.warn('Geocode gagal:', err);
        } finally {
            spinner.classList.remove('active');
        }
    }, 800);
}

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        pos => initMap(pos.coords.latitude, pos.coords.longitude),
        ()  => initMap(...defaultCenter)
    );
} else {
    initMap(...defaultCenter);
}

// ─── AJAX untuk Kelurahan (sama seperti sebelumnya) ──────────────────────────
(function () {
    const kecSelect = document.getElementById('kecamatan_select');
    const kelSelect = document.getElementById('kelurahan_select');
    const spinner   = document.getElementById('kel_spinner');

    const oldKelId  = {{ old('kelurahan_id') ? old('kelurahan_id') : 'null' }};

    async function loadKelurahans(kecamatanId) {
        kelSelect.innerHTML  = '<option value="">Memuat...</option>';
        kelSelect.disabled   = true;
        spinner.style.display = 'flex';

        try {
            const resp = await fetch(`{{ route('api.kelurahans') }}?kecamatan_id=${kecamatanId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!resp.ok) throw new Error('Gagal memuat data kelurahan.');

            const data = await resp.json();

            kelSelect.innerHTML = '<option value="">Pilih Kelurahan / Desa</option>';

            data.forEach(kel => {
                const opt    = document.createElement('option');
                opt.value    = kel.id;
                opt.textContent = kel.nama;
                if (oldKelId && kel.id == oldKelId) opt.selected = true;
                kelSelect.appendChild(opt);
            });

            kelSelect.disabled = false;

        } catch (err) {
            kelSelect.innerHTML = '<option value="">Gagal memuat — coba lagi</option>';
            console.error(err);
        } finally {
            spinner.style.display = 'none';
        }
    }

    kecSelect.addEventListener('change', function () {
        if (!this.value) {
            kelSelect.innerHTML  = '<option value="">— Pilih kecamatan dulu —</option>';
            kelSelect.disabled   = true;
            return;
        }
        loadKelurahans(this.value);
    });

    const oldKecId = kecSelect.value;
    if (oldKecId) loadKelurahans(oldKecId);
}());

// ─── Kompresi & Preview Foto (sama, hanya warna disesuaikan di CSS) ──────────
const MAX_WIDTH    = 1280;
const MAX_HEIGHT   = 1280;
const QUALITY      = 0.80;
const MAX_SIZE_MB  = 1.5;

document.getElementById('foto_rumah').addEventListener('change', function () {
    const file = this.files?.[0];
    if (!file) return;

    if (!['image/jpeg','image/png','image/webp','image/gif'].includes(file.type)) {
        alert('Format file tidak didukung. Gunakan JPG, PNG, atau WebP.');
        this.value = '';
        return;
    }

    document.getElementById('foto_placeholder').style.display  = 'none';
    document.getElementById('foto_preview').style.display      = 'none';
    document.getElementById('foto_processing').style.display   = 'block';
    document.getElementById('upload-zone').classList.remove('has-file');

    const originalSizeKB = (file.size / 1024).toFixed(1);

    const reader = new FileReader();
    reader.onload = function (e) {
        const img = new Image();
        img.onload = function () {
            let { width, height } = img;
            if (width > MAX_WIDTH || height > MAX_HEIGHT) {
                const ratio = Math.min(MAX_WIDTH / width, MAX_HEIGHT / height);
                width  = Math.round(width  * ratio);
                height = Math.round(height * ratio);
            }

            const canvas = document.createElement('canvas');
            canvas.width  = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, width, height);
            ctx.drawImage(img, 0, 0, width, height);

            let quality    = QUALITY;
            let dataUrl    = canvas.toDataURL('image/jpeg', quality);
            let compressedBytes = atob(dataUrl.split(',')[1]).length;

            while (compressedBytes > MAX_SIZE_MB * 1024 * 1024 && quality > 0.3) {
                quality  -= 0.05;
                dataUrl   = canvas.toDataURL('image/jpeg', quality);
                compressedBytes = atob(dataUrl.split(',')[1]).length;
            }

            const compressedSizeKB = (compressedBytes / 1024).toFixed(1);
            const savingPct = Math.round((1 - compressedBytes / file.size) * 100);

            document.getElementById('foto_rumah_compressed').value = dataUrl;

            document.getElementById('preview_img').src = dataUrl;
            document.getElementById('size_before').textContent  = originalSizeKB + ' KB';
            document.getElementById('size_after').textContent   = compressedSizeKB + ' KB';
            document.getElementById('size_saving').textContent  = savingPct > 0
                ? '−' + savingPct + '%'
                : 'Sudah optimal';

            document.getElementById('foto_processing').style.display = 'none';
            document.getElementById('foto_preview').style.display    = 'block';
            document.getElementById('upload-zone').classList.add('has-file');
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
});

}); // end DOMContentLoaded
</script>
@endpush