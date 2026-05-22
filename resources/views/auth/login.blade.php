<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB;
            --brand-light: #3B82F6;
            --accent: #06B6D4;
            --ink: #0F172A;
            --ink-2: #1E293B;
            --ink-3: #64748B;
            --ink-4: #94A3B8;
            --border: #E2E8F0;
            --surface: #F8FAFC;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(145deg, #060D1A 0%, #0C1D3A 50%, #091528 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* BACKGROUNDS */
        .bg-grid {
            position: fixed; inset: 0; pointer-events: none; z-index: 0; opacity: .035;
            background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 56px 56px;
        }
        .bg-glow-1 {
            position: fixed; width: 650px; height: 650px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.2), transparent 65%);
            top: -250px; left: 20%; transform: translateX(-50%);
            pointer-events: none; z-index: 0;
        }
        .bg-glow-2 {
            position: fixed; width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.12), transparent 65%);
            bottom: -150px; right: 5%;
            pointer-events: none; z-index: 0;
        }
        .bg-glow-3 {
            position: fixed; width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.08), transparent 65%);
            bottom: 10%; left: 5%;
            pointer-events: none; z-index: 0;
        }

        /* WRAPPER */
        .page-wrapper {
            position: relative; z-index: 10;
            width: 100%; max-width: 460px;
            display: flex; flex-direction: column; align-items: center; gap: 1.5rem;
        }

        /* BRAND */
        .brand-bar {
            display: flex; align-items: center; gap: .65rem;
            animation: fadeDown .5s ease-out both;
        }
        .brand-logo {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 20px;
            box-shadow: 0 8px 24px rgba(37,99,235,.35);
        }
        .brand-name {
            font-size: 1.15rem; font-weight: 800; color: #fff; letter-spacing: -.02em;
        }

        /* CARD */
        .login-card {
            width: 100%;
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,.45), 0 0 0 1px rgba(255,255,255,.07);
            animation: riseUp .7s cubic-bezier(.16,1,.3,1) .1s both;
        }

        /* CARD HERO */
        .card-hero {
            background: linear-gradient(145deg, #0A1628, #162040);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative; overflow: hidden;
        }
        .card-hero-glow {
            position: absolute; width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.2), transparent 65%);
            top: -120px; left: 50%; transform: translateX(-50%);
            pointer-events: none;
        }
        .card-hero-glow-2 {
            position: absolute; width: 180px; height: 180px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.12), transparent 65%);
            bottom: -60px; right: -30px; pointer-events: none;
        }
        .hero-icon {
            position: relative; z-index: 1;
            width: 72px; height: 72px; border-radius: 22px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; margin: 0 auto 1.25rem;
            box-shadow: 0 12px 32px rgba(37,99,235,.45);
            animation: pop .6s cubic-bezier(.34,1.56,.64,1) .3s both;
        }
        @keyframes pop {
            0% { transform: scale(.5); opacity: 0; }
            70% { transform: scale(1.08); }
            100% { transform: scale(1); opacity: 1; }
        }
        .hero-title {
            position: relative; z-index: 1;
            font-size: 1.6rem; font-weight: 800; color: #fff;
            letter-spacing: -.03em; margin-bottom: .35rem;
            animation: fadeDown .5s .4s ease-out both;
        }
        .hero-sub {
            position: relative; z-index: 1;
            font-size: 13px; color: rgba(148,163,184,.65);
            animation: fadeDown .5s .5s ease-out both;
        }

        /* CARD BODY */
        .card-body { padding: 2rem; }

        /* ERROR */
        .alert-error {
            background: #FEF2F2; border: 1.5px solid #FECACA;
            border-radius: 14px; padding: .85rem 1rem;
            display: flex; align-items: center; gap: .65rem;
            margin-bottom: 1.25rem;
            animation: fadeDown .4s ease-out both;
        }
        .alert-error-text { font-size: 13px; font-weight: 600; color: #DC2626; }

        /* FORM */
        .form-group { margin-bottom: 1.1rem; }
        .field-label {
            display: block; font-size: 12px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--ink-3); margin-bottom: .45rem;
        }
        .field-input {
            width: 100%; background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 13px; padding: .8rem 1rem;
            font-size: 14px; font-weight: 500; color: var(--ink);
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none; transition: all .2s;
        }
        .field-input:focus {
            border-color: var(--brand); background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }
        .field-input::placeholder { color: var(--ink-4); font-weight: 400; }

        /* PASSWORD WRAP */
        .pw-wrap { position: relative; }
        .pw-wrap .field-input { padding-right: 48px; }
        .pw-toggle {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            font-size: 16px; color: var(--ink-4); padding: 0; line-height: 1;
            transition: color .2s;
        }
        .pw-toggle:hover { color: var(--ink-3); }

        /* REMEMBER */
        .remember-row {
            display: flex; align-items: center; gap: .5rem;
            margin-bottom: 1.4rem;
        }
        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--brand); cursor: pointer; flex-shrink: 0;
        }
        .remember-row label {
            font-size: 13px; color: var(--ink-3); font-weight: 500; cursor: pointer;
        }

        /* SUBMIT BTN */
        .btn-primary {
            width: 100%; background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; border: none; border-radius: 13px; padding: .95rem;
            font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; box-shadow: 0 6px 20px rgba(37,99,235,.35);
            transition: all .2s; letter-spacing: .02em;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37,99,235,.5); }
        .btn-primary:active { transform: scale(.98); }

        /* FOOTER */
        .card-footer {
            padding: 0 2rem 1.5rem; text-align: center;
            border-top: 1px solid var(--border); padding-top: 1.25rem;
        }
        .footer-text { font-size: 12px; color: var(--ink-4); }

        /* COPYRIGHT */
        .copyright {
            font-size: 12px; color: rgba(255,255,255,.2);
            text-align: center;
            animation: fadeDown .5s .6s ease-out both;
        }

        /* ANIMATIONS */
        @keyframes riseUp {
            from { opacity: 0; transform: translateY(28px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* MOBILE */
        @media (max-width: 480px) {
            body { padding: 1.25rem 1rem; align-items: flex-start; padding-top: 2.5rem; }
            .card-hero { padding: 2rem 1.5rem 1.75rem; }
            .card-body { padding: 1.5rem; }
            .card-footer { padding: 0 1.5rem 1.5rem; padding-top: 1rem; }
        }
    </style>
</head>
<body>

<div class="bg-grid"></div>
<div class="bg-glow-1"></div>
<div class="bg-glow-2"></div>
<div class="bg-glow-3"></div>

<div class="page-wrapper">

    <!-- BRAND -->
    <div class="brand-bar">
        <div class="brand-logo">✈️</div>
        <span class="brand-name">Sanu Travel</span>
    </div>

    <!-- CARD -->
    <div class="login-card">

        <!-- HERO -->
        <div class="card-hero">
            <div class="card-hero-glow"></div>
            <div class="card-hero-glow-2"></div>
            <div class="hero-icon">🔐</div>
            <h1 class="hero-title">Selamat Datang</h1>
            <p class="hero-sub">Masuk ke panel Sanu Travel</p>
        </div>

        <!-- BODY -->
        <div class="card-body">

            @if ($errors->any())
            <div class="alert-error">
                <span style="font-size:1rem;flex-shrink:0;">⚠️</span>
                <p class="alert-error-text">Email atau password salah. Coba lagi.</p>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="field-label" for="email">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           class="field-input"
                           placeholder="email@contoh.com"
                           required autocomplete="email">
                </div>

                <div class="form-group">
                    <label class="field-label" for="password">Password</label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="password"
                               class="field-input"
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        <button type="button" class="pw-toggle" onclick="togglePassword()" aria-label="Toggle password">
                            👁
                        </button>
                    </div>
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-primary">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Masuk
                </button>

            </form>
        </div>

        <!-- FOOTER -->
        <div class="card-footer">
            <p class="footer-text">Panel khusus untuk tim Sanu Travel</p>
        </div>

    </div>

    <!-- COPYRIGHT -->
    <p class="copyright">© {{ date('Y') }} Sanu Travel · Semua Hak Dilindungi</p>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
</body>
</html>