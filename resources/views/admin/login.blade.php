@extends('layouts.app')
@section('title', 'Login Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center px-4">
    <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-xl font-800 text-gray-800">Panel Admin</h1>
            <p class="text-sm text-gray-400 mt-1">Pendataan Rumah Mudik</p>
        </div>

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm mb-4">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-600 text-gray-700 mb-2">Password Admin</label>
                <input type="password" name="password"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-500 @error('password') border-red-400 @enderror"
                    placeholder="Masukkan password" autofocus required>
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-slate-800 hover:bg-slate-700 text-white font-600 py-3 rounded-xl transition">
                Masuk
            </button>
        </form>
    </div>
</div>
@endsection
