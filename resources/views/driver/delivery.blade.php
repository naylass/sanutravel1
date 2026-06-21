<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Driver — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB;
            --brand-light: #3B82F6;
            --accent: #06B6D4;
            --ink: #0F172A;
            --ink-2: #334155;
            --ink-3: #64748B;
            --ink-4: #94A3B8;
            --border: #E2E8F0;
            --surface: #F1F5F9;
            --white: #ffffff;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            padding-bottom: 7rem;
        }

        /* ── NAV ── */
        .nav {
            background: rgba(6,13,26,.88);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255,255,255,.06);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-inner {
            max-width: 1100px; margin: 0 auto;
            padding: 0 2rem; height: 60px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-back {
            display: flex; align-items: center; gap: .45rem;
            color: rgba(255,255,255,.5); font-size: 13px; font-weight: 600;
            text-decoration: none; transition: color .2s;
        }
        .nav-back:hover { color: #fff; }
        .nav-brand {
            display: flex; align-items: center; gap: .6rem; text-decoration: none;
        }
        .nav-logo {
            width: 30px; height: 30px; border-radius: 8px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 14px;
        }
        .nav-title { font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -.01em; }
        .nav-tag {
            font-size: 12px; font-weight: 700; color: rgba(255,255,255,.4);
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
            padding: .28rem .7rem; border-radius: 100px;
        }

        /* ── PAGE HEADER ── */
        .page-header {
            background: linear-gradient(145deg, #060D1A 0%, #0C1D3A 50%, #091528 100%);
            position: relative; overflow: hidden; padding: 2rem 0 2rem;
        }
        .page-header-grid {
            position: absolute; inset: 0; pointer-events: none; opacity: .03;
            background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 48px 48px;
        }
        .page-header-glow {
            position: absolute; width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.18), transparent 65%);
            top: -150px; right: -80px; pointer-events: none;
        }
        .page-header-inner {
            max-width: 1100px; margin: 0 auto; padding: 0 2rem;
            position: relative; z-index: 5;
            display: flex; align-items: flex-end; justify-content: space-between; gap: 1.5rem;
        }
        .page-title {
            font-size: clamp(1.5rem, 3.5vw, 2rem);
            font-weight: 800; color: #fff; letter-spacing: -.03em; margin-bottom: .3rem;
        }
        .page-title span { color: var(--accent); }
        .page-sub { font-size: 13px; color: rgba(148,163,184,.6); }
        .page-count {
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
            border-radius: 16px; padding: .85rem 1.25rem; text-align: center;
            flex-shrink: 0; white-space: nowrap;
        }
        .page-count-num {
            font-size: 1.75rem; font-weight: 800;
            background: linear-gradient(135deg, #fff 30%, #67E8F9);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; line-height: 1;
        }
        .page-count-label { font-size: 11px; color: rgba(148,163,184,.5); margin-top: .25rem; font-weight: 600; letter-spacing: .04em; }

        /* ── PAGE WRAP ── */
        .page-wrap {
            max-width: 1100px; margin: 0 auto;
            padding: 2rem 2rem 0;
        }

        /* ── ORDER GRID ── */
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }

        /* ── ORDER CARD ── */
        .order-card {
            background: #fff; border-radius: 22px; border: 1.5px solid var(--border);
            box-shadow: 0 4px 20px rgba(15,23,42,.07); overflow: hidden;
            transition: transform .25s, box-shadow .25s;
            display: flex; flex-direction: column;
        }
        .order-card:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(15,23,42,.12); }

        .status-bar { height: 3px; flex-shrink: 0; }

        /* CARD HEADER */
        .card-header-wrap {
            background: linear-gradient(145deg, #0A1628, #152038);
            padding: 1.1rem 1.25rem;
            display: flex; justify-content: space-between; align-items: flex-start; gap: .75rem;
        }
        .card-code-label { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(148,163,184,.45); margin-bottom: .3rem; }
        .card-name {
            font-size: 1rem; font-weight: 800; color: #fff; letter-spacing: -.02em;
        }
        .card-code { font-size: 12px; color: rgba(148,163,184,.5); font-weight: 500; margin-top: .15rem; }

        /* BADGES */
        .status-badge { font-size: 11px; font-weight: 700; padding: .35rem .8rem; border-radius: 100px; white-space: nowrap; flex-shrink: 0; }

        /* CARD BODY */
        .card-body { padding: 1.1rem 1.25rem; flex: 1; display: flex; flex-direction: column; gap: .6rem; }

        /* ROUTE */
        .info-pill {
            background: var(--surface); border-radius: 12px; padding: .75rem .9rem;
            display: flex; align-items: flex-start; gap: .65rem;
        }
        .info-pill-icon { font-size: .95rem; flex-shrink: 0; margin-top: .1rem; }
        .info-pill-label { font-size: 10.5px; color: var(--ink-4); font-weight: 600; margin-bottom: .15rem; }
        .info-pill-value { font-size: 13px; font-weight: 600; color: var(--ink-2); }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
        .info-mini {
            background: var(--surface); border-radius: 12px; padding: .65rem .85rem;
            display: flex; align-items: center; gap: .55rem;
        }
        .info-mini-icon { font-size: .85rem; }
        .info-mini-label { font-size: 10px; color: var(--ink-4); font-weight: 600; }
        .info-mini-value { font-size: 12.5px; font-weight: 700; color: var(--ink-2); }

        /* CARD FOOTER */
        .card-footer { padding: 0 1.25rem 1.25rem; }

        /* SELECT */
        .select-wrap { position: relative; margin-bottom: .6rem; }
        .select-wrap::after {
            content: ''; position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
            width: 14px; height: 14px; pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") center/contain no-repeat;
        }
        .select-field {
            width: 100%; background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 12px; padding: .75rem 2.5rem .75rem .9rem;
            font-size: 13px; color: var(--ink); font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; transition: all .2s; outline: none;
            -webkit-appearance: none; appearance: none;
        }
        .select-field:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(37,99,235,.1); background: #fff; }

        .btn-update {
            width: 100%; background: linear-gradient(135deg, #0A1628, #1E293B);
            color: #fff; border: none; border-radius: 12px; padding: .8rem;
            font-size: 13px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; box-shadow: 0 4px 16px rgba(15,23,42,.2);
            transition: all .2s; display: flex; align-items: center; justify-content: center; gap: .4rem;
        }
        .btn-update:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(15,23,42,.3); }

        .completed-badge {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            background: #F0FDF4; border: 1.5px solid #BBF7D0; border-radius: 12px;
            padding: .8rem;
        }
        .completed-badge span { color: #16A34A; font-size: 13px; font-weight: 700; }

        /* EMPTY */
        .empty-wrap { grid-column: 1 / -1; }
        .empty-card {
            background: #fff; border-radius: 24px; border: 1.5px solid var(--border);
            text-align: center; padding: 4rem 2rem;
            box-shadow: 0 4px 20px rgba(15,23,42,.05);
        }
        .empty-icon {
            width: 80px; height: 80px; background: var(--surface); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; font-size: 2.2rem;
        }
        .empty-title { font-size: 1.1rem; font-weight: 800; color: var(--ink-2); margin-bottom: .4rem; }
        .empty-sub { font-size: 13px; color: var(--ink-4); }

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
        @media (max-width: 860px) {
            .orders-grid { grid-template-columns: 1fr; }
            .page-header-inner { flex-direction: column; align-items: flex-start; }
            .page-count { align-self: flex-start; display: flex; align-items: center; gap: .75rem; text-align: left; }
        }
        @media (max-width: 600px) {
            .nav-inner { padding: 0 1rem; }
            .page-header { padding: 1.5rem 0; }
            .page-header-inner { padding: 0 1rem; }
            .page-wrap { padding: 1.25rem 1rem 0; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="nav">
    <div class="nav-inner">
        <a href="/driver/dashboard" class="nav-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
        <div class="nav-brand">
            <div class="nav-logo">✈️</div>
            <span class="nav-title">Sanu Travel</span>
        </div>
        <span class="nav-tag">Delivery</span>
    </div>
</nav>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-header-grid"></div>
    <div class="page-header-glow"></div>
    <div class="page-header-inner">
        <div>
            <h1 class="page-title">Delivery <span>Order</span></h1>
            <p class="page-sub">Kelola perjalanan customer Anda hari ini</p>
        </div>
        <div class="page-count">
            <div class="page-count-num">{{ $orders->count() }}</div>
            <div class="page-count-label">Order Aktif</div>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="page-wrap">
    <div class="orders-grid">

    @forelse($orders as $o)
    @php
        $statusBar = match($o->status) {
            'prepared'  => 'background:linear-gradient(90deg,#2563EB,#3B82F6)',
            'ongoing'   => 'background:linear-gradient(90deg,#F59E0B,#FBBF24)',
            'completed' => 'background:linear-gradient(90deg,#10B981,#34D399)',
            default     => 'background:linear-gradient(90deg,#EF4444,#F87171)',
        };
        $sb = match($o->status) {
            'prepared'  => ['background:#EFF6FF;color:#2563EB;border:1px solid #BFDBFE', '🔵 Prepared'],
            'ongoing'   => ['background:#FFFBEB;color:#D97706;border:1px solid #FDE68A', '🔄 On Going'],
            'completed' => ['background:#F0FDF4;color:#16A34A;border:1px solid #BBF7D0', '✅ Selesai'],
            default     => ['background:#FEF2F2;color:#DC2626;border:1px solid #FECACA', '❌ Cancelled'],
        };
    @endphp

    <div class="order-card">
        <div class="status-bar" style="{{ $statusBar }}"></div>

        <!-- CARD HEADER -->
        <div class="card-header-wrap">
            <div style="min-width:0">
                <div class="card-code-label">Customer</div>
                <h2 class="card-name">{{ $o->booking->customer_name ?? '-' }}</h2>
                <p class="card-code">{{ $o->booking->booking_code ?? '-' }}</p>
            </div>
            <span class="status-badge" style="{{ $sb[0] }}">{{ $sb[1] }}</span>
        </div>

        <!-- CARD BODY -->
        <div class="card-body">
            <div class="info-pill">
                <span class="info-pill-icon">📍</span>
                <div style="min-width:0">
                    <p class="info-pill-label">Penjemputan</p>
                    <p class="info-pill-value">{{ $o->booking->pickup_location ?? '-' }}</p>
                </div>
            </div>
            <div class="info-pill">
                <span class="info-pill-icon">🏁</span>
                <div style="min-width:0">
                    <p class="info-pill-label">Tujuan</p>
                    <p class="info-pill-value">{{ $o->booking->destination ?? '-' }}</p>
                </div>
            </div>
            <div class="info-grid">
                <div class="info-mini">
                    <span class="info-mini-icon">🕐</span>
                    <div>
                        <p class="info-mini-label">Jam</p>
                        <p class="info-mini-value">{{ $o->booking->pickup_time ?? '-' }}</p>
                    </div>
                </div>
                <div class="info-mini">
                    <span class="info-mini-icon">👤</span>
                    <div>
                        <p class="info-mini-label">Penumpang</p>
                        <p class="info-mini-value">{{ $o->booking->total_passengers ?? 0 }} orang</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD FOOTER -->
        <div class="card-footer">
            @if($o->status != 'completed' && $o->status != 'cancel')
            <form method="POST" action="/driver/delivery/{{ $o->id }}/update">
                @csrf @method('PATCH')
                <div class="select-wrap">
                    <select name="status" class="select-field">
                        <option value="prepared">🔵Prepared</option>
                        <option value="ongoing">🔄 On Going</option>
                        <option value="completed">✅ Completed</option>
                        <option value="cancel">❌ Cancel</option>
                    </select>
                </div>
                <button class="btn-update">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Update Status
                </button>
            </form>
            @else
            <div class="completed-badge">
                <span>✅</span>
                <span>Perjalanan selesai</span>
            </div>
            @endif
        </div>
    </div>

    @empty
    <div class="empty-wrap">
        <div class="empty-card">
            <div class="empty-icon">🚐</div>
            <h2 class="empty-title">Belum Ada Delivery</h2>
            <p class="empty-sub">Delivery order akan muncul di sini</p>
        </div>
    </div>
    @endforelse

    </div><!-- orders-grid -->
</div><!-- page-wrap -->

<!-- BOTTOM NAV -->
<div class="bottom-nav">
    <div class="bottom-nav-inner">
        <a href="/driver/dashboard" class="nav-item">
            <span class="nav-item-icon">🏠</span>
            <span class="nav-item-label">Home</span>
        </a>
        <a href="/driver/delivery" class="nav-item active">
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