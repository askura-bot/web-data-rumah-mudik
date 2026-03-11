{{-- Views/admin/login --}}
@extends('layouts.AdminLayout')
@section('title', 'Login — Sistem Patroli Mudik')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

:root {
    --navy:    #0a1628;
    --navy2:   #0f2040;
    --blue:    #1a3a6b;
    --accent:  #f5a623;
    --danger:  #e53e3e;
    --cream:   #f8f9fb;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--navy); min-height: 100vh; }

/* ── Background ── */
.login-bg {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(ellipse at 20% 50%, rgba(26,58,107,0.6) 0%, transparent 60%),
        radial-gradient(ellipse at 80% 20%, rgba(245,166,35,0.08) 0%, transparent 50%),
        linear-gradient(160deg, #0a1628 0%, #0d1f3c 50%, #0a1628 100%);
}

/* Grid pattern */
.login-bg::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
}

/* Glow accent kanan bawah */
.login-bg::after {
    content: '';
    position: absolute;
    bottom: -100px; right: -100px;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(245,166,35,0.06) 0%, transparent 70%);
    pointer-events: none;
}

/* ── Card ── */
.login-card {
    width: 100%;
    max-width: 420px;
    position: relative;
    z-index: 1;
    animation: cardIn 0.5s cubic-bezier(0.34,1.2,0.64,1) both;
}
@keyframes cardIn {
    from { opacity:0; transform: translateY(24px) scale(0.97); }
    to   { opacity:1; transform: translateY(0) scale(1); }
}

/* Badge instansi */
.instansi-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 2rem;
}
.badge-logo {
    width: 52px; height: 52px;
    background: linear-gradient(135deg, #1a3a6b, #0f2040);
    border: 2px solid rgba(245,166,35,0.4);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.08);
}
.badge-text { text-align: left; }
.badge-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1rem; font-weight: 800;
    color: #fff;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    line-height: 1.1;
}
.badge-sub {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.45);
    margin-top: 2px;
    letter-spacing: 0.03em;
}

/* Form box */
.form-box {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 24px 64px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.06);
}

.form-title {
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: 0.03em;
    margin-bottom: 4px;
}
.form-desc {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.4);
    margin-bottom: 1.5rem;
}

/* Divider */
.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    margin-bottom: 1.5rem;
}

/* Input group */
.input-group { margin-bottom: 1.25rem; }
.input-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: rgba(255,255,255,0.55);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.input-icon {
    position: absolute;
    left: 14px;
    color: rgba(255,255,255,0.25);
    pointer-events: none;
    display: flex;
    align-items: center;
}
.pw-input {
    width: 100%;
    background: rgba(255,255,255,0.06);
    border: 1.5px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 12px 48px 12px 44px;
    font-size: 0.9rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #fff;
    outline: none;
    transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    letter-spacing: 0.02em;
}
.pw-input::placeholder { color: rgba(255,255,255,0.2); }
.pw-input:focus {
    border-color: rgba(245,166,35,0.5);
    background: rgba(255,255,255,0.08);
    box-shadow: 0 0 0 3px rgba(245,166,35,0.1);
}
.pw-input.is-error { border-color: rgba(229,62,62,0.6); }

.toggle-pw {
    position: absolute;
    right: 14px;
    background: none;
    border: none;
    cursor: pointer;
    color: rgba(255,255,255,0.3);
    display: flex; align-items: center;
    transition: color 0.2s;
    padding: 4px;
    border-radius: 6px;
}
.toggle-pw:hover { color: rgba(255,255,255,0.7); }

.error-msg {
    font-size: 0.72rem;
    color: #fc8181;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Alert error dari session */
.alert-error {
    background: rgba(229,62,62,0.12);
    border: 1px solid rgba(229,62,62,0.3);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 0.8rem;
    color: #fc8181;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Submit */
.btn-login {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, #1a3a6b 0%, #1e4a8a 100%);
    border: 1px solid rgba(245,166,35,0.3);
    border-radius: 12px;
    color: #fff;
    font-family: 'Barlow Condensed', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: transform 0.15s, box-shadow 0.15s, background 0.2s;
    box-shadow: 0 4px 16px rgba(26,58,107,0.5), inset 0 1px 0 rgba(255,255,255,0.08);
}
.btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(26,58,107,0.6);
    background: linear-gradient(135deg, #1e4a8a 0%, #2255a4 100%);
}
.btn-login:active { transform: translateY(0); }

/* Accent strip atas card */
.accent-strip {
    height: 3px;
    background: linear-gradient(90deg, #f5a623, #fbbf24, #f5a623);
    border-radius: 20px 20px 0 0;
    margin: -2rem -2rem 2rem;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
}

/* Footer */
.login-footer {
    text-align: center;
    margin-top: 1.5rem;
    font-size: 0.7rem;
    color: rgba(255,255,255,0.2);
    line-height: 1.6;
}

/* Status bar atas */
.status-bar {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #f5a623 0%, #fbbf24 50%, #f5a623 100%);
    z-index: 100;
}
</style>
@endpush

@section('content')
<div class="status-bar"></div>
<div class="login-bg">
    <div class="login-card">

        {{-- Logo instansi --}}
        <div class="instansi-badge">
            <div class="badge-logo">
                <svg width="26" height="26" fill="none" viewBox="0 0 24 24">
                    <path fill="#f5a623" d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
                </svg>
            </div>
            <div class="badge-text">
                <div class="badge-title">Sistem Patroli Mudik</div>
                <div class="badge-sub">Kabupaten Semarang · Lebaran 1446 H</div>
            </div>
        </div>

        {{-- Form box --}}
        <div class="form-box">
            <div class="accent-strip"></div>

            <div class="form-title">Akses Petugas</div>
            <div class="form-desc">Masukkan kata sandi untuk melanjutkan ke panel pengawasan</div>

            <div class="divider"></div>

            @if(session('error'))
            <div class="alert-error">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="input-group">
                    <label class="input-label">Kata Sandi</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="pw-input @error('password') is-error @enderror"
                            placeholder="••••••••"
                            autofocus
                            required>
                        <button type="button" class="toggle-pw" id="toggle-pw" title="Tampilkan/sembunyikan">
                            {{-- Eye icon --}}
                            <svg id="icon-eye" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{-- Eye-off icon --}}
                            <svg id="icon-eye-off" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="error-msg">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk ke Sistem
                </button>
            </form>
        </div>

        <div class="login-footer">
            Sistem Pendataan Rumah Mudik<br>
            Polres Kabupaten Semarang · {{ date('Y') }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input   = document.getElementById('password');
    const btn     = document.getElementById('toggle-pw');
    const eyeOn   = document.getElementById('icon-eye');
    const eyeOff  = document.getElementById('icon-eye-off');
    let visible   = false;

    btn.addEventListener('click', function () {
        visible = !visible;
        input.type     = visible ? 'text' : 'password';
        eyeOn.style.display  = visible ? 'none'  : 'block';
        eyeOff.style.display = visible ? 'block' : 'none';
        btn.style.color = visible ? 'rgba(245,166,35,0.8)' : 'rgba(255,255,255,0.3)';
    });
});
</script>
@endpush