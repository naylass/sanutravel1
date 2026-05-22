<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran — Sanu Travel</title>
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
            position: relative;
        }

        /* BACKGROUNDS */
        .bg-noise {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.4;
        }
        .bg-grid {
            position: fixed; inset: 0; pointer-events: none; z-index: 0; opacity: .03;
            background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 56px 56px;
        }
        .bg-glow-1 {
            position: fixed; width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,.15), transparent 68%);
            top: -200px; left: 30%; transform: translateX(-50%); pointer-events: none; z-index: 0;
        }
        .bg-glow-2 {
            position: fixed; width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,.1), transparent 68%);
            bottom: -100px; right: 5%; pointer-events: none; z-index: 0;
        }

        /* NAV */
        .site-nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(6,13,26,.85);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .nav-inner {
            max-width: 900px; margin: 0 auto; padding: 0 1.5rem;
            height: 60px; display: flex; align-items: center; justify-content: space-between;
        }
        .nav-back {
            display: flex; align-items: center; gap: .5rem;
            color: rgba(255,255,255,.5); font-size: 13px; font-weight: 600;
            text-decoration: none; transition: color .2s;
        }
        .nav-back:hover { color: rgba(255,255,255,.85); }
        .nav-brand {
            display: flex; align-items: center; gap: .6rem; text-decoration: none;
        }
        .nav-logo {
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 16px;
        }
        .nav-brand-name {
            font-size: 16px; font-weight: 800; color: #fff; letter-spacing: -.01em;
        }
        .nav-tag {
            font-size: 12px; font-weight: 700; color: rgba(255,255,255,.45);
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
            padding: .3rem .75rem; border-radius: 100px;
        }

        /* PAGE WRAP */
        .page-wrap {
            position: relative; z-index: 10;
            max-width: 900px; margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        /* PAGE TITLE */
        .page-title-block {
            margin-bottom: 1.75rem;
            animation: fadeDown .5s ease-out both;
        }
        .page-title {
            font-size: clamp(1.4rem, 3vw, 1.75rem);
            font-weight: 800; color: #fff; letter-spacing: -.03em; margin-bottom: .3rem;
        }
        .page-title span { color: var(--accent); }
        .page-sub { font-size: 13.5px; color: rgba(148,163,184,.65); }

        /* ALERTS */
        .alert {
            border-radius: 14px; padding: .9rem 1.1rem;
            display: flex; align-items: center; gap: .75rem;
            margin-bottom: 1.25rem; font-size: 13px; font-weight: 600;
            animation: fadeDown .4s ease-out both;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* SEARCH CARD */
        .search-card {
            background: #fff; border-radius: 22px; overflow: hidden;
            box-shadow: 0 20px 48px rgba(0,0,0,.3), 0 0 0 1px rgba(255,255,255,.06);
            margin-bottom: 1.5rem;
            animation: riseUp .6s cubic-bezier(.16,1,.3,1) .1s both;
        }
        .search-card-header {
            background: linear-gradient(145deg, #0A1628, #152038);
            padding: 1.25rem 1.5rem;
            display: flex; align-items: center; gap: .75rem;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .search-card-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), var(--brand));
            display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;
        }
        .search-card-title {
            font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -.01em;
        }
        .search-card-sub { font-size: 12px; color: rgba(148,163,184,.6); margin-top: .1rem; }
        .search-card-body { padding: 1.5rem; }

        /* FORM LAYOUT */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
        .form-group { display: flex; flex-direction: column; gap: .4rem; }
        .field-label { font-size: 12px; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; color: var(--ink-3); }
        .field-input {
            width: 100%; background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 12px; padding: .75rem 1rem;
            font-size: 13.5px; font-weight: 600; color: var(--ink);
            font-family: 'Plus Jakarta Sans', sans-serif; outline: none; transition: all .2s;
        }
        .field-input:focus { border-color: var(--brand); background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
        .field-input::placeholder { color: var(--ink-4); font-weight: 400; }

        /* BTN */
        .btn-primary {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            width: 100%; background: linear-gradient(135deg, var(--brand), var(--brand-light));
            color: #fff; border: none; border-radius: 12px; padding: .9rem;
            font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; box-shadow: 0 6px 20px rgba(37,99,235,.35);
            transition: all .2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,99,235,.5); }
        .btn-submit {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            width: 100%; background: linear-gradient(135deg, #0A1628, #1E293B);
            color: #fff; border: none; border-radius: 12px; padding: .9rem;
            font-size: 14px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; box-shadow: 0 6px 20px rgba(0,0,0,.2);
            transition: all .2s;
        }
        .btn-submit:hover { transform: translateY(-2px); opacity: .9; }

        /* EMPTY STATE */
        .empty-card {
            background: #fff; border-radius: 22px; padding: 3rem 2rem; text-align: center;
            box-shadow: 0 12px 40px rgba(0,0,0,.2);
            animation: riseUp .5s .2s ease-out both;
        }
        .empty-emoji { font-size: 2.5rem; margin-bottom: .75rem; }
        .empty-title { font-size: 15px; font-weight: 800; color: var(--ink); margin-bottom: .4rem; }
        .empty-sub { font-size: 13px; color: var(--ink-4); }

        /* BOOKING CARD */
        .booking-card {
            background: #fff; border-radius: 22px; overflow: hidden;
            box-shadow: 0 20px 48px rgba(0,0,0,.3), 0 0 0 1px rgba(255,255,255,.06);
            margin-bottom: 1.25rem;
            animation: riseUp .6s cubic-bezier(.16,1,.3,1) .15s both;
        }
        .accent-bar { height: 3px; }
        .booking-card-header {
            background: linear-gradient(145deg, #0A1628, #152038);
            padding: 1.25rem 1.5rem;
            display: flex; justify-content: space-between; align-items: center;
        }
        .booking-code-label { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(148,163,184,.5); margin-bottom: .35rem; }
        .booking-code-value {
            font-size: 1.35rem; font-weight: 800; letter-spacing: .1em;
            background: linear-gradient(135deg, #fff 30%, #67E8F9);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; gap: .3rem; font-size: 11.5px; font-weight: 700; padding: .4rem .9rem; border-radius: 100px; }
        .badge-red    { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .badge-amber  { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .badge-green  { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-orange { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
        .badge-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }

        /* DETAIL GRID */
        .booking-card-body { padding: 1.25rem 1.5rem; }
        .detail-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: .75rem; margin-bottom: 1.25rem;
        }
        .detail-cell {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 12px; padding: .85rem 1rem;
        }
        .detail-cell-label { font-size: 10.5px; color: var(--ink-4); margin-bottom: .3rem; font-weight: 600; letter-spacing: .03em; }
        .detail-cell-value { font-size: 13px; font-weight: 700; color: var(--ink-2); }

        /* PAYMENT FORM INSIDE CARD */
        .payment-form-section { border-top: 1.5px solid var(--border); padding-top: 1.25rem; margin-top: .25rem; }
        .payment-form-title { font-size: 13px; font-weight: 800; color: var(--ink); margin-bottom: 1rem; }

        .method-tabs { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; margin-bottom: 1.25rem; }
        .method-tab {
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            padding: .75rem; border-radius: 12px; border: 2px solid var(--border);
            background: var(--surface); cursor: pointer;
            font-size: 13.5px; font-weight: 700; color: var(--ink-3);
            transition: all .2s;
        }
        .method-tab:has(input:checked),
        .method-tab.active { border-color: var(--brand); background: #EFF6FF; color: var(--brand); }

        /* SELECT */
        .select-wrap { position: relative; }
        .select-wrap::after {
            content: ''; position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            width: 0; height: 0; border-left: 4px solid transparent;
            border-right: 4px solid transparent; border-top: 5px solid var(--ink-4);
            pointer-events: none;
        }
        .field-select {
            width: 100%; appearance: none; -webkit-appearance: none;
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 12px; padding: .75rem 2.5rem .75rem 1rem;
            font-size: 13.5px; font-weight: 600; color: var(--ink);
            font-family: 'Plus Jakarta Sans', sans-serif; outline: none; cursor: pointer;
            transition: all .2s;
        }
        .field-select:focus { border-color: var(--brand); background: #fff; box-shadow: 0 0 0 3px rgba(37,99,235,.1); }

        /* QRIS BOX */
        .qris-box {
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 16px; padding: 1.25rem;
        }
        .qris-inner {
            background: #fff; border: 1px solid var(--border);
            border-radius: 12px; padding: 1rem; text-align: center;
        }
        .qris-inner img { width: 160px; margin: 0 auto .75rem; border-radius: 10px; display: block; }
        .qris-apps { display: flex; flex-wrap: wrap; justify-content: center; gap: .4rem; margin-top: .75rem; }
        .qris-app-tag {
            background: var(--surface); color: var(--ink-3);
            font-size: 11px; font-weight: 700; padding: .3rem .75rem;
            border-radius: 100px; border: 1px solid var(--border);
        }

        /* CASH BOX */
        .cash-box {
            background: #FFFBEB; border: 1.5px solid #FDE68A;
            border-radius: 14px; padding: 1rem 1.25rem;
            display: flex; gap: .75rem; align-items: flex-start;
        }
        .cash-box-icon { font-size: 1.3rem; flex-shrink: 0; margin-top: 1px; }
        .cash-box-title { font-size: 13px; font-weight: 800; color: #92400E; margin-bottom: .25rem; }
        .cash-box-text { font-size: 12px; color: #B45309; line-height: 1.6; }

        /* FILE DROP */
        .file-drop {
            border: 2px dashed var(--border); border-radius: 14px; padding: 1.5rem 1rem;
            text-align: center; cursor: pointer; background: var(--surface);
            transition: border-color .2s, background .2s;
        }
        .file-drop:hover { border-color: var(--brand); background: #EFF6FF; }
        .file-drop-icon { font-size: 1.75rem; margin-bottom: .5rem; }
        .file-drop-text { font-size: 13px; font-weight: 600; color: var(--ink-3); }
        .file-drop-hint { font-size: 11.5px; color: var(--ink-4); margin-top: .3rem; }

        /* ANIMATIONS */
        @keyframes riseUp {
            from { opacity: 0; transform: translateY(24px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* RESPONSIVE */
        @media (max-width: 720px) {
            .form-row { grid-template-columns: 1fr; }
            .detail-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 540px) {
            .page-wrap { padding: 1.25rem 1rem 3rem; }
            .nav-inner { padding: 0 1rem; }
            .booking-card-header { flex-direction: column; align-items: flex-start; gap: .75rem; }
            .detail-grid { grid-template-columns: 1fr 1fr; gap: .5rem; }
            .search-card-body { padding: 1.1rem; }
            .booking-card-body { padding: 1rem 1.1rem; }
        }
    </style>
</head>
<body>

<div class="bg-noise"></div>
<div class="bg-grid"></div>
<div class="bg-glow-1"></div>
<div class="bg-glow-2"></div>

{{-- NAV --}}
<nav class="site-nav">
    <div class="nav-inner">
        <a href="/" class="nav-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Beranda
        </a>
        <a href="/" class="nav-brand">
            <div class="nav-logo">✈️</div>
            <span class="nav-brand-name">Sanu Travel</span>
        </a>
        <span class="nav-tag">Pembayaran</span>
    </div>
</nav>

<div class="page-wrap">

    {{-- PAGE TITLE --}}
    <div class="page-title-block">
        <h1 class="page-title">Cek & <span>Bayar</span></h1>
        <p class="page-sub">Masukkan kode booking dan nomor HP untuk melanjutkan pembayaran</p>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
    <div class="alert alert-success">
        <span>✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <span>❌</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- SEARCH CARD --}}
    <div class="search-card">
        <div class="search-card-header">
            <div class="search-card-icon">🔍</div>
            <div>
                <div class="search-card-title">Cari Booking</div>
                <div class="search-card-sub">Masukkan data booking Anda</div>
            </div>
        </div>
        <div class="search-card-body">
            <form method="GET" action="{{ route('payment.check') }}">
                <div class="form-row">
                    <div class="form-group">
                        <label class="field-label">Kode Booking</label>
                        <input type="text" name="booking_code" value="{{ request('booking_code') }}"
                               placeholder="BOOK-XXXX" class="field-input" required>
                    </div>
                    <div class="form-group">
                        <label class="field-label">Nomor HP</label>
                        <input type="text" name="phone_number" value="{{ request('phone_number') }}"
                               placeholder="628xxxxxxxxxx" class="field-input" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/></svg>
                    Cari Booking
                </button>
            </form>
        </div>
    </div>

    {{-- EMPTY --}}
    @if(request()->filled('booking_code') && request()->filled('phone_number') && $bookings->count() == 0)
    <div class="empty-card">
        <div class="empty-emoji">😢</div>
        <h2 class="empty-title">Booking Tidak Ditemukan</h2>
        <p class="empty-sub">Pastikan kode booking dan nomor HP sudah benar</p>
    </div>
    @endif

    {{-- BOOKING LIST --}}
    @foreach($bookings as $booking)
    @php
        $payment = $booking->payment;
        $status  = $payment?->status ?? 'unpaid';
        $barColor = match($status) {
            'verified','settled'           => 'background:linear-gradient(90deg,#10b981,#34d399)',
            'waiting_verification'         => 'background:linear-gradient(90deg,#f59e0b,#fbbf24)',
            'rejected','unpaid'            => 'background:linear-gradient(90deg,#ef4444,#f87171)',
            'waiting_driver_collection'    => 'background:linear-gradient(90deg,#f97316,#fb923c)',
            default                        => 'background:linear-gradient(90deg,#3b82f6,#60a5fa)',
        };
    @endphp

    <div class="booking-card">
        <div class="accent-bar" style="{{ $barColor }}"></div>

        {{-- CARD HEADER --}}
        <div class="booking-card-header">
            <div>
                <div class="booking-code-label">Kode Booking</div>
                <div class="booking-code-value">{{ $booking->booking_code }}</div>
            </div>
            @if($status == 'unpaid')
                <span class="badge badge-red">Belum Bayar</span>
            @elseif($status == 'waiting_verification')
                <span class="badge badge-amber">⏳ Menunggu Verifikasi</span>
            @elseif($status == 'verified')
                <span class="badge badge-green">✅ Verified</span>
            @elseif($status == 'rejected')
                <span class="badge badge-red">❌ Ditolak</span>
            @elseif($status == 'waiting_driver_collection')
                <span class="badge badge-orange">🔄 Bayar ke Driver</span>
            @elseif($status == 'cash_received')
                <span class="badge badge-blue">💵 Cash Diterima</span>
            @elseif($status == 'settled')
                <span class="badge badge-green">✅ Selesai</span>
            @endif
        </div>

        {{-- DETAIL --}}
        <div class="booking-card-body">
            <div class="detail-grid">
                <div class="detail-cell">
                    <div class="detail-cell-label">Nama Customer</div>
                    <div class="detail-cell-value">{{ $booking->customer_name }}</div>
                </div>
                <div class="detail-cell">
                    <div class="detail-cell-label">Tujuan</div>
                    <div class="detail-cell-value">{{ $booking->destination }}</div>
                </div>
                <div class="detail-cell">
                    <div class="detail-cell-label">Jadwal</div>
                    <div class="detail-cell-value" style="font-size:12px;">
                        {{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}<br>
                        <span style="color:var(--ink-4);">{{ substr($booking->pickup_time,0,5) }} WIB</span>
                    </div>
                </div>
                <div class="detail-cell" style="background:linear-gradient(145deg,#0A1628,#152038);border-color:rgba(6,182,212,.15);">
                    <div class="detail-cell-label" style="color:rgba(148,163,184,.5);">Total Bayar</div>
                    <div class="detail-cell-value" style="color:#fff;font-size:14px;background:linear-gradient(135deg,#fff 30%,#67E8F9);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                        Rp {{ number_format($booking->total_price,0,',','.') }}
                    </div>
                </div>
            </div>

            {{-- PAYMENT FORM --}}
            @if(in_array($status, ['unpaid', 'rejected']))
            <div class="payment-form-section">
                <p class="payment-form-title">💳 Lakukan Pembayaran</p>
                <form method="POST" action="{{ route('payment.upload', $booking->id) }}" enctype="multipart/form-data">
                    @csrf

                    {{-- METHOD SELECT --}}
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="field-label">Metode Pembayaran</label>
                        <div class="select-wrap">
                            <select name="payment_method"
                                    id="payment_method_{{ $booking->id }}"
                                    class="field-select"
                                    onchange="togglePayment({{ $booking->id }})">
                                <option value="qris">📱 QRIS</option>
                                <option value="transfer">🏦 Transfer Bank</option>
                                <option value="cash">💵 Cash</option>
                            </select>
                        </div>
                    </div>

                    {{-- QRIS --}}
                    <div id="qrisSection_{{ $booking->id }}" style="margin-bottom:1rem;">
                        <div class="qris-box">
                            <p style="font-weight:800;font-size:13px;color:var(--ink);margin-bottom:.85rem;">📱 Scan QR untuk Pembayaran</p>
                            <div class="qris-inner">
                                <img src="{{ asset('build/assets/images/qris.png') }}" 
     alt="QRIS Payment"
     style="
        width:100%;
        max-width:350px;
        display:block;
        margin:auto;
        border-radius:24px;
        box-shadow:0 15px 40px rgba(0,0,0,.2);
     ">
                                <p style="font-size:11.5px;color:var(--ink-4);margin-bottom:.5rem;">Scan menggunakan:</p>
                                <div class="qris-apps">
                                    @foreach(['DANA','OVO','GoPay','Mobile Banking'] as $app)
                                    <span class="qris-app-tag">{{ $app }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TRANSFER --}}
<div id="transferSection_{{ $booking->id }}" style="display:none;margin-bottom:1rem;">

    <div class="qris-box">

        <p style="
            font-weight:800;
            font-size:13px;
            color:var(--ink);
            margin-bottom:.85rem;
        ">
            🏦 Transfer Bank
        </p>

        <div class="qris-inner" style="text-align:left;">

            {{-- BCA --}}
            <div style="
                padding:1rem;
                border:1px solid var(--border);
                border-radius:12px;
                margin-bottom:.75rem;
                background:#F8FAFC;
            ">

                <div style="
                    font-size:12px;
                    color:var(--ink-4);
                    margin-bottom:.35rem;
                ">
                    Bank
                </div>

                <div style="
                    font-size:15px;
                    font-weight:800;
                    color:var(--ink);
                    margin-bottom:.75rem;
                ">
                    MANDIRI
                </div>

                <div style="
                    font-size:12px;
                    color:var(--ink-4);
                    margin-bottom:.35rem;
                ">
                    Nomor Rekening
                </div>

                <div style="
                    font-size:18px;
                    font-weight:800;
                    color:var(--brand);
                    letter-spacing:.05em;
                    margin-bottom:.75rem;
                ">
                    1234567890
                </div>

                <div style="
                    font-size:12px;
                    color:var(--ink-4);
                    margin-bottom:.35rem;
                ">
                    Atas Nama
                </div>

                <div style="
                    font-size:14px;
                    font-weight:700;
                    color:var(--ink);
                ">
                    SANU TRAVEL 
                </div>
            </div>

            <div style="
                margin-top:1rem;
                padding:.9rem 1rem;
                background:#EFF6FF;
                border:1px solid #BFDBFE;
                border-radius:12px;
                font-size:12px;
                line-height:1.7;
                color:#1D4ED8;
            ">
                Setelah transfer, silakan upload bukti pembayaran agar dapat diverifikasi admin.
            </div>
        </div>
    </div>
</div>

                    {{-- CASH --}}
                    <div id="cashSection_{{ $booking->id }}" style="display:none;margin-bottom:1rem;">
                        <div class="cash-box">
                            <span class="cash-box-icon">💵</span>
                            <div>
                                <p class="cash-box-title">Pembayaran Cash</p>
                                <p class="cash-box-text">Pembayaran dilakukan langsung kepada driver saat penjemputan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- UPLOAD --}}
                    <div id="uploadSection_{{ $booking->id }}" style="margin-bottom:1rem;">
                        <label class="field-label" style="margin-bottom:.5rem;">Upload Bukti Pembayaran</label>
                        <div class="file-drop" onclick="document.getElementById('fileInput_{{ $booking->id }}').click()">
                            <div class="file-drop-icon" id="uploadIcon_{{ $booking->id }}">📁</div>
                            <p class="file-drop-text" id="uploadText_{{ $booking->id }}">Klik untuk upload bukti pembayaran</p>
                            <p class="file-drop-hint">JPG, PNG — maks 5MB</p>
                            <img id="preview_{{ $booking->id }}" style="display:none;margin:1rem auto 0;border-radius:10px;max-height:160px;object-fit:contain;">
                        </div>
                        <input type="file" id="fileInput_{{ $booking->id }}" name="payment_proof"
                               style="display:none;" accept="image/*"
                               onchange="previewFile(this, {{ $booking->id }})">
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
    @endforeach

</div>

<script>
function togglePayment(id) {
    const method   = document.getElementById('payment_method_' + id).value;
    const qris     = document.getElementById('qrisSection_' + id);
    const transfer = document.getElementById('transferSection_' + id);
    const cash     = document.getElementById('cashSection_' + id);
    const upload   = document.getElementById('uploadSection_' + id);

    qris.style.display     = 'none';
    transfer.style.display = 'none';
    cash.style.display     = 'none';

    if (method === 'cash') {
        qris.style.display   = 'none';
        cash.style.display   = 'block';
        upload.style.display = 'none';
    
    
    } else if (method === 'transfer') {
        transfer.style.display = 'block';
        upload.style.display   = 'block';

    } else {
        qris.style.display   = 'block';
        cash.style.display   = 'none';
        upload.style.display = 'block';
    }
}

function previewFile(input, id) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview_' + id).src = e.target.result;
        document.getElementById('preview_' + id).style.display = 'block';
        document.getElementById('uploadText_' + id).innerText  = file.name;
        document.getElementById('uploadIcon_' + id).innerText  = '🖼️';
    };
    reader.readAsDataURL(file);
}
</script>
</body>
</html>