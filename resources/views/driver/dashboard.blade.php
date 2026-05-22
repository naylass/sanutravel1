<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Driver — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB;
            --brand-light: #3B82F6;
            --accent: #06B6D4;
            --green: #10B981;
            --ink: #0F172A;
            --ink-3: #64748B;
            --ink-4: #94A3B8;
            --border: #E2E8F0;
            --surface: #F1F5F9;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #060D1A;
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── FULL DARK BG ── */
        .page-bg {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background: linear-gradient(160deg, #060D1A 0%, #0A1830 55%, #060D1A 100%);
        }
        .page-bg-grid {
            position: fixed; inset: 0; z-index: 0; pointer-events: none; opacity: .025;
            background-image: linear-gradient(rgba(255,255,255,.6) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,.6) 1px, transparent 1px);
            background-size: 52px 52px;
        }
        .page-bg-glow1 {
            position: fixed; width: 700px; height: 700px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.12), transparent 65%);
            top: -300px; right: -150px; z-index: 0; pointer-events: none;
        }
        .page-bg-glow2 {
            position: fixed; width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.07), transparent 65%);
            bottom: -200px; left: -100px; z-index: 0; pointer-events: none;
        }

        /* ── EVERYTHING SCROLLS INSIDE ── */
        .page-scroll {
            position: relative; z-index: 10;
            min-height: 100vh;
            padding-bottom: 7rem;
        }

        /* ── TOP BAR ── */
        .topbar {
            max-width: 680px; margin: 0 auto;
            padding: 1.5rem 1.5rem 0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-logo {
            display: flex; align-items: center; gap: .55rem;
        }
        .topbar-logo-mark {
            width: 34px; height: 34px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 17px;
        }
        .topbar-logo-name { font-size: 15px; font-weight: 800; color: #fff; letter-spacing: -.02em; }
        .btn-logout {
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
            color: rgba(255,255,255,.55); font-size: 12.5px; font-weight: 600;
            padding: .5rem 1rem; border-radius: 10px; cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif; transition: all .2s;
            text-decoration: none; display: inline-flex; align-items: center; gap: .4rem;
        }
        .btn-logout:hover { background: rgba(255,255,255,.12); color: #fff; }

        /* ── PROFILE SECTION ── */
        .profile-section {
            max-width: 680px; margin: 1.75rem auto 0;
            padding: 0 1.5rem;
        }
        .profile-card {
            background: rgba(255,255,255,.055);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 24px; padding: 1.25rem 1.4rem;
            display: flex; align-items: center; gap: 1.1rem;
            backdrop-filter: blur(20px);
        }
        .profile-avatar {
            width: 58px; height: 58px; border-radius: 16px; object-fit: cover; flex-shrink: 0;
            border: 2px solid rgba(255,255,255,.12);
        }
        .profile-avatar-placeholder {
            width: 58px; height: 58px; border-radius: 16px; flex-shrink: 0;
            background: rgba(255,255,255,.08);
            display: flex; align-items: center; justify-content: center; font-size: 1.7rem;
        }
        .profile-info { flex: 1; min-width: 0; }
        .profile-greeting { font-size: 11px; font-weight: 600; color: rgba(148,163,184,.5); letter-spacing: .06em; text-transform: uppercase; margin-bottom: .25rem; }
        .profile-name { font-size: 1.1rem; font-weight: 800; color: #fff; letter-spacing: -.02em; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .profile-phone { font-size: 12.5px; color: rgba(148,163,184,.55); margin-top: .15rem; }
        .profile-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            background: rgba(16,185,129,.12); border: 1px solid rgba(16,185,129,.2);
            border-radius: 100px; padding: .28rem .75rem; flex-shrink: 0;
        }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #34D399; animation: pulse-g 2s ease-in-out infinite; }
        @keyframes pulse-g { 0%,100%{opacity:1} 50%{opacity:.35} }
        .badge-text { font-size: 11.5px; font-weight: 700; color: #6EE7B7; }

        /* ── STATS ROW ── */
        .stats-section {
            max-width: 680px; margin: 1rem auto 0;
            padding: 0 1.5rem;
            display: grid; grid-template-columns: 1fr 1fr; gap: .75rem;
        }
        .stat-card {
            background: rgba(255,255,255,.055);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px; padding: 1.1rem 1.2rem;
            backdrop-filter: blur(16px);
            position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
        }
        .stat-card:nth-child(1)::before { background: linear-gradient(90deg, var(--accent), var(--brand)); }
        .stat-card:nth-child(2)::before { background: linear-gradient(90deg, var(--green), #34D399); }

        .stat-icon-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: .75rem; }
        .stat-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(255,255,255,.08);
            display: flex; align-items: center; justify-content: center; font-size: 1rem;
        }
        .stat-trend {
            font-size: 11px; font-weight: 700;
            background: rgba(16,185,129,.12); color: #34D399;
            padding: .2rem .55rem; border-radius: 100px;
        }
        .stat-number {
            font-size: 2.1rem; font-weight: 800; line-height: 1;
            background: linear-gradient(135deg, #fff 30%, #67E8F9);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; letter-spacing: -.04em;
        }
        .stat-label { font-size: 11px; font-weight: 600; color: rgba(148,163,184,.5); margin-top: .35rem; text-transform: uppercase; letter-spacing: .07em; }

        /* ── SECTION TITLE ── */
        .section-title-row {
            max-width: 680px; margin: 1.75rem auto 0;
            padding: 0 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .section-title {
            font-size: 11.5px; font-weight: 800; letter-spacing: .12em;
            text-transform: uppercase; color: rgba(148,163,184,.45);
        }

        /* ── MENU CARDS ── */
        .menu-section {
            max-width: 680px; margin: .85rem auto 0;
            padding: 0 1.5rem;
            display: flex; flex-direction: column; gap: .75rem;
        }

        /* DELIVERY CARD — big hero card */
        .menu-delivery {
            background: linear-gradient(135deg, #0D1F3C 0%, #162A50 100%);
            border: 1px solid rgba(37,99,235,.18);
            border-radius: 24px; padding: 1.5rem;
            text-decoration: none; display: block;
            position: relative; overflow: hidden;
            box-shadow: 0 12px 40px rgba(0,0,0,.3);
            transition: transform .22s, box-shadow .22s;
        }
        .menu-delivery:hover { transform: translateY(-3px); box-shadow: 0 20px 52px rgba(0,0,0,.4); }
        .menu-delivery-glow {
            position: absolute; width: 220px; height: 220px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.22), transparent);
            top: -70px; right: -50px; pointer-events: none;
        }
        .menu-delivery-glow2 {
            position: absolute; width: 160px; height: 160px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.1), transparent);
            bottom: -50px; left: -20px; pointer-events: none;
        }
        .delivery-inner {
            position: relative; z-index: 1;
            display: flex; align-items: center; gap: 1rem;
        }
        .delivery-icon-wrap {
            width: 60px; height: 60px; border-radius: 18px; flex-shrink: 0;
            background: rgba(255,255,255,.08);
            display: flex; align-items: center; justify-content: center; font-size: 1.8rem;
        }
        .delivery-text { flex: 1; min-width: 0; }
        .delivery-label { font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(6,182,212,.7); margin-bottom: .3rem; }
        .delivery-title { font-size: 1.2rem; font-weight: 800; color: #fff; letter-spacing: -.025em; margin-bottom: .25rem; }
        .delivery-desc { font-size: 12.5px; color: rgba(148,163,184,.55); line-height: 1.5; }
        .delivery-arrow {
            width: 40px; height: 40px; border-radius: 13px; flex-shrink: 0;
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.4); font-size: 1.1rem;
            transition: background .2s, color .2s;
        }
        .menu-delivery:hover .delivery-arrow { background: rgba(37,99,235,.3); color: #fff; }

        /* PAYMENT CARD — accent lighter */
        .menu-payment {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 24px; padding: 1.5rem;
            text-decoration: none; display: block;
            position: relative; overflow: hidden;
            box-shadow: 0 4px 20px rgba(15,23,42,.07);
            transition: transform .22s, box-shadow .22s, border-color .2s;
        }
        .menu-payment:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(15,23,42,.12); border-color: rgba(16,185,129,.3); }
        .payment-inner {
            display: flex; align-items: center; gap: 1rem;
        }
        .payment-icon-wrap {
            width: 60px; height: 60px; border-radius: 18px; flex-shrink: 0;
            background: #F0FDF4;
            display: flex; align-items: center; justify-content: center; font-size: 1.8rem;
        }
        .payment-text { flex: 1; min-width: 0; }
        .payment-label { font-size: 10px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #16A34A; margin-bottom: .3rem; }
        .payment-title { font-size: 1.2rem; font-weight: 800; color: var(--ink); letter-spacing: -.025em; margin-bottom: .25rem; }
        .payment-desc { font-size: 12.5px; color: var(--ink-3); line-height: 1.5; }
        .payment-arrow {
            width: 40px; height: 40px; border-radius: 13px; flex-shrink: 0;
            background: #F1F5F9; border: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--ink-4); font-size: 1.1rem;
            transition: background .2s, color .2s, border-color .2s;
        }
        .menu-payment:hover .payment-arrow { background: #F0FDF4; border-color: #BBF7D0; color: #16A34A; }

        /* ── BOTTOM NAV ── */
        .bottom-nav {
            position: fixed; bottom: 1rem; left: 50%; transform: translateX(-50%);
            width: calc(100% - 2rem); max-width: 420px; z-index: 100;
        }
        .bottom-nav-inner {
            background: rgba(255,255,255,.92); backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.8);
            box-shadow: 0 8px 32px rgba(15,23,42,.14);
            border-radius: 24px; padding: .65rem .75rem;
            display: flex; align-items: center;
        }
        .nav-item {
            display: flex; flex-direction: column; align-items: center; gap: .2rem;
            padding: .55rem .75rem; border-radius: 16px;
            text-decoration: none; transition: background .2s; flex: 1;
        }
        .nav-item.active { background: linear-gradient(135deg, #0A1628, #1E293B); }
        .nav-item-icon { font-size: 1.1rem; }
        .nav-item-label { font-size: 11px; font-weight: 700; }
        .nav-item.active .nav-item-label { color: #fff; }
        .nav-item:not(.active) .nav-item-label { color: var(--ink-4); }
        .nav-item:not(.active):hover { background: var(--surface); }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .topbar, .profile-section, .stats-section,
            .section-title-row, .menu-section { padding-left: 1rem; padding-right: 1rem; }
            .delivery-title, .payment-title { font-size: 1.05rem; }
        }
    </style>
</head>
<body>

<div class="page-bg"></div>
<div class="page-bg-grid"></div>
<div class="page-bg-glow1"></div>
<div class="page-bg-glow2"></div>

<div class="page-scroll">

    <!-- TOP BAR -->
    <div class="topbar">
        <div class="topbar-logo">
            <div class="topbar-logo-mark">✈️</div>
            <span class="topbar-logo-name">Sanu Travel</span>
        </div>
        <form method="POST" action="/logout">
            @csrf
            <button class="btn-logout">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

    <!-- PROFILE -->
    <div class="profile-section">
        <div class="profile-card">
            @if($driver?->photo)
                <img src="{{ asset('storage/'.$driver->photo) }}" class="profile-avatar" alt="foto driver">
            @else
                <div class="profile-avatar-placeholder">👤</div>
            @endif
            <div class="profile-info">
                <div class="profile-greeting">Driver Panel</div>
                <div class="profile-name">{{ $driver->name ?? '-' }}</div>
                <div class="profile-phone">{{ $driver->phone ?? '-' }}</div>
            </div>
            <div class="profile-badge">
                <span class="badge-dot"></span>
                <span class="badge-text">Aktif</span>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-icon-row">
                <div class="stat-icon">👥</div>
                <span class="stat-trend">Hari ini</span>
            </div>
            <div class="stat-number">{{ $customerCount }}</div>
            <div class="stat-label">Total Penumpang</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-row">
                <div class="stat-icon">🚀</div>
                <span class="stat-trend" style="background:rgba(16,185,129,.12);color:#34D399;">Active</span>
            </div>
            <div class="stat-number">{{ $activeTrips }}</div>
            <div class="stat-label">Trip Aktif</div>
        </div>
    </div>

    <!-- SECTION TITLE -->
    <div class="section-title-row">
        <span class="section-title">Menu Utama</span>
        <span style="font-size:11px;color:rgba(148,163,184,.3);font-weight:600;">2 menu tersedia</span>
    </div>

    <!-- MENU -->
    <div class="menu-section">

        <!-- DELIVERY -->
        <a href="/driver/delivery" class="menu-delivery">
            <div class="menu-delivery-glow"></div>
            <div class="menu-delivery-glow2"></div>
            <div class="delivery-inner">
                <div class="delivery-icon-wrap">🚐</div>
                <div class="delivery-text">
                    <div class="delivery-label">Kelola Perjalanan</div>
                    <div class="delivery-title">Delivery Order</div>
                    <div class="delivery-desc">Lihat dan update status perjalanan customer Anda</div>
                </div>
                <div class="delivery-arrow">→</div>
            </div>
        </a>

        <!-- CASH PAYMENT -->
        <a href="/driver/payments" class="menu-payment">
            <div class="payment-inner">
                <div class="payment-icon-wrap">💰</div>
                <div class="payment-text">
                    <div class="payment-label">Konfirmasi Bayar</div>
                    <div class="payment-title">Cash Payment</div>
                    <div class="payment-desc">Upload bukti pembayaran cash dari customer</div>
                </div>
                <div class="payment-arrow">→</div>
            </div>
        </a>

    </div>

</div><!-- page-scroll -->

<!-- BOTTOM NAV -->
<div class="bottom-nav">
    <div class="bottom-nav-inner">
        <a href="/driver/dashboard" class="nav-item active">
            <span class="nav-item-icon">🏠</span>
            <span class="nav-item-label">Home</span>
        </a>
        <a href="/driver/delivery" class="nav-item">
            <span class="nav-item-icon">🚐</span>
            <span class="nav-item-label">Delivery</span>
        </a>
        <a href="/driver/payments" class="nav-item">
            <span class="nav-item-icon">💰</span>
            <span class="nav-item-label">Payment</span>
        </a>
    </div>
</div>

</body>
</html>