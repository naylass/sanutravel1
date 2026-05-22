<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB;
            --brand-light: #3B82F6;
            --accent: #06B6D4;
            --accent-warm: #F59E0B;
            --ink: #0F172A;
            --ink-2: #1E293B;
            --ink-3: #64748B;
            --ink-4: #94A3B8;
            --border: #E2E8F0;
            --surface: #F8FAFC;
            --white: #ffffff;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(145deg, #060D1A 0%, #0C1D3A 40%, #091528 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* BACKGROUND EFFECTS */
        .bg-noise {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.4;
        }
        .bg-grid {
            position: fixed; inset: 0; pointer-events: none; z-index: 0; opacity: .035;
            background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 56px 56px;
        }
        .bg-glow-1 {
            position: fixed; width: 700px; height: 700px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.18), transparent 68%);
            top: -250px; left: 30%; transform: translateX(-50%); pointer-events: none; z-index: 0;
        }
        .bg-glow-2 {
            position: fixed; width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.12), transparent 68%);
            bottom: -150px; right: 5%; pointer-events: none; z-index: 0;
        }
        .bg-glow-3 {
            position: fixed; width: 350px; height: 350px; border-radius: 50%;
            background: radial-gradient(circle, rgba(245,158,11,.07), transparent 68%);
            top: 40%; left: 5%; pointer-events: none; z-index: 0;
        }

        /* ── MAIN WRAPPER ── */
        .page-wrapper {
            position: relative; z-index: 10;
            width: 100%;
            max-width: 860px;
            margin: 0 auto;
        }

        /* ── TOP BRAND BAR ── */
        .brand-bar {
            display: flex; align-items: center; justify-content: center; gap: .6rem;
            margin-bottom: 2rem;
            animation: fadeDown .5s ease-out both;
        }
        .brand-logo {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.1rem; font-weight: 700;
            color: rgba(255,255,255,.75); letter-spacing: .02em;
        }

        /* ── CARD ── */
        .card {
            background: var(--white);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 48px 96px rgba(0,0,0,.45), 0 0 0 1px rgba(255,255,255,.06);
            animation: riseUp .7s cubic-bezier(.16,1,.3,1) .1s both;
        }

        @keyframes riseUp {
            from { opacity: 0; transform: translateY(32px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── HERO ── */
        .card-hero {
            background: linear-gradient(145deg, #0A1628, #162040);
            padding: 3rem 2rem 2.5rem;
            position: relative; overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
        }
        .hero-glow {
            position: absolute; width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.2), transparent 65%);
            top: -180px; left: -60px; pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute; width: 250px; height: 250px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.15), transparent 65%);
            bottom: -80px; right: -40px; pointer-events: none;
        }

        .hero-left { position: relative; z-index: 2; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(6,182,212,.15); border: 1px solid rgba(6,182,212,.3);
            border-radius: 100px; padding: .3rem .75rem;
            font-size: 11.5px; font-weight: 600; color: var(--accent);
            letter-spacing: .05em; text-transform: uppercase;
            margin-bottom: 1rem;
            animation: fadeDown .5s .4s ease-out both;
        }
        .hero-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            font-weight: 800; color: #fff;
            letter-spacing: -.03em; line-height: 1.15;
            margin-bottom: .6rem;
            animation: fadeDown .5s .5s ease-out both;
        }
        .hero-title span { color: var(--accent); }
        .hero-sub {
            font-size: 14px; color: rgba(148,163,184,.75);
            line-height: 1.6; max-width: 300px;
            animation: fadeDown .5s .6s ease-out both;
        }

        .hero-right {
            position: relative; z-index: 2;
            display: flex; flex-direction: column; align-items: flex-end; gap: 1rem;
        }

        /* SUCCESS ICON */
        .icon-wrap {
            width: 92px; height: 92px; position: relative;
            animation: pop .7s cubic-bezier(.34,1.56,.64,1) .3s both;
        }
        @keyframes pop {
            0% { transform: scale(.4); opacity: 0; }
            70% { transform: scale(1.08); }
            100% { transform: scale(1); opacity: 1; }
        }
        .icon-ring {
            position: absolute; inset: 0; border-radius: 50%;
            background: rgba(6,182,212,.2);
            animation: pulse-ring 1.8s ease-out .9s infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: .5; }
            100% { transform: scale(1.8); opacity: 0; }
        }
        .icon-circle {
            position: relative; width: 92px; height: 92px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 16px 40px rgba(37,99,235,.5);
        }
        .icon-circle svg { width: 46px; height: 46px; color: #fff; }
        .check-path {
            stroke-dasharray: 100; stroke-dashoffset: 100;
            animation: draw .5s .9s ease-out forwards;
        }
        @keyframes draw { to { stroke-dashoffset: 0; } }

        /* STEP TRACKER */
        .step-tracker {
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px; padding: .9rem 1.1rem;
            min-width: 180px;
            animation: fadeDown .5s .7s ease-out both;
        }
        .step-title { font-size: 10px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: rgba(148,163,184,.6); margin-bottom: .65rem; }
        .step-item {
            display: flex; align-items: center; gap: .55rem;
            padding: .28rem 0;
        }
        .step-dot {
            width: 22px; height: 22px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700;
        }
        .step-dot.done {
            background: linear-gradient(135deg, var(--accent), var(--brand));
            color: #fff;
        }
        .step-dot.active {
            background: rgba(245,158,11,.2); border: 1.5px solid var(--accent-warm);
            color: var(--accent-warm);
        }
        .step-dot.pending {
            background: rgba(255,255,255,.06); border: 1.5px solid rgba(255,255,255,.1);
            color: rgba(148,163,184,.4);
        }
        .step-label { font-size: 12px; font-weight: 500; }
        .step-label.done { color: rgba(255,255,255,.85); }
        .step-label.active { color: var(--accent-warm); }
        .step-label.pending { color: rgba(148,163,184,.4); }

        /* ── BODY SECTION ── */
        .card-body {
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        /* BOOKING CODE */
        .code-card {
            background: linear-gradient(145deg, #0A1628, #152038);
            border: 1px solid rgba(6,182,212,.2);
            border-radius: 18px; padding: 1.75rem 1.5rem; text-align: center;
            position: relative; overflow: hidden;
            animation: fadeUp .5s .8s ease-out both;
            box-shadow: 0 8px 32px rgba(0,0,0,.2), inset 0 1px 0 rgba(255,255,255,.05);
        }
        .code-card::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse at 50% -20%, rgba(6,182,212,.15), transparent 65%);
            pointer-events: none;
        }
        .code-label {
            font-size: 10px; font-weight: 700; letter-spacing: .18em;
            text-transform: uppercase; color: rgba(148,163,184,.5); margin-bottom: .85rem;
            position: relative; z-index: 1;
        }
        .code-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2rem; font-weight: 800;
            letter-spacing: .2em; line-height: 1;
            position: relative; z-index: 1;
            background: linear-gradient(135deg, #ffffff 30%, #67E8F9);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .code-divider {
            width: 36px; height: 2px; margin: .8rem auto;
            background: linear-gradient(90deg, var(--accent), var(--brand));
            border-radius: 2px; position: relative; z-index: 1;
        }
        .code-hint { font-size: 11.5px; color: rgba(148,163,184,.5); line-height: 1.6; position: relative; z-index: 1; }

        /* DETAIL ROWS */
        .detail-card {
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 18px; overflow: hidden;
            animation: fadeUp .5s .9s ease-out both;
        }
        .detail-header {
            padding: .85rem 1.25rem;
            background: #fff; border-bottom: 1.5px solid var(--border);
            font-size: 10px; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: var(--ink-4);
        }
        .detail-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: .75rem 1.25rem; border-bottom: 1px solid var(--border);
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-key { font-size: 13px; color: var(--ink-4); font-weight: 500; }
        .detail-val { font-size: 13px; font-weight: 700; color: var(--ink); text-align: right; }

        /* ── BOTTOM ROW ── */
        .card-footer {
            padding: 0 2rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        /* TOTAL */
        .total-card {
            background: linear-gradient(145deg, #0F172A, #1A2D50);
            border-radius: 18px; padding: 1.4rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            animation: fadeUp .5s 1s ease-out both;
        }
        .total-label { font-size: 11px; color: rgba(255,255,255,.4); margin-bottom: .3rem; font-weight: 500; letter-spacing: .04em; }
        .total-amount {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.7rem; font-weight: 800; color: #fff; letter-spacing: -.02em;
        }
        .total-icon {
            width: 48px; height: 48px; border-radius: 14px; font-size: 22px;
            background: rgba(255,255,255,.08); display: flex; align-items: center; justify-content: center;
        }

        /* WARNING */
        .warning-card {
            background: #FFFBEB; border: 1.5px solid #FDE68A; border-radius: 18px;
            padding: 1.25rem; display: flex; gap: .8rem; align-items: flex-start;
            animation: fadeUp .5s 1.05s ease-out both;
        }
        .warning-icon { font-size: 1.2rem; flex-shrink: 0; margin-top: 1px; }
        .warning-title { font-size: 13px; font-weight: 700; color: #92400E; margin-bottom: .3rem; }
        .warning-text { font-size: 12px; color: #B45309; line-height: 1.65; }

        /* ── ACTIONS ── */
        .card-actions {
            padding: 0 2rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: .75rem;
            align-items: center;
            animation: fadeUp .5s 1.1s ease-out both;
        }

        .btn-primary {
            display: flex; align-items: center; justify-content: center; gap: .45rem;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; padding: .9rem 1rem; border-radius: 13px;
            font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none; box-shadow: 0 6px 20px rgba(37,99,235,.35);
            transition: all .2s; white-space: nowrap;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37,99,235,.5); }

        .btn-secondary {
            display: flex; align-items: center; justify-content: center; gap: .45rem;
            background: #fff; border: 1.5px solid var(--border);
            color: var(--ink-3); padding: .9rem 1rem; border-radius: 13px;
            font-size: 14px; font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none; transition: all .2s; white-space: nowrap;
        }
        .btn-secondary:hover { border-color: var(--brand); color: var(--brand); background: #EFF6FF; }

        .btn-link {
            display: flex; align-items: center; justify-content: center;
            font-size: 13.5px; color: var(--ink-4); text-decoration: none;
            padding: .9rem .5rem; border-radius: 13px; font-weight: 500;
            transition: color .2s; white-space: nowrap;
        }
        .btn-link:hover { color: var(--ink-3); }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ════════════════════════════════════════
           TABLET  (≤ 900px)
        ════════════════════════════════════════ */
        @media (max-width: 900px) {
            .page-wrapper { max-width: 640px; }

            .card-hero {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .hero-right { align-items: center; flex-direction: row; justify-content: center; }
            .hero-sub { margin: 0 auto; }

            .card-body { grid-template-columns: 1fr; }
            .card-footer { grid-template-columns: 1fr; }
            .card-actions { grid-template-columns: 1fr 1fr; }
            .btn-link { grid-column: 1 / -1; }
        }

        /* ════════════════════════════════════════
           MOBILE  (≤ 600px)
        ════════════════════════════════════════ */
        @media (max-width: 600px) {
            body { padding: 1.25rem 1rem; align-items: flex-start; }
            .page-wrapper { max-width: 100%; }

            .brand-bar { margin-bottom: 1.25rem; }

            .card { border-radius: 20px; }

            .card-hero {
                padding: 2rem 1.25rem 1.75rem;
                grid-template-columns: 1fr;
                text-align: center;
            }
            .hero-right { flex-direction: column; align-items: center; }
            .step-tracker { min-width: unset; width: 100%; }
            .hero-title { font-size: 1.5rem; }

            .card-body { padding: 1.25rem; gap: 1rem; }
            .code-value { font-size: 1.8rem; }
            .total-amount { font-size: 1.45rem; }

            .card-footer { padding: 0 1.25rem 1.25rem; gap: 1rem; }
            .card-actions {
                padding: 0 1.25rem 1.5rem;
                grid-template-columns: 1fr;
                gap: .6rem;
            }
            .btn-link { grid-column: unset; }
        }
    </style>
</head>
<body>
    <div class="bg-noise"></div>
    <div class="bg-grid"></div>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>
    <div class="bg-glow-3"></div>

    <div class="page-wrapper">

        <!-- BRAND BAR -->
        <div class="brand-bar">
            <div class="brand-logo">✈️</div>
            <span class="brand-name">Sanu Travel</span>
        </div>

        <div class="card">

            <!-- ── HERO ── -->
            <div class="card-hero">
                <div class="hero-glow"></div>
                <div class="hero-glow-2"></div>

                <div class="hero-left">
                    <div class="hero-badge">
                        <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                        Booking Dikonfirmasi
                    </div>
                    <h1 class="hero-title">Booking<br><span>Berhasil!</span></h1>
                    <p class="hero-sub">Terima kasih telah menggunakan layanan Sanu Travel. Silakan lanjutkan proses pembayaran.</p>
                </div>

                <div class="hero-right">
                    <div class="icon-wrap">
                        <div class="icon-ring"></div>
                        <div class="icon-circle">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path class="check-path" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    <div class="step-tracker">
                        <p class="step-title">Status Perjalanan</p>
                        <div class="step-item">
                            <div class="step-dot done">✓</div>
                            <span class="step-label done">Booking Dibuat</span>
                        </div>
                        <div class="step-item">
                            <div class="step-dot active">2</div>
                            <span class="step-label active">Menunggu Bayar</span>
                        </div>
                        <div class="step-item">
                            <div class="step-dot pending">3</div>
                            <span class="step-label pending">Dikonfirmasi Admin</span>
                        </div>
                        <div class="step-item">
                            <div class="step-dot pending">4</div>
                            <span class="step-label pending">Perjalanan Dimulai</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── BODY ── -->
            <div class="card-body">

                <!-- Booking Code -->
                <div class="code-card">
                    <p class="code-label">Kode Booking</p>
                    <h2 class="code-value">{{ $booking->booking_code }}</h2>
                    <div class="code-divider"></div>
                    <p class="code-hint">Simpan kode ini untuk cek<br>status booking Anda</p>
                </div>

                <!-- Detail -->
                <div class="detail-card">
                    <div class="detail-header">Detail Perjalanan</div>
                    <div class="detail-row">
                        <span class="detail-key">Nama Customer</span>
                        <span class="detail-val">{{ $booking->customer_name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Tujuan</span>
                        <span class="detail-val">{{ $booking->destination }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Tanggal</span>
                        <span class="detail-val">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Jam</span>
                        <span class="detail-val">{{ substr($booking->pickup_time, 0, 5) }} WIB</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Penumpang</span>
                        <span class="detail-val">{{ $booking->total_passengers }} Orang</span>
                    </div>
                </div>
            </div>

            <!-- ── FOOTER ── -->
            <div class="card-footer">

                <!-- Total -->
                <div class="total-card">
                    <div>
                        <p class="total-label">Total Pembayaran</p>
                        <h2 class="total-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h2>
                    </div>
                    <div class="total-icon">💳</div>
                </div>

                <!-- Warning -->
                <div class="warning-card">
                    <span class="warning-icon">⚠️</span>
                    <div>
                        <p class="warning-title">Menunggu Pembayaran</p>
                        <p class="warning-text">Silakan lakukan pembayaran agar booking Anda segera diproses oleh admin kami.</p>
                    </div>
                </div>
            </div>

            <!-- ── ACTIONS ── -->
            <div class="card-actions">
                <a href="{{ route('payment.check') }}" class="btn-primary">💳 &nbsp;Bayar Sekarang</a>
                <a href="{{ route('tracking') }}" class="btn-secondary">📋 &nbsp;Cek Booking</a>
                <a href="/" class="btn-link">← Kembali ke Beranda</a>
            </div>

        </div><!-- .card -->
    </div><!-- .page-wrapper -->
</body>
</html>