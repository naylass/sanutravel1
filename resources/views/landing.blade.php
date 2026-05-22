<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanu Travel — Booking Mudah & Cepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB;
            --brand-light: #3B82F6;
            --brand-dark: #1D4ED8;
            --accent: #06B6D4;
            --surface: #F8FAFC;
            --ink: #0F172A;
            --ink-2: #334155;
            --ink-3: #64748B;
            --ink-4: #94A3B8;
            --border: #E2E8F0;
            --white: #FFFFFF;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            color: var(--ink);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ── NAV ── */
        .nav {
            position: fixed; top: 0; inset-x: 0; z-index: 100;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(226,232,240,0.8);
            transition: all .3s;
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 1.5rem; height: 64px;
            display: flex; align-items: center; justify-content: space-between; gap: 2rem;
        }
        .nav-logo {
            display: flex; align-items: center; gap: .6rem;
            text-decoration: none; flex-shrink: 0;
        }
        .nav-logo-mark {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--brand), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; box-shadow: 0 4px 12px rgba(37,99,235,.3);
        }
        .nav-logo-text {
            font-size: 17px; font-weight: 800; color: var(--ink);
            letter-spacing: -0.03em;
        }
        .nav-links {
            display: flex; align-items: center; gap: 1.75rem; flex: 1; justify-content: center;
        }
        .nav-links a {
            font-size: 14px; font-weight: 500; color: var(--ink-3);
            text-decoration: none; transition: color .2s;
        }
        .nav-links a:hover { color: var(--brand); }
        .nav-right { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
        .btn-ghost-sm {
            font-size: 13px; font-weight: 600; color: var(--ink-2);
            text-decoration: none; padding: .45rem 1rem;
            border-radius: 8px; transition: all .2s;
            border: 1px solid var(--border);
        }
        .btn-ghost-sm:hover { background: var(--surface); border-color: var(--brand); color: var(--brand); }
        .btn-primary-sm {
            font-size: 13px; font-weight: 700; color: #fff;
            text-decoration: none; padding: .5rem 1.2rem;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            border-radius: 8px; border: none; cursor: pointer;
            box-shadow: 0 2px 8px rgba(37,99,235,.35);
            transition: all .2s; display: inline-flex; align-items: center; gap: .35rem;
        }
        .btn-primary-sm:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(37,99,235,.45); }
        .hamburger {
            display: none; flex-direction: column; gap: 5px;
            background: none; border: none; cursor: pointer; padding: 6px;
        }
        .hamburger span {
            display: block; width: 22px; height: 2px;
            background: var(--ink); border-radius: 2px; transition: all .3s;
        }
        .mobile-menu {
            display: none; position: fixed; top: 64px; inset-x: 0; z-index: 99;
            background: rgba(255,255,255,0.98); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem 1.75rem;
        }
        .mobile-menu.open { display: block; }
        .mobile-menu a {
            display: block; font-size: 15px; font-weight: 500; color: var(--ink-2);
            text-decoration: none; padding: .75rem 0;
            border-bottom: 1px solid var(--border);
        }
        .mobile-menu a:last-child { border: none; }
        .mobile-cta {
            display: block; margin-top: 1rem;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; text-align: center; padding: .9rem;
            border-radius: 12px; font-size: 14px; font-weight: 700;
            text-decoration: none; box-shadow: 0 4px 16px rgba(37,99,235,.3);
        }

        /* ── HERO ── */
        .hero {
            position: relative; overflow: hidden;
            background: linear-gradient(160deg, #0A1628 0%, #0F2044 45%, #0A1628 100%);
            padding: 148px 1.5rem 100px;
        }
        .hero-grid {
            position: absolute; inset: 0; opacity: .04;
            background-image: linear-gradient(var(--border) 1px, transparent 1px),
                              linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 48px 48px;
        }
        .hero-glow-1 {
            position: absolute; width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.28) 0%, transparent 70%);
            top: -200px; left: 50%; transform: translateX(-50%);
            pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute; width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.18) 0%, transparent 70%);
            bottom: -100px; right: 10%; pointer-events: none;
        }
        .hero-inner {
            max-width: 780px; margin: 0 auto; text-align: center;
            position: relative; z-index: 2;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(37,99,235,.15); border: 1px solid rgba(37,99,235,.3);
            border-radius: 999px; padding: .4rem 1.1rem; margin-bottom: 2rem;
        }
        .hero-badge-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--accent); animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%,100% { opacity:1; transform:scale(1); }
            50% { opacity:.5; transform:scale(1.4); }
        }
        .hero-badge-text {
            font-size: 12px; font-weight: 600; color: rgba(6,182,212,.9); letter-spacing: .05em;
        }
        .hero-title {
            font-size: clamp(2.4rem, 6vw, 4.5rem); font-weight: 800;
            color: #fff; line-height: 1.1; letter-spacing: -.03em;
            margin-bottom: 1.25rem;
        }
        .hero-title .gradient-text {
            background: linear-gradient(135deg, #93C5FD 0%, #67E8F9 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-sub {
            font-size: 17px; color: rgba(255,255,255,.5); line-height: 1.75;
            font-weight: 400; max-width: 520px; margin: 0 auto 2.5rem;
        }
        .hero-actions {
            display: flex; flex-wrap: wrap; justify-content: center; gap: .75rem;
        }
        .btn-hero-primary {
            display: inline-flex; align-items: center; gap: .5rem;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; padding: .9rem 1.8rem;
            border-radius: 12px; font-size: 15px; font-weight: 700;
            text-decoration: none; box-shadow: 0 8px 28px rgba(37,99,235,.45);
            transition: all .25s;
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(37,99,235,.55); }
        .btn-hero-ghost {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15);
            color: rgba(255,255,255,.75); padding: .9rem 1.5rem;
            border-radius: 12px; font-size: 14px; font-weight: 500;
            text-decoration: none; transition: all .2s;
        }
        .btn-hero-ghost:hover { background: rgba(255,255,255,.13); color: #fff; border-color: rgba(255,255,255,.3); }

        /* ── STATS ── */
        .stats-strip { max-width: 1200px; margin: -36px auto 0; padding: 0 1.5rem; position: relative; z-index: 10; }
        .stats-card {
            background: #fff; border-radius: 20px;
            box-shadow: 0 8px 40px rgba(15,23,42,.1), 0 1px 0 rgba(255,255,255,.8) inset;
            border: 1px solid var(--border);
            display: grid; grid-template-columns: repeat(3,1fr); overflow: hidden;
        }
        .stat-item { padding: 1.5rem 1rem; text-align: center; }
        .stat-item + .stat-item { border-left: 1px solid var(--border); }
        .stat-emoji { font-size: 22px; margin-bottom: .5rem; }
        .stat-label { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: .25rem; }
        .stat-desc { font-size: 12px; color: var(--ink-4); }

        /* ── SECTION COMMON ── */
        .section { padding: 88px 1.5rem; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-eyebrow {
            display: inline-block; font-size: 11px; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase;
            color: var(--brand); margin-bottom: .6rem;
        }
        .section-title {
            font-size: clamp(1.75rem, 3.5vw, 2.75rem); font-weight: 800;
            color: var(--ink); letter-spacing: -.03em; line-height: 1.15;
        }
        .section-sub { font-size: 15px; color: var(--ink-3); margin-top: .6rem; line-height: 1.7; }

        /* ── SERVICES ── */
        .services-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(300px,1fr));
            gap: 1.25rem; margin-top: 3rem;
        }
        .svc-card {
            border-radius: 24px; padding: 2rem; position: relative; overflow: hidden;
            transition: transform .3s, box-shadow .3s;
        }
        .svc-card:hover { transform: translateY(-4px); }
        .svc-dark {
            background: linear-gradient(145deg, #0F172A, #1E2D4A);
            border: 1px solid rgba(37,99,235,.2);
            box-shadow: 0 8px 40px rgba(0,0,0,.25);
        }
        .svc-light {
            background: #fff; border: 1px solid #FDE68A;
            box-shadow: 0 8px 40px rgba(0,0,0,.07);
        }
        .svc-glow {
            position: absolute; width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.15), transparent);
            top: -50px; right: -50px; pointer-events: none;
        }
        .svc-badge {
            display: inline-block; font-size: 11px; font-weight: 700;
            padding: .3rem .9rem; border-radius: 999px; margin-bottom: 1.25rem;
        }
        .svc-icon { font-size: 2.2rem; margin-bottom: 1rem; }
        .svc-name { font-size: 1.6rem; font-weight: 800; margin-bottom: .5rem; letter-spacing: -.02em; }
        .svc-desc { font-size: 14px; line-height: 1.7; margin-bottom: 1.75rem; }
        .svc-footer { display: flex; align-items: flex-end; justify-content: space-between; }
        .svc-price-small { font-size: 11px; margin-bottom: .3rem; }
        .svc-price { font-size: 1.5rem; font-weight: 800; letter-spacing: -.02em; }
        .svc-price small { font-size: 12px; font-weight: 400; }
        .btn-svc {
            display: inline-flex; align-items: center; gap: .4rem;
            font-size: 13px; font-weight: 700;
            padding: .6rem 1.25rem; border-radius: 10px;
            text-decoration: none; transition: all .2s; cursor: pointer;
        }
        .btn-svc-white { background: #fff; color: var(--ink); }
        .btn-svc-white:hover { opacity: .9; }
        .btn-svc-primary { background: linear-gradient(135deg, var(--brand), var(--brand-light)); color: #fff; box-shadow: 0 4px 14px rgba(37,99,235,.3); }
        .btn-svc-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,99,235,.4); }

        /* ── STEPS ── */
        .steps-section { background: #fff; padding: 88px 1.5rem; }
        .steps-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
            gap: 1rem; margin-top: 3rem;
        }
        .step-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 20px; padding: 1.75rem 1.25rem; text-align: center;
            position: relative; transition: all .25s;
        }
        .step-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(15,23,42,.09); background: #fff; }
        .step-num {
            position: absolute; top: -12px; left: 1.25rem;
            width: 26px; height: 26px; border-radius: 999px;
            background: linear-gradient(135deg, var(--brand), var(--accent));
            color: #fff; font-size: 11px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(37,99,235,.35);
        }
        .step-emoji { font-size: 2rem; margin: .5rem 0 .75rem; }
        .step-title { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: .35rem; }
        .step-desc { font-size: 13px; color: var(--ink-4); line-height: 1.65; }

        /* ── FEATURES ── */
        .features-layout {
            display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
        }
        .feature-list { display: flex; flex-direction: column; gap: .75rem; margin-top: 2rem; }
        .feature-row {
            display: flex; align-items: flex-start; gap: 1rem;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 16px; padding: 1.1rem;
            transition: all .2s;
        }
        .feature-row:hover { border-color: rgba(37,99,235,.25); background: #fff; transform: translateX(4px); box-shadow: 0 4px 16px rgba(37,99,235,.07); }
        .feature-icon {
            width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
            background: linear-gradient(135deg, rgba(37,99,235,.1), rgba(6,182,212,.06));
            border: 1px solid rgba(37,99,235,.1);
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
        }
        .feature-title { font-size: 14px; font-weight: 700; color: var(--ink); margin-bottom: .2rem; }
        .feature-desc { font-size: 12.5px; color: var(--ink-4); line-height: 1.6; }

        /* ── TESTIMONIALS ── */
        .testi-section { background: linear-gradient(180deg, var(--surface), #EEF2FF); padding: 88px 1.5rem; }
        .testi-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr));
            gap: 1.25rem; margin-top: 3rem;
        }
        .testi-card {
            background: #fff; border: 1px solid var(--border); border-radius: 20px; padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(15,23,42,.05); transition: transform .25s;
        }
        .testi-card:hover { transform: translateY(-3px); }
        .testi-stars { font-size: 13px; margin-bottom: .75rem; letter-spacing: .05em; }
        .testi-text { font-size: 14px; color: var(--ink-3); line-height: 1.7; font-style: italic; margin-bottom: 1.25rem; }
        .testi-author { display: flex; align-items: center; gap: .75rem; }
        .testi-avatar {
            width: 38px; height: 38px; border-radius: 999px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; font-size: 13px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .testi-name { font-weight: 700; color: var(--ink); font-size: 13px; }
        .testi-city { font-size: 11.5px; color: var(--ink-4); }

        /* ── CTA SECTION ── */
        .cta-section { padding: 88px 1.5rem; }
        .cta-block {
            max-width: 1200px; margin: 0 auto;
            background: linear-gradient(145deg, #0F1B35, #0A1228);
            border: 1px solid rgba(37,99,235,.2); border-radius: 28px; padding: 5rem 2.5rem;
            text-align: center; position: relative; overflow: hidden;
        }
        .cta-glow {
            position: absolute; width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.2), transparent);
            top: 50%; left: 50%; transform: translate(-50%,-50%);
            pointer-events: none;
        }
        .cta-eyebrow {
            font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
            color: var(--accent); display: block; margin-bottom: .75rem;
        }
        .cta-title {
            font-size: clamp(1.8rem, 3.5vw, 3rem); font-weight: 800;
            color: #fff; letter-spacing: -.03em; margin-bottom: .75rem;
        }
        .cta-sub {
            font-size: 15px; color: rgba(255,255,255,.45); line-height: 1.7;
            max-width: 440px; margin: 0 auto 2rem;
        }
        .btn-cta {
            display: inline-flex; align-items: center; gap: .5rem;
            background: #fff; color: var(--ink); padding: .9rem 2rem;
            border-radius: 12px; font-size: 14px; font-weight: 800;
            text-decoration: none; box-shadow: 0 8px 28px rgba(0,0,0,.2);
            transition: transform .2s;
        }
        .btn-cta:hover { transform: translateY(-2px); }

        /* ── FOOTER ── */
        .footer {
            background: #07111F; border-top: 1px solid rgba(255,255,255,.06);
            padding: 2.5rem 1.5rem;
        }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1.25rem;
        }
        .footer-logo { display: flex; align-items: center; gap: .6rem; text-decoration: none; }
        .footer-logo-mark {
            width: 34px; height: 34px; border-radius: 9px;
            background: linear-gradient(135deg, var(--brand), var(--accent));
            display: flex; align-items: center; justify-content: center; font-size: 16px;
        }
        .footer-logo-text { font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -.02em; }
        .footer-links { display: flex; gap: 1.5rem; flex-wrap: wrap; }
        .footer-links a { font-size: 13px; color: rgba(255,255,255,.3); text-decoration: none; transition: color .2s; }
        .footer-links a:hover { color: rgba(255,255,255,.65); }
        .footer-copy { font-size: 12px; color: rgba(255,255,255,.2); }

        /* ── MOBILE STICKY ── */
        .mobile-sticky {
            display: none; position: fixed; bottom: 0; inset-x: 0; z-index: 90;
            background: rgba(255,255,255,.97); backdrop-filter: blur(12px);
            border-top: 1px solid var(--border); padding: .85rem 1rem;
        }
        .mobile-sticky a {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; padding: .95rem; border-radius: 12px;
            font-size: 14px; font-weight: 700; text-decoration: none;
            box-shadow: 0 4px 16px rgba(37,99,235,.35);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fu  { animation: fadeUp .7s cubic-bezier(.16,1,.3,1) both; }
        .fu2 { animation: fadeUp .7s .12s cubic-bezier(.16,1,.3,1) both; }
        .fu3 { animation: fadeUp .7s .22s cubic-bezier(.16,1,.3,1) both; }
        .fu4 { animation: fadeUp .7s .32s cubic-bezier(.16,1,.3,1) both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) { .features-layout { grid-template-columns: 1fr; gap: 2.5rem; } }
        @media (max-width: 768px) {
            .nav-links, .nav-right { display: none; }
            .hamburger { display: flex; }
            .hero { padding: 120px 1.25rem 72px; }
            .btn-hero-primary, .btn-hero-ghost { width: 100%; justify-content: center; }
            .hero-actions { flex-direction: column; align-items: stretch; }
            .stats-card { grid-template-columns: 1fr; }
            .stat-item + .stat-item { border-left: none; border-top: 1px solid var(--border); }
            .section { padding: 60px 1.25rem; }
            .steps-section, .cta-section, .testi-section { padding: 60px 1.25rem; }
            .steps-grid { grid-template-columns: 1fr 1fr; }
            .services-grid { grid-template-columns: 1fr; }
            .cta-block { padding: 3rem 1.5rem; }
            .mobile-sticky { display: block; }
            body { padding-bottom: 72px; }
        }
        @media (max-width: 480px) {
            .steps-grid { grid-template-columns: 1fr; }
            .testi-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="nav">
    <div class="nav-inner">
        <a href="/" class="nav-logo">
            <div class="nav-logo-mark">🚐</div>
            <span class="nav-logo-text">SanuTravel</span>
        </a>
        <div class="nav-links">
            <a href="#layanan">Layanan</a>
            <a href="#cara-pesan">Cara Pesan</a>
            <a href="/tracking">Cek Status</a>
            <a href="/payment/check">Pembayaran</a>
        </div>
        <div class="nav-right">
            <a href="/tracking" class="btn-ghost-sm">Cek Status</a>
            <a href="/booking/create" class="btn-primary-sm">🚐 Pesan Sekarang</a>
        </div>
        <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
    <a href="#layanan" onclick="toggleMenu()">Layanan</a>
    <a href="#cara-pesan" onclick="toggleMenu()">Cara Pesan</a>
    <a href="/tracking" onclick="toggleMenu()">Cek Status</a>
    <a href="/payment/check" onclick="toggleMenu()">Pembayaran</a>
    <a href="/booking/create" class="mobile-cta">🚐 Pesan Sekarang</a>
</div>

<!-- HERO -->
<section class="hero">
    <div class="hero-grid"></div>
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>
    <div class="hero-inner">
        <div class="hero-badge fu">
            <div class="hero-badge-dot"></div>
            <span class="hero-badge-text">✈️ Travel Premium Terpercaya</span>
        </div>
        <h1 class="hero-title fu2">
            Perjalanan <span class="gradient-text">Aman</span><br>& Nyaman Bersama Kami
        </h1>
        <p class="hero-sub fu3">
            Booking travel tanpa ribet. Tanpa login. Tanpa registrasi.<br>
            Cukup isi form dan langsung berangkat.
        </p>
        <div class="hero-actions fu4">
            <a href="/booking/create" class="btn-hero-primary">🚐 Pesan Sekarang</a>
            <a href="/tracking" class="btn-hero-ghost">📋 Cek Status</a>
            <a href="/payment/check" class="btn-hero-ghost">💳 Pembayaran</a>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-strip">
    <div class="stats-card">
        <div class="stat-item">
            <div class="stat-emoji">🚀</div>
            <div class="stat-label">Konfirmasi Cepat</div>
            <div class="stat-desc">Dikonfirmasi dalam menit</div>
        </div>
        <div class="stat-item">
            <div class="stat-emoji">🛡️</div>
            <div class="stat-label">Aman & Terpercaya</div>
            <div class="stat-desc">Driver terverifikasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-emoji">💳</div>
            <div class="stat-label">Bayar Fleksibel</div>
            <div class="stat-desc">QRIS, Transfer, Cash</div>
        </div>
    </div>
</div>

<!-- LAYANAN -->
<section id="layanan" class="section" style="padding-top:80px">
    <div class="section-inner">
        <div style="text-align:center;margin-bottom:3rem">
            <span class="section-eyebrow">Pilihan Layanan</span>
            <h2 class="section-title">Layanan Kami</h2>
            <p class="section-sub">Pilih layanan yang sesuai kebutuhan perjalanan Anda</p>
        </div>
        <div class="services-grid">
            <div class="svc-card svc-dark">
                <div class="svc-glow"></div>
                <div style="position:relative;z-index:1">
                    <span class="svc-badge" style="background:rgba(6,182,212,.12);border:1px solid rgba(6,182,212,.25);color:rgba(6,182,212,.9)">Paling Populer</span>
                    <div class="svc-icon">🚐</div>
                    <div class="svc-name" style="color:#fff">Reguler</div>
                    <div class="svc-desc" style="color:rgba(255,255,255,.5)">Cocok untuk perjalanan hemat dan sharing penumpang. Nyaman dan terjangkau untuk semua.</div>
                    <div class="svc-footer">
                        <div>
                            <div class="svc-price-small" style="color:rgba(255,255,255,.4)">Mulai dari</div>
                            <div class="svc-price" style="color:#fff">Rp 300.000 <small style="color:rgba(255,255,255,.4)">/orang</small></div>
                        </div>
                        <a href="/booking/create" class="btn-svc btn-svc-white">Pesan →</a>
                    </div>
                </div>
            </div>
            <div class="svc-card svc-light">
                <div style="position:absolute;top:0;right:0;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(245,158,11,.08),transparent);transform:translate(30%,-30%)"></div>
                <div style="position:relative;z-index:1">
                    <span class="svc-badge" style="background:#FEF3C7;border:1px solid #FDE68A;color:#B45309">Premium</span>
                    <div class="svc-icon">✨</div>
                    <div class="svc-name" style="color:var(--ink)">Eksklusif</div>
                    <div class="svc-desc" style="color:var(--ink-3)">Private travel, bebas pilih jam sendiri, lebih privat, nyaman, dan personal.</div>
                    <div class="svc-footer">
                        <div>
                            <div class="svc-price-small" style="color:var(--ink-4)">Harga flat</div>
                            <div class="svc-price" style="color:var(--ink)">Rp 600.000 <small style="color:var(--ink-4)">/trip</small></div>
                        </div>
                        <a href="/booking/create" class="btn-svc btn-svc-primary">Pesan →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CARA PESAN -->
<section id="cara-pesan" class="steps-section">
    <div class="section-inner">
        <div style="text-align:center;margin-bottom:3rem">
            <span class="section-eyebrow">Mudah & Cepat</span>
            <h2 class="section-title">Cara Pemesanan</h2>
        </div>
        <div class="steps-grid">
            @foreach([
                ['📝','Isi Form','Masukkan data perjalanan Anda dengan lengkap'],
                ['🎫','Dapat Kode','Kode booking dikirim otomatis setelah submit'],
                ['💳','Pembayaran','Bayar via QRIS, transfer bank, atau cash'],
                ['🚐','Berangkat','Tinggal tunggu driver di lokasi penjemputan']
            ] as $i => $step)
            <div class="step-card">
                <div class="step-num">{{ $i+1 }}</div>
                <div class="step-emoji">{{ $step[0] }}</div>
                <div class="step-title">{{ $step[1] }}</div>
                <div class="step-desc">{{ $step[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FITUR -->
<section class="section" style="background:#fff">
    <div class="section-inner">
        <div class="features-layout">
            <div>
                <span class="section-eyebrow">Keunggulan</span>
                <h2 class="section-title">Mengapa Sanu Travel?</h2>
                <p class="section-sub">Kami hadir dengan layanan terbaik agar setiap perjalanan Anda terasa aman, nyaman, dan terpercaya.</p>
                <a href="/booking/create" class="btn-svc btn-svc-primary" style="margin-top:2rem;display:inline-flex">Mulai Booking →</a>
            </div>
            <div class="feature-list">
                @foreach([
                    ['🛡️','Terpercaya & Aman','Driver berpengalaman dan terverifikasi dengan rekam jejak terbaik'],
                    ['📍','Door-to-Door','Dijemput langsung dari rumah hingga tiba di tujuan'],
                    ['💳','Pembayaran Fleksibel','Bayar via QRIS, transfer bank, atau cash langsung ke driver'],
                    ['📲','Booking Mudah','Pesan kapan saja, tanpa akun, konfirmasi cepat dari admin']
                ] as $feat)
                <div class="feature-row">
                    <div class="feature-icon">{{ $feat[0] }}</div>
                    <div>
                        <div class="feature-title">{{ $feat[1] }}</div>
                        <div class="feature-desc">{{ $feat[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIAL -->
<section class="testi-section">
    <div class="section-inner">
        <div style="text-align:center;margin-bottom:3rem">
            <span class="section-eyebrow">Testimoni</span>
            <h2 class="section-title">Kata Pelanggan Kami</h2>
        </div>
        <div class="testi-grid">
            @foreach([
                ['⭐⭐⭐⭐⭐','Pelayanannya luar biasa! Driver tepat waktu dan ramah. Sangat direkomendasikan!','Rina S.','Jakarta'],
                ['⭐⭐⭐⭐⭐','Booking-nya gampang banget, nggak perlu login segala. Harganya juga terjangkau.','Budi K.','Serang'],
                ['⭐⭐⭐⭐⭐','Sudah 3x pakai Sanu Travel, selalu puas! Mobilnya bersih dan nyaman.','Dewi M.','Cilegon']
            ] as $t)
            <div class="testi-card">
                <div class="testi-stars">{{ $t[0] }}</div>
                <p class="testi-text">"{{ $t[1] }}"</p>
                <div class="testi-author">
                    <div class="testi-avatar">{{ substr($t[2],0,1) }}</div>
                    <div>
                        <div class="testi-name">{{ $t[2] }}</div>
                        <div class="testi-city">{{ $t[3] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-block">
        <div class="cta-glow"></div>
        <div style="position:relative;z-index:2">
            <span class="cta-eyebrow">Mulai Sekarang</span>
            <h2 class="cta-title">Mulai Booking Sekarang</h2>
            <p class="cta-sub">Tidak perlu akun. Langsung isi data perjalanan Anda dan berangkat!</p>
            <a href="/booking/create" class="btn-cta">🚐 Pesan Sekarang</a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-inner">
        <a href="/" class="footer-logo">
            <div class="footer-logo-mark">🚐</div>
            <span class="footer-logo-text">SanuTravel</span>
        </a>
        <p class="footer-copy">© {{ date('Y') }} Sanu Travel. Semua Hak Dilindungi.</p>
        <div class="footer-links">
            <a href="#layanan">Layanan</a>
            <a href="/tracking">Cek Status</a>
            <a href="/payment/check">Pembayaran</a>
        </div>
    </div>
</footer>

<!-- MOBILE STICKY -->
<div class="mobile-sticky">
    <a href="/booking/create">🚐 Pesan Sekarang</a>
</div>

<script>
function toggleMenu(){
    document.getElementById('mobileMenu').classList.toggle('open');
}
</script>
</body>
</html>