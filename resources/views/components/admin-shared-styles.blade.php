{{-- resources/views/components/admin-shared-styles.blade.php --}}
{{-- Include di @push('styles') setiap halaman admin --}}
<style>
/* ── Shared admin styles ───────────────────────────────────────────── */
:root {
    --navy:   #1C1C1C;   /* Blackboard */
    --blue:   #3B3B3B;   /* Rich Grey */
    --blue2:  #FFE002;   /* Golden Yellow */
    --accent: #FFB606;   /* Intense Fire */
    --gold-dark: #B28228; /* University of California Gold */
    --surf:   #F5F5F5;   /* light gray for panels */
    --border: #E0E0E0;   /* light border */
    --text:   #1C1C1C;   /* Blackboard for text */
    --muted:  #6B7280;   /* gray */
    --green:  #FFB606;   /* Intense Fire used for success/active */
    --red:    #B28228;   /* Gold for warnings/deletes */
    --white:  #FFFFFF;
    --radius: 12px;
    --shadow: 0 1px 4px rgba(0,0,0,.07);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; background: #f0f2f7; color: var(--text); -webkit-text-size-adjust: 100%; }

/* ── Topbar ── */
.topbar { background: var(--navy); position: sticky; top: 0; z-index: 999; border-bottom: 2px solid var(--accent); box-shadow: 0 2px 12px rgba(0,0,0,.5); }
.topbar-in { max-width: 1400px; margin: 0 auto; padding: 0 1rem; height: 52px; display: flex; align-items: center; justify-content: space-between; gap: .5rem; }
.t-brand { display: flex; align-items: center; gap: 8px; min-width: 0; flex: 1; }
/* Sesuaikan logo dengan tema navigasi */
.t-logo { width: 32px; height: 32px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.t-text { min-width: 0; }
.t-title { font-family: 'Barlow Condensed', sans-serif; font-size: .9rem; font-weight: 700; color: #fff; letter-spacing: .05em; text-transform: uppercase; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
.t-sub   { font-size: .6rem; color: rgba(255,255,255,.35); display: block; margin-top: 1px; }
.t-right { display: flex; align-items: center; gap: 5px; flex-shrink: 0; }
.t-badge { font-size: .68rem; font-weight: 600; color: var(--accent); background: rgba(255,182,6,.12); border: 1px solid rgba(255,182,6,.25); border-radius: 99px; padding: 3px 10px; white-space: nowrap; }

/* Nav links */
.t-navlink {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .72rem; font-weight: 600;
    color: rgba(255,255,255,.6);
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 7px; padding: 5px 10px;
    text-decoration: none; cursor: pointer;
    transition: all .2s; white-space: nowrap;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.t-navlink:hover { color: #fff; background: rgba(255,255,255,.13); border-color: rgba(255,255,255,.2); }
.t-navlink.active { color: #fff; background: rgba(255,182,6,.18); border-color: rgba(255,182,6,.4); }
.t-navlink-txt { display: none; }
@media (min-width: 500px) { .t-navlink-txt { display: inline; } }

.t-chevron { transition: transform .2s; opacity: .5; flex-shrink: 0; }
.t-navlink.open .t-chevron { transform: rotate(180deg); opacity: 1; }

/* Dropdown */
.t-dropdown { position: relative; }
.t-menu { display: none; position: absolute; top: calc(100% + 8px); right: 0; background: #fff; border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 8px 32px rgba(0,0,0,.18); min-width: 210px; overflow: hidden; z-index: 1000; animation: menuDrop .15s ease; }
.t-menu.open { display: block; }
@keyframes menuDrop { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
.t-menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; text-decoration: none; transition: background .15s; border-bottom: 1px solid var(--border); }
.t-menu-item:last-child { border-bottom: none; }
.t-menu-item:hover { background: #f5f7ff; }
.t-menu-ico { width: 30px; height: 30px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.t-menu-label { font-size: .8rem; font-weight: 700; color: var(--navy); }
.t-menu-hint  { font-size: .67rem; color: var(--muted); margin-top: 1px; }

.t-out { display: inline-flex; align-items: center; gap: 4px; font-size: .72rem; font-weight: 600; color: rgba(255,255,255,.6); background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12); border-radius: 7px; padding: 5px 11px; text-decoration: none; transition: all .2s; white-space: nowrap; }
.t-out:hover { color: #fff; background: rgba(255,255,255,.13); }
.t-out-txt { display: none; }
@media (min-width: 600px) { .t-out-txt { display: inline; } }
@media (max-width: 499px) { .t-badge { display: none; } }
@media (max-width: 380px) { .t-sub { display: none; } }

/* ── Page Wrap ── */
.wrap { max-width: 1400px; margin: 0 auto; padding: 1rem; display: flex; flex-direction: column; gap: 1rem; }

/* ── Panel ── */
.panel { background: var(--white); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; }
.ph { padding: .75rem 1rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-wrap: wrap; background: linear-gradient(135deg, #f8f9ff 0%, #fff 100%); }
.ph-title { display: flex; align-items: center; gap: 7px; font-weight: 700; font-size: .82rem; color: var(--text); }
.ph-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.ph-hint { font-size: .68rem; color: var(--muted); }

/* ── Filter ── */
.fb { padding: .875rem 1rem; }
.fg { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: .625rem; align-items: end; }
.fl { display: block; font-size: .67rem; font-weight: 700; color: var(--muted); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 4px; }
.fi { width: 100%; padding: 8px 11px; border: 1.5px solid var(--border); border-radius: 8px; font-size: .8rem; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); background: #fff; outline: none; transition: border-color .2s, box-shadow .2s; -webkit-appearance: none; appearance: none; }
.fi:focus { border-color: var(--blue2); box-shadow: 0 0 0 3px rgba(255,224,2,.1); }
.fi-rt-rw { display: grid; grid-template-columns: 1fr 1fr; gap: .625rem; }
select.fi { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 9px center; background-size: 15px; padding-right: 30px; cursor: pointer; }
.fa { display: flex; gap: .5rem; align-items: flex-end; }
.btn-s { flex: 1; padding: 8px 14px; background: var(--navy); color: #fff; font-size: .78rem; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px; white-space: nowrap; transition: background .2s; }
.btn-s:hover { background: var(--blue); }
.btn-r { flex: 1; padding: 8px 12px; background: var(--surf); color: var(--muted); font-size: .78rem; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif; border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px; white-space: nowrap; text-decoration: none; transition: all .2s; }
.btn-r:hover { color: var(--text); border-color: #bac0cc; }

/* Filter hint untuk RT/RW */
.fi-hint { font-size: .65rem; color: #9ca3af; margin-top: 3px; }
.fi-group-label { font-size: .67rem; font-weight: 700; color: var(--muted); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 4px; display: block; }

@media (max-width: 1024px) { .fg { grid-template-columns: 1fr 1fr 1fr; } .fa { grid-column: 1 / -1; } }
@media (max-width: 640px)  { .fb { padding: .75rem; } .fg { grid-template-columns: 1fr 1fr; gap: .5rem; } .fa { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; } }
@media (max-width: 400px)  { .fg { grid-template-columns: 1fr; } }

/* ── Stat cards ── */
.stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; }
.sc { background: var(--white); border-radius: var(--radius); padding: .875rem 1rem; border: 1px solid var(--border); box-shadow: var(--shadow); display: flex; align-items: center; gap: 12px; }
.sc-ico { width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.sc-ico.blue  { background: rgba(28,28,28,.1);  color: var(--navy); }
.sc-ico.amber { background: rgba(255,224,2,.12); color: var(--blue2); }
.sc-ico.green { background: rgba(255,182,6,.1);  color: var(--accent); }
.sc-val { font-family: 'Barlow Condensed', sans-serif; font-size: 1.6rem; font-weight: 800; color: var(--text); line-height: 1; display: block; }
.sc-lbl { font-size: .68rem; color: var(--muted); font-weight: 500; margin-top: 2px; display: block; }
@media (max-width: 480px) { .stats { gap: .5rem; } .sc { padding: .75rem; gap: 8px; } .sc-ico { width: 34px; height: 34px; } .sc-val { font-size: 1.3rem; } .sc-lbl { font-size: .62rem; } }
</style>