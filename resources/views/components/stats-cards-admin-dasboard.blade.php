{{-- ── Stat Cards ── --}}
    @php
        $today   = \Carbon\Carbon::today();
        $total   = \App\Models\RumahMudik::count();
        $aktif   = \App\Models\RumahMudik::whereDate('tanggal_mulai_mudik', '<=', $today)->whereDate('tanggal_selesai_mudik', '>=', $today)->count();
        $hariIni = \App\Models\RumahMudik::whereDate('created_at', $today)->count();
    @endphp
    <div class="stats">
        <div class="sc">
            <div class="sc-ico blue">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <div><span class="sc-val">{{ $total }}</span><span class="sc-lbl">Total Rumah</span></div>
        </div>
        <div class="sc">
            <div class="sc-ico amber">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div><span class="sc-val">{{ $aktif }}</span><span class="sc-lbl">Sedang Mudik</span></div>
        </div>
        <div class="sc">
            <div class="sc-ico green">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div><span class="sc-val">{{ $hariIni }}</span><span class="sc-lbl">Hari Ini</span></div>
        </div>
    </div>