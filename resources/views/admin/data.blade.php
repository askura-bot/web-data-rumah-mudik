{{-- resources/views/admin/data.blade.php --}}
@extends('layouts.AdminLayout')
@section('title', 'Data Rumah — Sistem Patroli Mudik')

@push('styles')
@include('components.admin-shared-styles')
<style>
/* ── Table ── */
.sort-tgl { display: inline-flex; align-items: center; border: 1.5px solid var(--border); border-radius: 8px; overflow: hidden; background: var(--surf); flex-shrink: 0; }
.srt { padding: 5px 10px; font-size: .7rem; font-weight: 600; color: var(--muted); background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all .15s; white-space: nowrap; text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif; }
.srt:hover { background: #eaecf5; color: var(--text); }
.srt.on { background: var(--navy); color: #fff; }
.srt-sep { width: 1px; background: var(--border); align-self: stretch; }
.tbl-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
.tbl-hint { display: none; padding: 6px 1rem; font-size: .67rem; color: var(--muted); background: #fffbf2; border-bottom: 1px solid #f5e8cc; gap: 5px; align-items: center; }
@media (max-width: 767px) { .tbl-hint { display: flex; } }
table { width: 100%; min-width: 740px; border-collapse: collapse; }
thead tr { background: linear-gradient(135deg, #f0f4ff, #f8f9fb); }
th { padding: 9px 12px; text-align: left; font-size: .65rem; font-weight: 700; color: var(--muted); letter-spacing: .07em; text-transform: uppercase; white-space: nowrap; border-bottom: 1.5px solid var(--border); }
td { padding: 10px 12px; border-bottom: 1px solid #f0f2f6; vertical-align: middle; }
tr:last-child td { border-bottom: none; }
tbody tr { transition: background .12s; }
tbody tr:hover { background: #f5f7ff; }
.nik    { font-family: monospace; font-size: .77rem; color: #374151; }
.nama   { font-weight: 600; font-size: .82rem; color: var(--text); }
.kec-b  { display: inline-block; padding: 2px 8px; background: rgba(26,58,107,.08); color: var(--blue2); font-size: .69rem; font-weight: 600; border-radius: 99px; white-space: nowrap; }
.kel-b  { display: inline-block; padding: 2px 8px; background: rgba(245,166,35,.1); color: #92650a; font-size: .65rem; font-weight: 600; border-radius: 99px; white-space: nowrap; margin-top: 3px; }
.rtrw  { font-size: .73rem; color: var(--muted); white-space: nowrap; }
.d1    { font-size: .76rem; font-weight: 600; color: var(--text); white-space: nowrap; }
.d2    { font-size: .69rem; color: var(--muted); white-space: nowrap; }
.tc    { font-size: .69rem; color: var(--muted); white-space: nowrap; }
.nbadge { display: inline-block; font-size: .63rem; background: #dcfce7; color: #166534; padding: 1px 6px; border-radius: 99px; font-weight: 600; margin-top: 3px; }
.fthumb { width: 36px; height: 36px; border-radius: 7px; object-fit: cover; border: 1.5px solid var(--border); display: block; }
.nofoto { width: 36px; height: 36px; border-radius: 7px; background: var(--surf); border: 1.5px dashed #cdd2dc; display: flex; align-items: center; justify-content: center; }
.btn-det { display: inline-flex; align-items: center; gap: 4px; padding: 5px 12px; background: var(--navy); color: #fff; font-size: .7rem; font-weight: 600; border-radius: 7px; text-decoration: none; transition: background .2s; white-space: nowrap; font-family: 'Plus Jakarta Sans', sans-serif; }
.btn-det:hover { background: var(--blue); }
.empty-wrap { padding: 3rem 1rem; text-align: center; color: var(--muted); }
.empty-ico { width: 50px; height: 50px; background: var(--surf); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; }
.pagi { padding: 10px 14px; border-top: 1px solid var(--border); }
.pagi nav { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; }

/* Active filter pill */
.filter-active {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px 3px 8px;
    background: rgba(30,74,138,.08); color: var(--blue2);
    border: 1px solid rgba(30,74,138,.2);
    border-radius: 99px; font-size: .69rem; font-weight: 600;
    text-decoration: none;
}
.filter-active:hover { background: rgba(30,74,138,.14); }
</style>
@endpush

@section('content')

@include('components.navbar-admin-dashboard', [
    'activePage'  => 'data',
    'totalRumah'  => $rumahList->total(),
])

<div class="wrap">

    @include('components.stats-cards-admin-dasboard')

    {{-- ── Filter ── --}}
    <div class="panel">
        <div class="ph">
            <div class="ph-title">
                <div class="ph-dot" style="background:var(--blue2)"></div>
                Filter & Pencarian
            </div>
            {{-- Pills filter aktif --}}
            @if(request('rt') || request('rw') || request('kecamatan') || request('nik'))
            <div style="display:flex;gap:5px;flex-wrap:wrap">
                @if(request('nik'))
                    <span class="filter-active">NIK: {{ request('nik') }}</span>
                @endif
                @if(request('kecamatan'))
                    <span class="filter-active">Kec: {{ request('kecamatan') }}</span>
                @endif
                @if(request('rt'))
                    <span class="filter-active">RT: {{ (int)request('rt') }}</span>
                @endif
                @if(request('rw'))
                    <span class="filter-active">RW: {{ (int)request('rw') }}</span>
                @endif
                <a href="{{ route('admin.data') }}" class="filter-active" style="background:rgba(220,38,38,.07);color:var(--red);border-color:rgba(220,38,38,.2)">
                    × Hapus semua
                </a>
            </div>
            @endif
        </div>
        <form method="GET" action="{{ route('admin.data') }}">
            <div class="fb">
                <div class="fg">
                    {{-- NIK --}}
                    <div>
                        <label class="fl">Cari NIK</label>
                        <input type="text" name="nik" value="{{ request('nik') }}"
                            class="fi" placeholder="Nomor induk kependudukan...">
                    </div>

                    {{-- Kecamatan --}}
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

                    {{-- RT & RW berdampingan --}}
                    <div>
                        <span class="fi-group-label">RT &amp; RW <p class="fi-hint">004 / 04 / 4 dianggap sama</p> </span>
                        <div class="fi-rt-rw">
                            <div>
                                <input type="text" name="rt" value="{{ request('rt') }}"
                                    class="fi" placeholder="RT (cth: 4)"
                                    inputmode="numeric"
                                    oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                            <div>
                                <input type="text" name="rw" value="{{ request('rw') }}"
                                    class="fi" placeholder="RW (cth: 3)"
                                    inputmode="numeric"
                                    oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        
                    </div>

                    {{-- Urutkan --}}
                    <div>
                        <label class="fl">Urutkan</label>
                        <select name="sort" class="fi">
                            <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Data Terbaru</option>
                            <option value="terlama" {{ $sort === 'terlama' ? 'selected' : '' }}>Data Terlama</option>
                        </select>
                    </div>

                    <div class="fa">
                        <button type="submit" class="btn-s">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari
                        </button>
                        <a href="{{ route('admin.data') }}" class="btn-r">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ── Tabel ── --}}
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
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                    Terbaru
                </a>
                <div class="srt-sep"></div>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'terlama', 'page' => 1]) }}"
                   class="srt {{ $sort === 'terlama' ? 'on' : '' }}">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/></svg>
                    Terlama
                </a>
            </div>
        </div>

        <div class="tbl-hint">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            Geser kanan/kiri untuk melihat semua kolom
        </div>

        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIK</th>
                        <th>Nama Pemilik</th>
                        <th>Kecamatan / Kelurahan</th>
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
                        <td>
                            <span class="kec-b">{{ $rumah->kecamatan }}</span>
                            @if($rumah->kelurahan)
                                <br><span class="kel-b">{{ $rumah->kelurahan }}</span>
                            @endif
                        </td>
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
                                    <svg width="14" height="14" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
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
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-wrap">
                                <div class="empty-ico">
                                    <svg width="22" height="22" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                                <p style="font-size:.82rem">Belum ada data yang sesuai filter</p>
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

</div>
@endsection

@push('scripts')
<script>
function toggleDropdown(e) {
    e.stopPropagation();
    const btn  = document.getElementById('wilayah-btn');
    const menu = document.getElementById('wilayah-menu');
    btn.classList.toggle('open');
    menu.classList.toggle('open');
}
document.addEventListener('click', function () {
    document.getElementById('wilayah-btn')?.classList.remove('open');
    document.getElementById('wilayah-menu')?.classList.remove('open');
});
</script>
@endpush