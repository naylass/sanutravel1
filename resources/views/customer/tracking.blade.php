<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Booking — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB;
            --brand-light: #3B82F6;
            --accent: #06B6D4;
            --green: #10B981;
            --ink: #0F172A;
            --ink-2: #1E293B;
            --ink-3: #64748B;
            --ink-4: #94A3B8;
            --border: #E2E8F0;
            --surface: #F8FAFC;
            --white: #fff;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            padding-bottom: 3rem;
        }

        /* ── NAV ── */
        .nav {
            background: rgba(6,13,26,.9); backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255,255,255,.06);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-inner {
            max-width: 900px; margin: 0 auto;
            padding: 0 1.5rem; height: 60px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-back {
            display: flex; align-items: center; gap: .45rem;
            color: rgba(255,255,255,.5); font-size: 13px; font-weight: 600;
            text-decoration: none; transition: color .2s;
        }
        .nav-back:hover { color: #fff; }
        .nav-logo { display: flex; align-items: center; gap: .6rem; text-decoration: none; }
        .nav-logo-mark {
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 16px;
        }
        .nav-logo-text { font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -.02em; }
        .nav-tag {
            font-size: 11.5px; font-weight: 700; color: rgba(255,255,255,.4);
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.08);
            padding: .3rem .75rem; border-radius: 100px;
        }

        /* ── PAGE HERO ── */
        .page-hero {
            background: linear-gradient(145deg, #060D1A 0%, #0C1D3A 55%, #091528 100%);
            position: relative; overflow: hidden; padding: 2rem 0 2rem;
        }
        .hero-grid-bg {
            position: absolute; inset: 0; pointer-events: none; opacity: .03;
            background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 52px 52px;
        }
        .hero-glow {
            position: absolute; width: 500px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.15), transparent 65%);
            top: -150px; right: -80px; pointer-events: none;
        }
        .hero-inner {
            max-width: 900px; margin: 0 auto; padding: 0 1.5rem;
            position: relative; z-index: 5;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(6,182,212,.12); border: 1px solid rgba(6,182,212,.25);
            border-radius: 100px; padding: .3rem .85rem;
            font-size: 11px; font-weight: 700; color: var(--accent);
            letter-spacing: .06em; text-transform: uppercase; margin-bottom: .85rem;
        }
        .hero-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 800; color: #fff; letter-spacing: -.03em; margin-bottom: .4rem;
        }
        .hero-title span { color: var(--accent); }
        .hero-sub { font-size: 13px; color: rgba(148,163,184,.6); }

        /* ── MAIN WRAP ── */
        .main-wrap {
            max-width: 900px; margin: 0 auto;
            padding: 2rem 1.5rem;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        /* ── SEARCH CARD ── */
        .search-card {
            background: #fff; border-radius: 22px; border: 1.5px solid var(--border);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(15,23,42,.07);
            position: sticky; top: 76px;
        }
        .search-card-header {
            background: linear-gradient(145deg, #0A1628, #152038);
            padding: 1.1rem 1.4rem;
            display: flex; align-items: center; gap: .7rem;
        }
        .search-card-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 1rem;
        }
        .search-card-title { font-size: 13.5px; font-weight: 800; color: #fff; }
        .search-card-sub { font-size: 11px; color: rgba(148,163,184,.5); margin-top: .1rem; }
        .search-card-body { padding: 1.4rem; }

        .field-label {
            display: block; font-size: 11.5px; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            color: var(--ink-3); margin-bottom: .4rem;
        }
        .field-input {
            width: 100%; background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 12px; padding: .75rem 1rem;
            font-size: 13.5px; font-weight: 600; color: var(--ink);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .2s; outline: none;
        }
        .field-input:focus {
            border-color: var(--brand); background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }
        .field-input::placeholder { color: var(--ink-4); font-weight: 400; }
        .field-group { margin-bottom: .9rem; }

        .btn-search {
            width: 100%; background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; border: none; border-radius: 12px; padding: .85rem;
            font-size: 13.5px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; box-shadow: 0 4px 16px rgba(37,99,235,.3);
            transition: all .2s; display: flex; align-items: center; justify-content: center; gap: .5rem;
            margin-top: .25rem;
        }
        .btn-search:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,.45); }

        /* ALERT */
        .alert-success {
            background: #F0FDF4; border: 1.5px solid #BBF7D0;
            border-radius: 14px; padding: .85rem 1rem;
            display: flex; align-items: center; gap: .65rem;
            margin-bottom: 1.1rem; font-size: 13px; font-weight: 600; color: #15803D;
        }

        /* ── RIGHT: RESULTS ── */
        .results-col {}

        /* EMPTY STATE */
        .empty-card {
            background: #fff; border-radius: 22px; border: 1.5px solid var(--border);
            text-align: center; padding: 3.5rem 2rem;
            box-shadow: 0 4px 20px rgba(15,23,42,.06);
        }
        .empty-icon {
            width: 80px; height: 80px; background: var(--surface);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 1.25rem; font-size: 2.2rem;
        }
        .empty-title { font-size: 1.1rem; font-weight: 800; color: var(--ink-2); margin-bottom: .4rem; }
        .empty-sub { font-size: 13px; color: var(--ink-4); margin-bottom: 1.25rem; }
        .btn-cta {
            display: inline-flex; align-items: center; gap: .4rem;
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; text-decoration: none; font-size: 13px; font-weight: 700;
            padding: .75rem 1.5rem; border-radius: 12px;
            box-shadow: 0 4px 16px rgba(37,99,235,.3); transition: all .2s;
        }
        .btn-cta:hover { transform: translateY(-2px); }

        /* ── BOOKING CARD ── */
        .booking-card {
            background: #fff; border-radius: 22px; border: 1.5px solid var(--border);
            overflow: hidden; margin-bottom: 1.25rem;
            box-shadow: 0 4px 20px rgba(15,23,42,.07);
        }
        .booking-card-top-bar { height: 3px; }

        /* BOOKING HEADER */
        .booking-header {
            background: linear-gradient(145deg, #0A1628, #152038);
            padding: 1.1rem 1.4rem;
            display: flex; justify-content: space-between; align-items: center; gap: 1rem;
        }
        .booking-code-label { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(148,163,184,.45); margin-bottom: .3rem; }
        .booking-code-value {
            font-size: 1.25rem; font-weight: 800; letter-spacing: .1em;
            background: linear-gradient(135deg, #fff 30%, #67E8F9);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .booking-customer-name { font-size: 12px; color: rgba(148,163,184,.5); margin-top: .2rem; }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; gap: .3rem; font-size: 11px; font-weight: 700; padding: .38rem .85rem; border-radius: 100px; white-space: nowrap; }
        .badge-amber  { background: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; }
        .badge-blue   { background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
        .badge-green  { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
        .badge-red    { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .badge-orange { background: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA; }
        .badge-slate  { background: #F8FAFC; color: #64748B; border: 1px solid #E2E8F0; }

        /* BOOKING BODY */
        .booking-body { padding: 1.25rem 1.4rem; }

        /* PROGRESS TRACKER */
        .progress-section { margin-bottom: 1.4rem; }
        .progress-label { font-size: 10.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--ink-4); margin-bottom: 1rem; }
        .progress-track {
            display: flex; align-items: center;
        }
        .progress-step { display: flex; flex-direction: column; align-items: center; flex: 1; }
        .progress-step-circle {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 800; position: relative; z-index: 1;
            transition: all .3s;
        }
        .progress-step-circle.done {
            background: linear-gradient(135deg, var(--green), #34D399);
            box-shadow: 0 4px 12px rgba(16,185,129,.35); color: #fff; font-size: .75rem;
        }
        .progress-step-circle.active {
            background: linear-gradient(135deg, var(--brand), var(--brand-light));
            box-shadow: 0 4px 12px rgba(37,99,235,.35); color: #fff; font-size: .8rem;
        }
        .progress-step-circle.pending {
            background: #F1F5F9; color: var(--ink-4); font-size: .85rem;
            border: 2px solid var(--border);
        }
        .progress-step-text { font-size: 10px; font-weight: 600; color: var(--ink-4); margin-top: .5rem; text-align: center; line-height: 1.3; }
        .progress-step-text.done { color: var(--green); }
        .progress-step-text.active { color: var(--brand); }

        .progress-line { flex: 1; height: 3px; border-radius: 2px; margin-bottom: 1.6rem; transition: background .3s; }
        .progress-line.done { background: linear-gradient(90deg, var(--green), #34D399); }
        .progress-line.pending { background: var(--border); }

        /* DETAIL GRID */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .65rem; margin-bottom: 1.1rem; }
        .detail-cell {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 13px; padding: .85rem 1rem;
        }
        .detail-cell-label { font-size: 10.5px; color: var(--ink-4); font-weight: 600; margin-bottom: .25rem; }
        .detail-cell-value { font-size: 13px; font-weight: 700; color: var(--ink-2); }

        /* COUNTDOWN */
        .countdown-box {
            background: linear-gradient(135deg, #EFF6FF, #EFF9FC);
            border: 1.5px solid #BFDBFE; border-radius: 14px;
            padding: .9rem 1.1rem; margin-bottom: .9rem;
            display: flex; align-items: center; gap: .85rem;
        }
        .countdown-icon { font-size: 1.4rem; flex-shrink: 0; }
        .countdown-label { font-size: 10.5px; color: #3B82F6; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-bottom: .2rem; }
        .countdown-value { font-size: 14px; font-weight: 800; color: #1E40AF; }

        /* PAYMENT BOX */
        .payment-box {
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 16px; padding: 1.1rem; margin-bottom: .9rem;
        }
        .payment-box-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: .75rem; }
        .payment-status-label { font-size: 10.5px; color: var(--ink-4); font-weight: 600; margin-bottom: .25rem; }

        /* UNPAID WARNING */
        .unpaid-warn {
            background: #FEF2F2; border: 1.5px solid #FECACA;
            border-radius: 14px; padding: .9rem 1.1rem; margin-bottom: .9rem;
            display: flex; align-items: flex-start; gap: .75rem;
        }
        .unpaid-warn-icon { font-size: 1.2rem; flex-shrink: 0; margin-top: 1px; }
        .unpaid-warn-title { font-size: 13px; font-weight: 800; color: #DC2626; margin-bottom: .2rem; }
        .unpaid-warn-text { font-size: 12px; color: #EF4444; line-height: 1.6; }

        /* DRIVER BOX */
        .driver-box {
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 16px; padding: 1.1rem; margin-bottom: .9rem;
        }
        .driver-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; margin-top: .75rem; }
        .driver-cell {
            background: #fff; border: 1px solid var(--border);
            border-radius: 11px; padding: .7rem .9rem;
        }

        /* TOTAL + CANCEL */
        .total-cancel-row {
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; flex-wrap: wrap;
        }
        .total-label { font-size: 11px; color: var(--ink-4); font-weight: 600; margin-bottom: .2rem; }
        .total-amount { font-size: 1.6rem; font-weight: 800; color: var(--ink); letter-spacing: -.03em; }

        .btn-cancel {
            background: #FEF2F2; border: 1.5px solid #FECACA; color: #DC2626;
            border-radius: 12px; padding: .7rem 1.1rem;
            font-size: 12.5px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; transition: all .2s;
        }
        .btn-cancel:hover { background: #FEE2E2; }

        .cutoff-tag {
            background: #FFFBEB; border: 1px solid #FDE68A;
            color: #D97706; border-radius: 12px; padding: .7rem 1.1rem;
            font-size: 12px; font-weight: 700;
        }

        /* PROOF LINK */
        .proof-link {
            display: inline-flex; align-items: center; gap: .3rem;
            color: var(--brand); font-size: 13px; font-weight: 600;
            text-decoration: none; margin-top: .5rem;
        }
        .proof-link:hover { text-decoration: underline; }

        /* RESPONSIVE */
        @media (max-width: 800px) {
            .main-wrap { grid-template-columns: 1fr; }
            .search-card { position: static; }
        }
        @media (max-width: 540px) {
            .nav-inner { padding: 0 1rem; }
            .hero-inner { padding: 0 1rem; }
            .main-wrap { padding: 1.25rem 1rem; }
            .booking-header { flex-direction: column; align-items: flex-start; gap: .6rem; }
            .detail-grid { grid-template-columns: 1fr 1fr; }
            .total-cancel-row { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="nav">
    <div class="nav-inner">
        <a href="/" class="nav-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Beranda
        </a>
        <a href="/" class="nav-logo">
            <div class="nav-logo-mark">✈️</div>
            <span class="nav-logo-text">Sanu Travel</span>
        </a>
        <span class="nav-tag">Cek Booking</span>
    </div>
</nav>

<!-- HERO -->
<div class="page-hero">
    <div class="hero-grid-bg"></div>
    <div class="hero-glow"></div>
    <div class="hero-inner">
        <div class="hero-eyebrow">📋 Lacak Perjalanan</div>
        <h1 class="hero-title">Cek Status <span>Booking</span></h1>
        <p class="hero-sub">Masukkan kode booking dan nomor WhatsApp untuk melihat status perjalanan Anda</p>
    </div>
</div>

<!-- MAIN -->
<div class="main-wrap">

    <!-- LEFT: SEARCH -->
    <div>
        @if(session('success'))
        <div class="alert-success">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <div class="search-card">
            <div class="search-card-header">
                <div class="search-card-icon">🔍</div>
                <div>
                    <div class="search-card-title">Lacak Booking</div>
                    <div class="search-card-sub">Masukkan data booking Anda</div>
                </div>
            </div>
            <div class="search-card-body">
                <form method="GET" action="{{ route('tracking') }}">
                    <div class="field-group">
                        <label class="field-label">Kode Booking</label>
                        <input type="text" name="booking_code" value="{{ request('booking_code') }}"
                               placeholder="BOOK-XXXXXXX" class="field-input" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Nomor WhatsApp</label>
                        <input type="text" name="phone_number" value="{{ request('phone_number') }}"
                               placeholder="628xxxxxxxxxx" class="field-input" required>
                    </div>
                    <button type="submit" class="btn-search">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                        Cek Booking
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT: RESULTS -->
    <div class="results-col">

        {{-- EMPTY STATE --}}
        @if(request()->filled('booking_code') && $bookings->count() == 0)
        <div class="empty-card">
            <div class="empty-icon">📋</div>
            <h3 class="empty-title">Booking Tidak Ditemukan</h3>
            <p class="empty-sub">Pastikan kode booking dan nomor WhatsApp sudah benar.</p>
            <a href="/booking/create" class="btn-cta">
                Pesan Sekarang
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        @endif

        @foreach($bookings as $booking)
        @php
            $barColor = match($booking->status) {
                'confirmed','completed'   => 'background:linear-gradient(90deg,#10B981,#34D399)',
                'pending'                 => 'background:linear-gradient(90deg,#F59E0B,#FBBF24)',
                'cancel_request'          => 'background:linear-gradient(90deg,#F97316,#FB923C)',
                default                   => 'background:linear-gradient(90deg,#EF4444,#F87171)',
            };
            $payStatus = optional($booking->payment)->status;
            $paid = !in_array($payStatus, [null, 'unpaid']);
            $payVerified = in_array($payStatus, ['verified','settled']);
            $departed = in_array($booking->status, ['confirmed','completed']);
            $done = $booking->status === 'completed';
            $departureTime = \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time);
            $diffHours = now()->diffInHours($departureTime, false);
            $canCancel = now()->lt($departureTime->copy()->subHours(6));
        @endphp

        <div class="booking-card">
            <div class="booking-card-top-bar" style="{{ $barColor }}"></div>

            <!-- HEADER -->
            <div class="booking-header">
                <div>
                    <div class="booking-code-label">Kode Booking</div>
                    <div class="booking-code-value">{{ $booking->booking_code }}</div>
                    <div class="booking-customer-name">{{ $booking->customer_name }}</div>
                </div>
                @if($booking->status == 'pending')
                    <span class="badge badge-amber">⏳ Pending</span>
                @elseif($booking->status == 'confirmed')
                    <span class="badge badge-blue">✅ Confirmed</span>
                @elseif($booking->status == 'completed')
                    <span class="badge badge-green">🏁 Selesai</span>
                @elseif($booking->status == 'cancel_request')
                    <span class="badge badge-orange">⏳ Menunggu Cancel</span>
                @else
                    <span class="badge badge-red">❌ Dibatalkan</span>
                @endif
            </div>

            <div class="booking-body">

                <!-- PROGRESS -->
                <div class="progress-section">
                    <div class="progress-label">Progress Perjalanan</div>
                    <div class="progress-track">
                        <div class="progress-step">
                            <div class="progress-step-circle done">✓</div>
                            <div class="progress-step-text done">Booking<br>Dibuat</div>
                        </div>
                        <div class="progress-line {{ $paid ? 'done' : 'pending' }}"></div>
                        <div class="progress-step">
                            <div class="progress-step-circle {{ $payVerified ? 'done' : ($paid ? 'active' : 'pending') }}">
                                {{ $payVerified ? '✓' : '💳' }}
                            </div>
                            <div class="progress-step-text {{ $payVerified ? 'done' : ($paid ? 'active' : '') }}">Pembayaran</div>
                        </div>
                        <div class="progress-line {{ $departed ? 'done' : 'pending' }}"></div>
                        <div class="progress-step">
                            <div class="progress-step-circle {{ $done ? 'done' : ($departed ? 'active' : 'pending') }}">
                                {{ $done ? '✓' : '🚐' }}
                            </div>
                            <div class="progress-step-text {{ $done ? 'done' : ($departed ? 'active' : '') }}">Driver<br>Berangkat</div>
                        </div>
                        <div class="progress-line {{ $done ? 'done' : 'pending' }}"></div>
                        <div class="progress-step">
                            <div class="progress-step-circle {{ $done ? 'done' : 'pending' }}">
                                {{ $done ? '✓' : '🏁' }}
                            </div>
                            <div class="progress-step-text {{ $done ? 'done' : '' }}">Selesai</div>
                        </div>
                    </div>
                </div>

                <!-- DETAIL GRID -->
                <div class="detail-grid">
                    <div class="detail-cell">
                        <div class="detail-cell-label">📍 Penjemputan</div>
                        <div class="detail-cell-value" style="font-size:12px;line-height:1.4">{{ $booking->pickup_location }}</div>
                    </div>
                    <div class="detail-cell">
                        <div class="detail-cell-label">🏁 Tujuan</div>
                        <div class="detail-cell-value" style="font-size:12px;line-height:1.4">{{ $booking->destination }}</div>
                    </div>
                    <div class="detail-cell">
                        <div class="detail-cell-label">🗓 Jadwal</div>
                        <div class="detail-cell-value" style="font-size:12px">
                            {{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}<br>
                            <span style="color:var(--ink-4)">{{ substr($booking->pickup_time, 0, 5) }} WIB</span>
                        </div>
                    </div>
                    <div class="detail-cell">
                        <div class="detail-cell-label">👥 Penumpang</div>
                        <div class="detail-cell-value">{{ $booking->total_passengers }} Orang</div>
                    </div>
                </div>

                <!-- COUNTDOWN -->
                @if($diffHours > 0)
                <div class="countdown-box">
                    <span class="countdown-icon">⏰</span>
                    <div>
                        <div class="countdown-label">Countdown Keberangkatan</div>
                        <div class="countdown-value">
                            Berangkat dalam
                            {{ floor($diffHours / 24) > 0 ? floor($diffHours / 24) . ' hari ' : '' }}
                            {{ $diffHours % 24 }} jam lagi
                        </div>
                    </div>
                </div>
                @endif

                <!-- UNPAID WARNING -->
                @if($payStatus == 'unpaid' || $payStatus === null)
                <div class="unpaid-warn">
                    <span class="unpaid-warn-icon">⚠️</span>
                    <div>
                        <div class="unpaid-warn-title">Pembayaran Belum Dilakukan</div>
                        <div class="unpaid-warn-text">Booking akan otomatis dibatalkan apabila pembayaran tidak dilakukan maksimal 4 jam sebelum keberangkatan.</div>
                    </div>
                </div>
                @endif

                <!-- PAYMENT STATUS -->
                <div class="payment-box">
                    <div class="payment-box-header">
                        <div>
                            <div class="payment-status-label">Status Pembayaran</div>
                            @if($payStatus == 'waiting_verification')
                                <div style="font-weight:800;color:#D97706;font-size:13.5px;">⏳ Menunggu Verifikasi</div>
                            @elseif($payStatus == 'verified')
                                <div style="font-weight:800;color:#16A34A;font-size:13.5px;">✅ Verified</div>
                            @elseif($payStatus == 'waiting_driver_collection')
                                <div style="font-weight:800;color:#2563EB;font-size:13.5px;">💵 Menunggu Driver</div>
                            @elseif($payStatus == 'cash_received')
                                <div style="font-weight:800;color:#0891B2;font-size:13.5px;">💰 Cash Diterima Driver</div>
                            @elseif($payStatus == 'settled')
                                <div style="font-weight:800;color:#16A34A;font-size:13.5px;">✅ Payment Settled</div>
                            @elseif($payStatus == 'rejected')
                                <div style="font-weight:800;color:#DC2626;font-size:13.5px;">❌ Pembayaran Ditolak</div>
                            @else
                                <div style="font-weight:800;color:#EF4444;font-size:13.5px;">❌ Belum Dibayar</div>
                            @endif
                        </div>
                        <div style="text-align:right">
                            <div class="payment-status-label">Metode</div>
                            <div style="font-size:13px;font-weight:700;color:var(--ink-2)">
                                @if(optional($booking->payment)->payment_method == 'qris') 💳 QRIS
                                @elseif(optional($booking->payment)->payment_method == 'cash') 💵 Cash
                                @elseif(optional($booking->payment)->payment_method == 'transfer') 🏦 Transfer
                                @else —
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(optional($booking->payment)->paid_at)
                    <div style="padding-top:.75rem;border-top:1px solid var(--border);">
                        <div class="payment-status-label">Tanggal Pembayaran</div>
                        <div style="font-size:13px;font-weight:600;color:var(--ink-2)">
                            🗓 {{ \Carbon\Carbon::parse($booking->payment->paid_at)->format('d M Y H:i') }}
                        </div>
                    </div>
                    @endif
                    @if(optional($booking->payment)->payment_proof)
                    <a href="{{ asset('storage/' . $booking->payment->payment_proof) }}" target="_blank" class="proof-link">
                        📎 Lihat Bukti Pembayaran
                    </a>
                    @endif
                </div>

                <!-- DRIVER INFO -->
                @if($booking->status == 'confirmed' || $booking->status == 'completed')
                <div class="driver-box">
                    <div style="font-size:12px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--ink-4);margin-bottom:.1rem">Info Driver</div>
                    <div style="font-size:14px;font-weight:800;color:var(--ink);margin-top:.25rem">🚐 Driver Sanu Travel</div>
                    <div class="driver-grid">
                        <div class="driver-cell">
                            <div style="font-size:10.5px;color:var(--ink-4);margin-bottom:.25rem">Nomor Polisi</div>
                            <div style="font-size:13px;font-weight:700;color:var(--ink-2)">B 1234 ST</div>
                        </div>
                        <div class="driver-cell">
                            <div style="font-size:10.5px;color:var(--ink-4);margin-bottom:.25rem">Status</div>
                            <div style="font-size:13px;font-weight:700;color:#16A34A">Siap Menjemput</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- TOTAL + CANCEL -->
                @php
                    $departureTime2 = \Carbon\Carbon::parse($booking->pickup_date . ' ' . $booking->pickup_time);
                    $canCancel2 = now()->lt($departureTime2->copy()->subHours(6));
                @endphp
                <div class="total-cancel-row">
                    <div>
                        <div class="total-label">Total Pembayaran</div>
                        <div class="total-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                    </div>
                    @if(in_array($booking->status, ['pending','confirmed']) && $canCancel2)
                    <form method="POST" action="{{ route('booking.cancel', $booking->id) }}"
                          onsubmit="return confirm('Yakin ingin cancel booking ini?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-cancel">❌ Ajukan Cancel</button>
                    </form>
                    @elseif(!$canCancel2 && in_array($booking->status, ['pending','confirmed']))
                    <div class="cutoff-tag">⏰ Batas cancel sudah lewat</div>
                    @endif
                </div>

            </div>
        </div>
        @endforeach

    </div>
</div>

</body>
</html>