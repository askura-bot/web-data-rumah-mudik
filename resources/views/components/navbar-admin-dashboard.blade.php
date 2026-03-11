{{-- resources/views/components/navbar-admin.blade.php --}}
{{-- Usage: @include('components.navbar-admin', ['activePage' => 'data']) --}}
{{-- activePage: 'data' | 'peta' | 'wilayah' --}}

@php $activePage = $activePage ?? ''; @endphp

<div class="topbar">
    <div class="topbar-in">
        <div class="t-brand">
            <div class="t-logo">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24">
                    <path fill="#f5a623" d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
                </svg>
            </div>
            <div class="t-text">
                <span class="t-title">Sistem Patroli Mudik</span>
                <span class="t-sub">Kab. Semarang · Lebaran 1446 H</span>
            </div>
        </div>

        <div class="t-right">
            {{-- Badge total --}}
            @isset($totalRumah)
            <span class="t-badge">{{ $totalRumah }} Terdaftar</span>
            @endisset

            {{-- Nav: Data Rumah --}}
            <a href="{{ route('admin.data') }}"
               class="t-navlink {{ $activePage === 'data' ? 'active' : '' }}">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M3 14h18M3 6h18M3 18h18"/>
                </svg>
                <span class="t-navlink-txt">Data</span>
            </a>

            {{-- Nav: Peta --}}
            <a href="{{ route('admin.peta') }}"
               class="t-navlink {{ $activePage === 'peta' ? 'active' : '' }}">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                <span class="t-navlink-txt">Peta</span>
            </a>

            {{-- Dropdown Wilayah --}}
            <div class="t-dropdown" id="wilayah-dropdown">
                <button class="t-navlink {{ $activePage === 'wilayah' ? 'active' : '' }}"
                    id="wilayah-btn" onclick="toggleDropdown(event)">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="t-navlink-txt">Wilayah</span>
                    <svg class="t-chevron" width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="t-menu" id="wilayah-menu">
                    <a href="{{ route('admin.wilayah.kecamatan') }}" class="t-menu-item">
                        <div class="t-menu-ico" style="background:rgba(30,74,138,.12)">
                            <svg width="13" height="13" fill="none" stroke="#1e4a8a" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                        <div>
                            <div class="t-menu-label">Kecamatan</div>
                            <div class="t-menu-hint">Kelola data kecamatan</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.wilayah.kelurahan') }}" class="t-menu-item">
                        <div class="t-menu-ico" style="background:rgba(245,166,35,.12)">
                            <svg width="13" height="13" fill="none" stroke="#c47d0e" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="t-menu-label">Kelurahan</div>
                            <div class="t-menu-hint">Kelola data kelurahan</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Keluar --}}
            <a href="{{ route('admin.logout') }}" class="t-out">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="t-out-txt">Keluar</span>
            </a>
        </div>
    </div>
</div>