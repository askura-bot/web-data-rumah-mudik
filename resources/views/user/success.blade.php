@extends('layouts.app')
@section('title', 'Pendaftaran Berhasil')

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Lora:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --teal: #0f6b5c;
    --teal-mid: #148a73;
    --gold: #c9932a;
    --cream: #faf7f2;
}
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--cream); margin: 0; }

.success-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    position: relative;
    overflow: hidden;
    background: linear-gradient(160deg, #e6f4f1 0%, #faf7f2 50%, #fdf3e0 100%);
}

/* Ornamen latar */
.bg-circle {
    position: fixed;
    border-radius: 50%;
    pointer-events: none;
}

.card {
    background: #fff;
    border-radius: 28px;
    padding: 2.5rem 2rem;
    max-width: 440px;
    width: 100%;
    text-align: center;
    box-shadow: 0 20px 60px rgba(15,107,92,0.12), 0 4px 16px rgba(0,0,0,0.06);
    position: relative;
    z-index: 1;
    animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
@keyframes popIn {
    from { opacity: 0; transform: scale(0.85) translateY(20px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

/* Ornamen atas kartu */
.card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--teal), #2dd4bf, var(--gold));
    border-radius: 28px 28px 0 0;
}

.icon-wrap {
    width: 88px; height: 88px;
    background: linear-gradient(135deg, var(--teal), var(--teal-mid));
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 8px 24px rgba(15,107,92,0.35);
    animation: iconBounce 0.6s 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
@keyframes iconBounce {
    from { transform: scale(0); }
    to   { transform: scale(1); }
}

.badge-eid {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fdf3e0;
    border: 1px solid rgba(201,147,42,0.3);
    color: #92650a;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 99px;
    margin-bottom: 1rem;
    animation: fadeIn 0.4s 0.5s ease both;
}

h1 {
    font-family: 'Lora', serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 0.5rem;
    animation: fadeIn 0.4s 0.4s ease both;
}
.sub {
    font-size: 0.875rem;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 1.75rem;
    animation: fadeIn 0.4s 0.5s ease both;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.info-box {
    background: linear-gradient(135deg, #e6f4f1, #f0faf8);
    border: 1px solid rgba(15,107,92,0.15);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    text-align: left;
    animation: fadeIn 0.4s 0.6s ease both;
}
.info-box p { font-size: 0.8rem; color: #374151; line-height: 1.6; margin: 0; }
.info-box strong { color: var(--teal); }

.btn-again {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 13px 24px;
    background: linear-gradient(135deg, var(--teal), var(--teal-mid));
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
    border-radius: 14px;
    text-decoration: none;
    transition: transform 0.15s, box-shadow 0.15s;
    box-shadow: 0 6px 18px rgba(15,107,92,0.3);
    animation: fadeIn 0.4s 0.7s ease both;
}
.btn-again:hover { transform: translateY(-1px); box-shadow: 0 8px 22px rgba(15,107,92,0.38); }

/* Confetti dots */
.dot {
    position: absolute;
    border-radius: 50%;
    animation: fall linear infinite;
    pointer-events: none;
}
@keyframes fall {
    0%   { transform: translateY(-10px) rotate(0deg); opacity: 1; }
    100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
}
</style>
@endpush

@section('content')
<div class="success-page" id="success-page">
    <div class="card">
        <div class="badge-eid">
            ✦ Marhaban Ya Ramadhan
        </div>

        <div class="icon-wrap">
            <svg width="40" height="40" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1>Pendaftaran Berhasil!</h1>
        <p class="sub">
            Data rumah Anda telah tersimpan dan siap dipantau
            oleh petugas keamanan selama mudik Lebaran.
        </p>

        <div class="info-box">
            <p>
                <strong>Apa yang terjadi selanjutnya?</strong><br>
                Petugas keamanan setempat akan mendapatkan data lokasi rumah Anda dan
                melakukan patroli rutin sesuai jadwal mudik yang telah didaftarkan.
            </p>
        </div>

        <a href="{{ route('user.form') }}" class="btn-again">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Daftarkan Rumah Lain
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Confetti sederhana
document.addEventListener('DOMContentLoaded', function () {
    const colors = ['#0f6b5c','#c9932a','#2dd4bf','#f59e0b','#34d399','#fbbf24'];
    const container = document.getElementById('success-page');
    for (let i = 0; i < 24; i++) {
        const dot = document.createElement('div');
        dot.className = 'dot';
        const size = Math.random() * 8 + 4;
        dot.style.cssText = `
            width:${size}px;height:${size}px;
            background:${colors[Math.floor(Math.random()*colors.length)]};
            left:${Math.random()*100}%;
            top:${Math.random()*-20}%;
            opacity:0.7;
            animation-duration:${Math.random()*4+3}s;
            animation-delay:${Math.random()*2}s;
        `;
        container.appendChild(dot);
    }
});
</script>
@endpush