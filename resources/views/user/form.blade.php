@extends('layouts.app')

@section('title', 'Daftar Rumah Mudik')

@push('styles')
<style>
    #map { height: 380px; width: 100%; }
    .form-input {
        @apply w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition;
    }
    .form-label {
        @apply block text-sm font-600 text-gray-700 mb-1.5;
    }
</style>
@endpush

@section('content')
{{-- Header --}}
<div class="bg-linear-to-br from-emerald-700 to-emerald-500 text-white py-10 px-4">
    <div class="max-w-2xl mx-auto text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-white/20 rounded-2xl mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <h1 class="text-2xl font-800 tracking-tight">Pendataan Rumah Mudik</h1>
        <p class="mt-2 text-emerald-100 text-sm">Daftarkan rumah Anda yang ditinggal selama mudik Lebaran</p>
    </div>
</div>

<div class="max-w-2xl mx-auto px-4 py-8">

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <p class="text-sm font-600 text-red-700 mb-1">Terdapat kesalahan pada form:</p>
        <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- ── Data Pemilik ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-700 text-gray-800 mb-5 flex items-center gap-2">
                <span class="w-6 h-6 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center text-xs font-800">1</span>
                Data Pemilik
            </h2>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="form-label">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik') }}"
                        class="form-input @error('nik') border-red-400 @enderror"
                        placeholder="16 digit NIK" maxlength="16" pattern="\d{16}"
                        oninput="this.value=this.value.replace(/\D/g,'')" required>
                    <p class="text-xs text-gray-400 mt-1">NIK digunakan sebagai identifikasi unik pemilik</p>
                    @error('nik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Nama Pemilik <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}"
                        class="form-input @error('nama_pemilik') border-red-400 @enderror"
                        placeholder="Nama lengkap sesuai KTP" required>
                    @error('nama_pemilik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- ── Lokasi Rumah ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-700 text-gray-800 mb-2 flex items-center gap-2">
                <span class="w-6 h-6 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center text-xs font-800">2</span>
                Titik Lokasi Rumah
            </h2>
            <p class="text-xs text-gray-400 mb-4">Izinkan akses lokasi agar peta terpusat ke posisi Anda. Geser marker untuk menyesuaikan titik yang tepat.</p>

            <div id="map" class="mb-4 border border-gray-200"></div>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="form-label">Latitude</label>
                    <input type="text" id="latitude_display" readonly
                        class="form-input bg-gray-50 text-gray-500 cursor-not-allowed" placeholder="Otomatis dari peta">
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" required>
                </div>
                <div>
                    <label class="form-label">Longitude</label>
                    <input type="text" id="longitude_display" readonly
                        class="form-input bg-gray-50 text-gray-500 cursor-not-allowed" placeholder="Otomatis dari peta">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" required>
                </div>
            </div>

            <div>
                <label class="form-label">Alamat Lengkap <span class="text-red-500">*</span>
                    <span id="geocoding_status" class="text-xs font-400 text-emerald-600 ml-2 hidden">⟳ Mengambil alamat...</span>
                </label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3"
                    class="form-input @error('alamat_lengkap') border-red-400 @enderror"
                    placeholder="Alamat terisi otomatis saat memilih titik, atau isi manual" required>{{ old('alamat_lengkap') }}</textarea>
                @error('alamat_lengkap')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── Wilayah ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-700 text-gray-800 mb-5 flex items-center gap-2">
                <span class="w-6 h-6 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center text-xs font-800">3</span>
                Wilayah
            </h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="form-label">RT <span class="text-red-500">*</span></label>
                    <input type="text" name="rt" value="{{ old('rt') }}"
                        class="form-input @error('rt') border-red-400 @enderror"
                        placeholder="cth: 001" maxlength="5" required>
                    @error('rt')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">RW <span class="text-red-500">*</span></label>
                    <input type="text" name="rw" value="{{ old('rw') }}"
                        class="form-input @error('rw') border-red-400 @enderror"
                        placeholder="cth: 003" maxlength="5" required>
                    @error('rw')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="form-label">Kabupaten / Kota</label>
                    <div class="form-input bg-gray-50 text-gray-500 cursor-not-allowed flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        Kabupaten Semarang
                    </div>
                    {{-- Hidden input agar tetap terkirim ke server --}}
                    <input type="hidden" name="kabupaten" value="Kabupaten Semarang">
                </div>
                <div>
                    <label class="form-label">Kecamatan <span class="text-red-500">*</span></label>
                    <select name="kecamatan"
                        class="form-input @error('kecamatan') border-red-400 @enderror" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->nama }}" {{ old('kecamatan') == $kec->nama ? 'selected' : '' }}>
                                {{ $kec->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kecamatan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- ── Jadwal Mudik ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-700 text-gray-800 mb-5 flex items-center gap-2">
                <span class="w-6 h-6 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center text-xs font-800">4</span>
                Jadwal Mudik
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Tanggal Berangkat <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_mulai_mudik" value="{{ old('tanggal_mulai_mudik') }}"
                        class="form-input @error('tanggal_mulai_mudik') border-red-400 @enderror" required>
                    @error('tanggal_mulai_mudik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Estimasi Kembali <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_selesai_mudik" value="{{ old('tanggal_selesai_mudik') }}"
                        class="form-input @error('tanggal_selesai_mudik') border-red-400 @enderror" required>
                    @error('tanggal_selesai_mudik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- ── Foto Rumah ── --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-700 text-gray-800 mb-2 flex items-center gap-2">
                <span class="w-6 h-6 bg-gray-100 text-gray-500 rounded-lg flex items-center justify-center text-xs font-800">5</span>
                Foto Rumah <span class="text-xs font-400 text-gray-400">(opsional)</span>
            </h2>
            <p class="text-xs text-gray-400 mb-4">Format JPG, PNG, atau WebP. Maks 2MB.</p>
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-emerald-400 transition cursor-pointer"
                onclick="document.getElementById('foto_rumah').click()">
                <div id="foto_preview" class="hidden mb-3">
                    <img id="preview_img" class="mx-auto max-h-40 rounded-lg object-cover" src="" alt="">
                </div>
                <div id="foto_placeholder">
                    <svg class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-400">Klik untuk upload foto rumah</p>
                </div>
                <input type="file" name="foto_rumah" id="foto_rumah" accept="image/*" class="hidden"
                    onchange="previewFoto(this)">
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-700 py-3.5 px-6 rounded-2xl transition shadow-lg shadow-emerald-200 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Daftarkan Rumah Mudik
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
// ─── Peta Leaflet ─────────────────────────────────────────────────────────────
let map, marker;
const defaultCenter = [-7.0051, 110.4381]; // Semarang

function initMap(lat, lng) {
    map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19,
    }).addTo(map);

    const icon = L.divIcon({
        html: `<div style="background:#059669;width:28px;height:28px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3)"></div>`,
        iconSize: [28, 28], iconAnchor: [14, 28],
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
    document.getElementById('latitude_display').value  = lat.toFixed(7);
    document.getElementById('longitude_display').value = lng.toFixed(7);
}

// Reverse Geocoding via Nominatim (GRATIS, tanpa API key)
let geocodeTimeout;
function reverseGeocode(lat, lng) {
    clearTimeout(geocodeTimeout);
    document.getElementById('geocoding_status').classList.remove('hidden');
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
            document.getElementById('geocoding_status').classList.add('hidden');
        }
    }, 800);
}

// Ambil GPS perangkat
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        pos => initMap(pos.coords.latitude, pos.coords.longitude),
        ()  => initMap(...defaultCenter)
    );
} else {
    initMap(...defaultCenter);
}

// ─── Preview Foto ──────────────────────────────────────────────────────────────
function previewFoto(input) {
    if (!input.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview_img').src = e.target.result;
        document.getElementById('foto_preview').classList.remove('hidden');
        document.getElementById('foto_placeholder').classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
}); // end DOMContentLoaded
</script>
@endpush