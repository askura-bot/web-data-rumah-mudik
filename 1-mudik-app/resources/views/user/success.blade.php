@extends('layouts.app')
@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center px-4">
    <div class="bg-white rounded-3xl shadow-xl p-10 max-w-md w-full text-center">
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-2xl font-800 text-gray-800 mb-2">Pendaftaran Berhasil!</h1>
        <p class="text-gray-500 text-sm mb-8">
            Data rumah mudik Anda telah tersimpan. Petugas akan memantau keamanan rumah Anda selama mudik.
        </p>
        <a href="{{ route('user.form') }}"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-600 px-6 py-3 rounded-xl transition text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Daftarkan Rumah Lain
        </a>
    </div>
</div>
@endsection
