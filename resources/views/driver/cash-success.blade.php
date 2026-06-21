<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Berhasil — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB; --brand-light: #3B82F6;
            --accent: #06B6D4;
            --green: #10B981;
            --ink: #0F172A; --ink-3: #64748B; --ink-4: #94A3B8;
            --border: #E2E8F0; --surface: #F8FAFC;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(145deg, #060D1A 0%, #0C1D3A 50%, #091528 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem 1.5rem;
            position: relative; overflow: hidden;
        }

        .bg-grid { position: fixed; inset: 0; pointer-events: none; z-index: 0; opacity: .03; background-image: linear-gradient(var(--border) 1px,transparent 1px), linear-gradient(90deg,var(--border) 1px,transparent 1px); background-size: 52px 52px; }
        .bg-glow1 { position: fixed; width: 600px; height: 600px; border-radius: 50%; background: radial-gradient(circle,rgba(16,185,129,.12),transparent 65%); top: -250px; left: 30%; transform: translateX(-50%); pointer-events: none; z-index: 0; }
        .bg-glow2 { position: fixed; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle,rgba(37,99,235,.1),transparent 65%); bottom: -150px; right: 5%; pointer-events: none; z-index: 0; }

        /* WRAPPER */
        .page-wrapper { position: relative; z-index: 10; width: 100%; max-width: 780px; display: flex; flex-direction: column; align-items: center; gap: 1.4rem; }

        /* BRAND */
        .brand-bar { display: flex; align-items: center; gap: .6rem; animation: fadeDown .5s ease-out both; }
        .brand-logo { width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg,var(--accent),var(--brand)); display: flex; align-items: center; justify-content: center; font-size: 17px; box-shadow: 0 8px 24px rgba(37,99,235,.35); }
        .brand-name { font-size: 1rem; font-weight: 800; color: #fff; letter-spacing: -.02em; }

        /* CARD — desktop 2 kolom */
        .card {
            width: 100%; background: #fff;
            border-radius: 24px; overflow: hidden;
            box-shadow: 0 40px 80px rgba(0,0,0,.4), 0 0 0 1px rgba(255,255,255,.07);
            animation: riseUp .7s cubic-bezier(.16,1,.3,1) .1s both;
            display: grid;
            grid-template-columns: 280px 1fr;
        }

        /* LEFT — hero */
        .card-hero {
            background: linear-gradient(160deg,#0A1628,#152038);
            padding: 2rem 1.75rem;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; position: relative; overflow: hidden;
        }
        .hero-glow { position: absolute; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle,rgba(16,185,129,.18),transparent 65%); top: -100px; left: 50%; transform: translateX(-50%); pointer-events: none; }
        .hero-glow2 { position: absolute; width: 180px; height: 180px; border-radius: 50%; background: radial-gradient(circle,rgba(6,182,212,.1),transparent 65%); bottom: -60px; right: -30px; pointer-events: none; }

        /* SUCCESS ICON */
        .icon-wrap { position: relative; width: 80px; height: 80px; margin: 0 auto 1.25rem; animation: pop .7s cubic-bezier(.34,1.56,.64,1) .3s both; }
        .icon-ring { position: absolute; inset: 0; border-radius: 50%; background: rgba(16,185,129,.2); animation: pulse-ring 1.8s ease-out .9s infinite; }
        @keyframes pulse-ring { 0%{transform:scale(1);opacity:.5} 100%{transform:scale(1.8);opacity:0} }
        .icon-circle { position: relative; width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg,#10B981,#34D399); display: flex; align-items: center; justify-content: center; box-shadow: 0 12px 32px rgba(16,185,129,.45); }
        .icon-circle svg { width: 40px; height: 40px; color: #fff; }
        .check-path { stroke-dasharray: 100; stroke-dashoffset: 100; animation: draw .5s .9s ease-out forwards; }
        @keyframes draw { to{stroke-dashoffset:0} }

        .hero-title { position: relative; z-index: 1; font-size: 1.2rem; font-weight: 800; color: #fff; letter-spacing: -.025em; margin-bottom: .35rem; animation: fadeDown .5s .4s ease-out both; line-height: 1.2; }
        .hero-sub { position: relative; z-index: 1; font-size: 12px; color: rgba(148,163,184,.6); line-height: 1.55; animation: fadeDown .5s .5s ease-out both; }

        /* RIGHT — detail + actions */
        .card-right { padding: 1.75rem; display: flex; flex-direction: column; gap: 1rem; }

        /* DETAIL LIST */
        .detail-list { border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; animation: fadeUp .5s .7s ease-out both; }
        .detail-row { display: flex; justify-content: space-between; align-items: center; padding: .8rem 1rem; border-bottom: 1px solid var(--border); gap: 1rem; }
        .detail-row:last-child { border-bottom: none; }
        .detail-key { font-size: 11px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-4); flex-shrink: 0; }
        .detail-val { font-size: 13.5px; font-weight: 700; color: var(--ink); text-align: right; }
        .detail-row.total-row { background: linear-gradient(145deg,#0A1628,#152038); }
        .detail-row.total-row .detail-key { color: rgba(148,163,184,.45); }
        .detail-row.total-row .detail-val { font-size: 1.25rem; font-weight: 800; background: linear-gradient(135deg,#fff 30%,#6EE7B7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .status-badge { display: inline-flex; align-items: center; gap: .3rem; background: #F0FDF4; border: 1.5px solid #BBF7D0; border-radius: 100px; padding: .28rem .8rem; font-size: 11px; font-weight: 800; color: #16A34A; }

        /* ACTIONS */
        .actions { display: flex; flex-direction: column; gap: .6rem; animation: fadeUp .5s .85s ease-out both; }
        .btn-primary { display: flex; align-items: center; justify-content: center; gap: .45rem; width: 100%; background: linear-gradient(135deg,var(--brand),var(--brand-light)); color: #fff; border: none; border-radius: 13px; padding: .9rem; font-size: 13.5px; font-weight: 700; font-family: 'Plus Jakarta Sans',sans-serif; text-decoration: none; box-shadow: 0 6px 20px rgba(37,99,235,.3); transition: all .2s; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,.45); }
        .btn-secondary { display: flex; align-items: center; justify-content: center; gap: .45rem; width: 100%; background: #fff; border: 1.5px solid var(--border); color: var(--ink-3); padding: .9rem; border-radius: 13px; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: all .2s; font-family: 'Plus Jakarta Sans',sans-serif; }
        .btn-secondary:hover { border-color: var(--brand); color: var(--brand); background: #EFF6FF; }

        /* ANIMATIONS */
        @keyframes riseUp { from{opacity:0;transform:translateY(28px) scale(.98)} to{opacity:1;transform:translateY(0) scale(1)} }
        @keyframes fadeDown { from{opacity:0;transform:translateY(-10px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
        @keyframes pop { 0%{transform:scale(.4);opacity:0} 70%{transform:scale(1.08)} 100%{transform:scale(1);opacity:1} }

        /* ── MOBILE ── */
        @media (max-width: 600px) {
            body { padding: 1.25rem 1rem; align-items: flex-start; padding-top: 2rem; }
            /* collapse ke 1 kolom di mobile */
            .card { grid-template-columns: 1fr; }
            .card-hero { padding: 2rem 1.5rem 1.75rem; }
            .card-right { padding: 1.4rem; }
        }
    </style>
</head>
<body>

<div class="bg-grid"></div>
<div class="bg-glow1"></div>
<div class="bg-glow2"></div>

<div class="page-wrapper">

    <div class="brand-bar">
        <div class="brand-logo">✈️</div>
        <span class="brand-name">Sanu Travel</span>
    </div>

    <div class="card">

        <!-- LEFT: HERO -->
        <div class="card-hero">
            <div class="hero-glow"></div>
            <div class="hero-glow2"></div>
            <div class="icon-wrap">
                <div class="icon-ring"></div>
                <div class="icon-circle">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path class="check-path" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h1 class="hero-title">Cash Berhasil<br>Diterima!</h1>
            <p class="hero-sub">Pembayaran cash sudah berhasil dikirim ke admin</p>
        </div>

        <!-- RIGHT: DETAIL + ACTIONS -->
        <div class="card-right">
            <div class="detail-list">
                <div class="detail-row">
                    <span class="detail-key">Kode Booking</span>
                    <span class="detail-val">{{ $payment->booking->booking_code }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Customer</span>
                    <span class="detail-val">{{ $payment->booking->customer_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-key">Status</span>
                    <span class="detail-val">
                        <span class="status-badge">
                            <svg width="7" height="7" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                            Cash Received
                        </span>
                    </span>
                </div>
                <div class="detail-row total-row">
                    <span class="detail-key">Total</span>
                    <span class="detail-val">Rp {{ number_format($payment->amount,0,',','.') }}</span>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('driver.payment.page') }}" class="btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Halaman Payment
                </a>
                <a href="/driver/dashboard" class="btn-secondary">🏠 Dashboard</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>