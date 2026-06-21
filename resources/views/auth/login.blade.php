<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB; --brand-light: #3B82F6;
            --accent: #06B6D4;
            --ink: #0F172A; --ink-3: #64748B; --ink-4: #94A3B8;
            --border: #E2E8F0; --surface: #F8FAFC;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(145deg,#060D1A,#0B1A35 55%,#060D1A);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem 1.5rem;
            position: relative; overflow: hidden;
        }

        .bg-grid { position: fixed; inset: 0; z-index: 0; pointer-events: none; opacity: .028; background-image: linear-gradient(rgba(255,255,255,.6) 1px,transparent 1px), linear-gradient(90deg,rgba(255,255,255,.6) 1px,transparent 1px); background-size: 54px 54px; }
        .bg-orb1 { position: fixed; width: 600px; height: 600px; border-radius: 50%; background: radial-gradient(circle,rgba(37,99,235,.16),transparent 65%); top: -280px; left: 15%; pointer-events: none; z-index: 0; }
        .bg-orb2 { position: fixed; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle,rgba(6,182,212,.1),transparent 65%); bottom: -160px; right: 5%; pointer-events: none; z-index: 0; }

        /* WRAPPER */
        .wrapper { position: relative; z-index: 10; width: 100%; max-width: 760px; display: flex; flex-direction: column; align-items: center; gap: 1.4rem; }

        /* BRAND */
        .brand { display: flex; align-items: center; gap: .6rem; animation: fadeDown .5s ease-out both; }
        .brand-mark { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg,var(--accent),var(--brand)); display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 8px 24px rgba(37,99,235,.38); }
        .brand-name { font-size: 1.05rem; font-weight: 800; color: #fff; letter-spacing: -.02em; }

        /* CARD */
        .card {
            width: 100%; background: #fff;
            border-radius: 26px; overflow: hidden;
            box-shadow: 0 32px 72px rgba(0,0,0,.48), 0 0 0 1px rgba(255,255,255,.06);
            animation: riseUp .7s cubic-bezier(.16,1,.3,1) .1s both;
            display: grid;
            grid-template-columns: 260px 1fr;
        }

        /* LEFT */
        .panel-left {
            background: linear-gradient(155deg,#091520,#0E2040);
            padding: 2.25rem 1.75rem;
            display: flex; flex-direction: column; justify-content: center; gap: 1.5rem;
            position: relative; overflow: hidden;
        }
        .p-glow1 { position: absolute; width: 280px; height: 280px; border-radius: 50%; background: radial-gradient(circle,rgba(37,99,235,.2),transparent 65%); top: -110px; left: -50px; pointer-events: none; }
        .p-glow2 { position: absolute; width: 180px; height: 180px; border-radius: 50%; background: radial-gradient(circle,rgba(6,182,212,.1),transparent 65%); bottom: -55px; right: -30px; pointer-events: none; }
        .p-dots { position: absolute; inset: 0; pointer-events: none; opacity: .035; background-image: radial-gradient(circle,#fff 1px,transparent 1px); background-size: 26px 26px; }

        .left-icon-wrap { position: relative; z-index: 2; }
        .left-icon {
            width: 64px; height: 64px; border-radius: 18px;
            background: linear-gradient(135deg,var(--accent),var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 1.8rem;
            box-shadow: 0 10px 28px rgba(37,99,235,.45);
            animation: pop .6s cubic-bezier(.34,1.56,.64,1) .3s both;
        }

        .left-text { position: relative; z-index: 2; }
        .left-title { font-size: 1.4rem; font-weight: 800; color: #fff; letter-spacing: -.03em; line-height: 1.2; margin-bottom: .4rem; }
        .left-title span { color: var(--accent); }
        .left-sub { font-size: 12.5px; color: rgba(148,163,184,.58); line-height: 1.65; }

        /* RIGHT */
        .panel-right { padding: 2.25rem 2rem; display: flex; flex-direction: column; justify-content: center; }
        .form-title { font-size: 1.15rem; font-weight: 800; color: var(--ink); letter-spacing: -.025em; margin-bottom: .2rem; }
        .form-sub { font-size: 12.5px; color: var(--ink-4); margin-bottom: 1.6rem; }

        /* ALERT */
        .alert-err { background: #FEF2F2; border: 1.5px solid #FECACA; border-radius: 12px; padding: .75rem 1rem; display: flex; align-items: center; gap: .55rem; margin-bottom: 1.1rem; font-size: 12.5px; font-weight: 600; color: #DC2626; }

        /* FIELDS */
        .field { margin-bottom: .9rem; }
        .field-lbl { display: block; font-size: 11px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: var(--ink-3); margin-bottom: .38rem; }
        .field-inp { width: 100%; background: var(--surface); border: 1.5px solid var(--border); border-radius: 11px; padding: .75rem .95rem; font-size: 13.5px; font-weight: 500; color: var(--ink); font-family: 'Plus Jakarta Sans',sans-serif; outline: none; transition: all .2s; }
        .field-inp:focus { border-color: var(--brand); background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .field-inp::placeholder { color: var(--ink-4); font-weight: 400; }

        .pw-wrap { position: relative; }
        .pw-wrap .field-inp { padding-right: 44px; }
        .pw-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 15px; color: var(--ink-4); padding: 0; line-height: 1; transition: color .2s; }
        .pw-btn:hover { color: var(--ink-3); }

        .remember { display: flex; align-items: center; gap: .45rem; margin: .85rem 0 1.25rem; }
        .remember input { width: 14px; height: 14px; accent-color: var(--brand); cursor: pointer; }
        .remember label { font-size: 12.5px; color: var(--ink-3); font-weight: 500; cursor: pointer; }

        .btn-login { width: 100%; background: linear-gradient(135deg,var(--brand),var(--brand-light)); color: #fff; border: none; border-radius: 12px; padding: .88rem; font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans',sans-serif; cursor: pointer; box-shadow: 0 6px 20px rgba(37,99,235,.32); transition: all .2s; display: flex; align-items: center; justify-content: center; gap: .45rem; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37,99,235,.48); }
        .btn-login:active { transform: scale(.98); }

        .secure-note { display: flex; align-items: center; justify-content: center; gap: .35rem; margin-top: .9rem; font-size: 11.5px; color: var(--ink-4); }

        /* COPYRIGHT */
        .copyright { font-size: 11.5px; color: rgba(255,255,255,.17); text-align: center; animation: fadeDown .5s .6s ease-out both; }

        /* ANIMATIONS */
        @keyframes riseUp { from{opacity:0;transform:translateY(22px) scale(.98)} to{opacity:1;transform:translateY(0) scale(1)} }
        @keyframes fadeDown { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pop { 0%{transform:scale(.5);opacity:0} 70%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }

        /* TABLET (≤ 680px) */
        @media (max-width: 680px) {
            .wrapper { max-width: 480px; }
            .card { grid-template-columns: 1fr; }
            .panel-left { flex-direction: row; align-items: center; gap: 1rem; padding: 1.5rem 1.5rem; }
            .left-icon { width: 50px; height: 50px; font-size: 1.4rem; border-radius: 14px; flex-shrink: 0; }
            .left-sub { display: none; }
            .left-title { font-size: 1.15rem; margin-bottom: 0; }
            .panel-right { padding: 1.75rem 1.5rem; }
        }

        /* MOBILE (≤ 440px) */
        @media (max-width: 440px) {
            body { padding: 1.25rem 1rem; align-items: flex-start; padding-top: 1.75rem; }
            .wrapper { gap: 1rem; }
            .card { border-radius: 20px; }
            .panel-left { padding: 1.25rem; }
            .left-icon { width: 44px; height: 44px; font-size: 1.25rem; }
            .left-title { font-size: 1.05rem; }
            .panel-right { padding: 1.35rem; }
            .form-sub { margin-bottom: 1.25rem; }
        }
    </style>
</head>
<body>

<div class="bg-grid"></div>
<div class="bg-orb1"></div>
<div class="bg-orb2"></div>

<div class="wrapper">

    <div class="brand">
        <div class="brand-mark">✈️</div>
        <span class="brand-name">Sanu Travel</span>
    </div>

    <div class="card">

        <!-- LEFT -->
        <div class="panel-left">
            <div class="p-glow1"></div>
            <div class="p-glow2"></div>
            <div class="p-dots"></div>

            <div class="left-icon-wrap">
                <div class="left-icon">🔐</div>
            </div>
            <div class="left-text">
                <h1 class="left-title">Selamat<br><span>Datang</span></h1>
                <p class="left-sub">Masuk ke panel Sanu Travel untuk mengelola perjalanan.</p>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="panel-right">
            <h2 class="form-title">Login ke Akun</h2>
            <p class="form-sub">Masukkan email dan password Anda</p>

            @if ($errors->any())
            <div class="alert-err">
                <span>⚠️</span>
                <span>Email atau password salah. Coba lagi.</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label class="field-lbl" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="field-inp" placeholder="email@contoh.com" required autocomplete="email">
                </div>

                <div class="field">
                    <label class="field-lbl" for="password">Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="password" class="field-inp" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="pw-btn" onclick="togglePw()">👁</button>
                    </div>
                </div>

                <div class="remember">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </button>

                <div class="secure-note">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Koneksi aman & terenkripsi
                </div>
            </form>
        </div>

    </div>

    <p class="copyright">© {{ date('Y') }} Sanu Travel · Semua Hak Dilindungi</p>
</div>

<script>
function togglePw() {
    const i = document.getElementById('password');
    i.type = i.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>