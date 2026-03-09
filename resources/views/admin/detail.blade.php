@extends('layouts.app')
@section('title', 'Detail Rumah – ' . $rumah->nama_pemilik)

@push('styles')
<style>#detail-map { height: 320px; }</style>
@endpush

@section('content')
<nav class="bg-slate-900 text-white px-6 py-4 flex items-center gap-4">
    <a href="{{ route('admin.dashboard') }}" class="text-slate-400 hover:text-white transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <span class="font-700 text-sm">Detail Rumah Mudik</span>
</nav>

<div class="max-w-3xl mx-auto px-4 py-6 space-y-5">

    {{-- Info Pemilik --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h1 class="text-xl font-800 text-gray-800">{{ $rumah->nama_pemilik }}</h1>
                <p class="text-sm text-gray-400 font-mono mt-0.5">NIK: {{ $rumah->nik }}</p>
            </div>
            @if($rumah->foto_rumah)
            <img src="{{ Storage::url($rumah->foto_rumah) }}" class="w-20 h-20 rounded-xl object-cover border border-gray-200" alt="Foto Rumah">
            @endif
        </div>
        <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <div>
                <p class="text-xs text-gray-400">Alamat</p>
                <p class="font-500 text-gray-700">{{ $rumah->alamat_lengkap }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">RT / RW</p>
                <p class="font-500 text-gray-700">RT {{ $rumah->rt }} / RW {{ $rumah->rw }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Kecamatan</p>
                <p class="font-500 text-gray-700">{{ $rumah->kecamatan }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Kabupaten</p>
                <p class="font-500 text-gray-700">{{ $rumah->kabupaten }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Tanggal Mudik</p>
                <p class="font-500 text-emerald-700">
                    {{ $rumah->tanggal_mulai_mudik->format('d M Y') }} –
                    {{ $rumah->tanggal_selesai_mudik->format('d M Y') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Didaftarkan</p>
                <p class="font-500 text-gray-700">{{ $rumah->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Peta --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-700 text-gray-700">Titik Lokasi Rumah</p>
            <p class="text-xs text-gray-400">{{ $rumah->latitude }}, {{ $rumah->longitude }}</p>
        </div>
        <div id="detail-map"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const lat = {{ $rumah->latitude }};
const lng = {{ $rumah->longitude }};
const map = L.map('detail-map').setView([lat, lng], 17);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors', maxZoom: 19
}).addTo(map);

const icon = L.divIcon({
    html: `<div style="background:#dc2626;width:24px;height:24px;border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3)"></div>`,
    iconSize: [24, 24], iconAnchor: [12, 24],
});
L.marker([lat, lng], { icon }).addTo(map)
    .bindPopup('<b>{{ $rumah->nama_pemilik }}</b><br>{{ $rumah->alamat_lengkap }}')
    .openPopup();
</script>
@endpush
