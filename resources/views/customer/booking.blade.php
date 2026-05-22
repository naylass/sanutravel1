<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Travel — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand:#2563EB; --brand-light:#3B82F6;
            --accent:#06B6D4; --accent-warm:#F59E0B;
            --green:#10B981;
            --ink:#0F172A; --ink-2:#1E293B; --ink-3:#64748B; --ink-4:#94A3B8;
            --border:#E2E8F0; --surface:#F8FAFC;
        }
        *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--surface); color:var(--ink); min-height:100vh; }

        /* NAV */
        .nav { background:rgba(6,13,26,.92); backdrop-filter:blur(24px); border-bottom:1px solid rgba(255,255,255,.06); position:sticky; top:0; z-index:100; }
        .nav-inner { max-width:1200px; margin:auto; padding:0 1.5rem; height:60px; display:flex; align-items:center; justify-content:space-between; }
        .nav-back { display:flex; align-items:center; gap:.45rem; color:rgba(255,255,255,.5); font-size:13px; font-weight:600; text-decoration:none; transition:color .2s; }
        .nav-back:hover { color:#fff; }
        .nav-logo { display:flex; align-items:center; gap:.6rem; text-decoration:none; }
        .nav-logo-mark { width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg,var(--accent),var(--brand)); display:flex; align-items:center; justify-content:center; font-size:16px; }
        .nav-logo-text { font-size:16px; font-weight:800; color:#fff; letter-spacing:-.02em; }
        .nav-tag { font-size:11.5px; font-weight:700; color:rgba(255,255,255,.4); background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.08); padding:.3rem .75rem; border-radius:100px; }

        /* HERO */
        .page-hero { background:linear-gradient(145deg,#060D1A,#0C1D3A 55%,#091528); position:relative; overflow:hidden; padding:2.5rem 0 2rem; }
        .hero-grid { position:absolute; inset:0; pointer-events:none; opacity:.03; background-image:linear-gradient(var(--border) 1px,transparent 1px), linear-gradient(90deg,var(--border) 1px,transparent 1px); background-size:52px 52px; }
        .hero-glow1 { position:absolute; width:500px; height:500px; border-radius:50%; background:radial-gradient(circle,rgba(37,99,235,.18),transparent 65%); top:-200px; right:-80px; pointer-events:none; }
        .hero-glow2 { position:absolute; width:280px; height:280px; border-radius:50%; background:radial-gradient(circle,rgba(6,182,212,.1),transparent 65%); bottom:-80px; left:-40px; pointer-events:none; }
        .hero-inner { max-width:1200px; margin:auto; padding:0 1.5rem; position:relative; z-index:5; display:flex; align-items:flex-end; justify-content:space-between; gap:2rem; }
        .hero-eyebrow { display:inline-flex; align-items:center; gap:.4rem; background:rgba(6,182,212,.12); border:1px solid rgba(6,182,212,.25); border-radius:100px; padding:.3rem .85rem; font-size:11px; font-weight:700; color:var(--accent); letter-spacing:.06em; text-transform:uppercase; margin-bottom:.85rem; }
        .hero-title { font-size:clamp(1.7rem,4vw,2.4rem); font-weight:800; color:#fff; letter-spacing:-.035em; line-height:1.1; margin-bottom:.5rem; }
        .hero-title span { color:var(--accent); }
        .hero-sub { font-size:14px; color:rgba(148,163,184,.65); line-height:1.65; max-width:420px; }

        .hero-steps { background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08); border-radius:20px; padding:1.25rem 1.4rem; min-width:220px; flex-shrink:0; }
        .hero-steps-title { font-size:10px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; color:rgba(148,163,184,.45); margin-bottom:.85rem; }
        .hero-step { display:flex; align-items:center; gap:.6rem; padding:.32rem 0; }
        .hero-step-dot { width:22px; height:22px; border-radius:50%; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:10px; font-weight:800; background:linear-gradient(135deg,var(--accent),var(--brand)); color:#fff; }
        .hero-step-text { font-size:12px; font-weight:600; color:rgba(255,255,255,.7); }

        /* INFO BANNER */
        .info-banner { max-width:1200px; margin:1.5rem auto 0; padding:0 1.5rem; }
        .info-inner { background:linear-gradient(135deg,#EFF6FF,#F0F9FF); border:1.5px solid #BFDBFE; border-radius:16px; padding:.9rem 1.2rem; display:flex; align-items:center; gap:.9rem; }
        .info-icon { width:40px; height:40px; border-radius:11px; background:#DBEAFE; display:flex; align-items:center; justify-content:center; font-size:1.15rem; flex-shrink:0; }
        .info-title { font-size:13px; font-weight:800; color:#1E3A8A; margin-bottom:.15rem; }
        .info-text { font-size:12px; color:#1E40AF; line-height:1.6; }

        /* BODY */
        .page-body { max-width:1200px; margin:auto; padding:2rem 1.5rem 6rem; }
        .form-grid { display:grid; grid-template-columns:1fr 360px; gap:1.5rem; align-items:start; }

        /* SECTION BADGE */
        .section-badge { display:inline-flex; align-items:center; gap:.35rem; font-size:10px; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:var(--brand); margin-bottom:1rem; }
        .section-badge::before { content:''; display:block; width:3px; height:14px; border-radius:2px; background:linear-gradient(135deg,var(--accent),var(--brand)); }

        /* FORM CARD */
        .form-card { background:#fff; border:1.5px solid var(--border); border-radius:22px; padding:1.5rem; margin-bottom:1rem; box-shadow:0 2px 16px rgba(15,23,42,.05); transition:box-shadow .2s; }
        .form-card:hover { box-shadow:0 6px 28px rgba(15,23,42,.09); }

        /* SERVICE */
        .service-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }
        .service-label { cursor:pointer; display:block; }
        .service-card { border:2px solid var(--border); background:var(--surface); border-radius:18px; padding:1.25rem; transition:all .2s; position:relative; overflow:hidden; }
        .service-card:hover { border-color:var(--brand-light); transform:translateY(-2px); box-shadow:0 8px 20px rgba(37,99,235,.1); }
        .service-card.active-reguler { border-color:var(--brand); background:linear-gradient(145deg,var(--brand),#1D4ED8); box-shadow:0 8px 28px rgba(37,99,235,.35); }
        .service-card.active-eksklusif { border-color:#F59E0B; background:linear-gradient(145deg,#FFFBEB,#FEF3C7); box-shadow:0 8px 24px rgba(245,158,11,.2); }
        .svc-icon { font-size:1.75rem; margin-bottom:.6rem; display:block; }
        .svc-name { font-weight:800; font-size:15px; margin-bottom:.2rem; }
        .svc-price { font-size:12.5px; margin-bottom:.5rem; }
        .svc-badge { display:inline-block; font-size:10px; font-weight:800; padding:.22rem .65rem; border-radius:100px; }

        /* INPUTS */
        .field-group { margin-bottom:1rem; }
        .field-group:last-child { margin-bottom:0; }
        .field-label { display:block; font-size:11.5px; font-weight:700; letter-spacing:.05em; text-transform:uppercase; color:var(--ink-3); margin-bottom:.4rem; }
        .field-input { width:100%; background:var(--surface); border:1.5px solid var(--border); border-radius:12px; padding:.8rem 1rem; font-size:13.5px; font-weight:600; color:var(--ink); font-family:'Plus Jakarta Sans',sans-serif; transition:all .2s; outline:none; -webkit-appearance:none; appearance:none; }
        .field-input:focus { border-color:var(--brand); background:#fff; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
        .field-input::placeholder { color:var(--ink-4); font-weight:400; }
        .field-row { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; }
        .select-wrap { position:relative; }
        .select-wrap::after { content:''; position:absolute; right:13px; top:50%; transform:translateY(-50%); width:0; height:0; border-left:4px solid transparent; border-right:4px solid transparent; border-top:5px solid var(--ink-4); pointer-events:none; }

        /* PAX */
        .pax-row { display:flex; align-items:center; gap:1rem; }
        .pax-btn { width:44px; height:44px; border-radius:12px; border:2px solid var(--border); background:var(--surface); color:var(--ink-2); font-size:1.25rem; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .15s; font-family:'Plus Jakarta Sans',sans-serif; }
        .pax-btn:hover { border-color:var(--brand); color:var(--brand); background:#EFF6FF; }
        .pax-btn:active { transform:scale(.9); }
        .pax-num { font-size:2rem; font-weight:800; color:var(--ink); letter-spacing:-.04em; line-height:1; text-align:center; min-width:48px; }
        .pax-sub { font-size:11px; color:var(--ink-4); font-weight:600; text-transform:uppercase; letter-spacing:.05em; text-align:center; margin-top:.15rem; }
        .pax-info { flex:1; background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:.75rem 1rem; }
        .pax-info-label { font-size:10.5px; color:var(--ink-4); font-weight:600; margin-bottom:.2rem; }
        .pax-info-value { font-size:13px; font-weight:700; color:var(--ink-2); }

        /* WARNING */
        .warning-box { display:none; margin-top:.75rem; background:#FEF2F2; border:1.5px solid #FECACA; border-radius:12px; padding:.8rem 1rem; font-size:12.5px; font-weight:600; color:#DC2626; line-height:1.5; }

        /* SUMMARY */
        .summary-panel { background:linear-gradient(155deg,#091520,#0D1F3C); border:1px solid rgba(37,99,235,.18); border-radius:24px; padding:1.6rem; position:sticky; top:76px; box-shadow:0 24px 52px rgba(0,0,0,.35); }
        .summary-top { display:flex; align-items:center; gap:.7rem; margin-bottom:1.4rem; padding-bottom:1rem; border-bottom:1px solid rgba(255,255,255,.07); }
        .summary-top-icon { width:38px; height:38px; border-radius:11px; background:linear-gradient(135deg,var(--accent),var(--brand)); display:flex; align-items:center; justify-content:center; font-size:1.1rem; }
        .summary-top-title { font-size:14px; font-weight:800; color:#fff; }
        .summary-top-sub { font-size:11px; color:rgba(148,163,184,.5); margin-top:.1rem; }
        .summary-row { display:flex; justify-content:space-between; align-items:center; padding:.5rem 0; border-bottom:1px solid rgba(255,255,255,.04); }
        .summary-row:last-of-type { border-bottom:none; }
        .summary-key { font-size:12px; color:rgba(148,163,184,.6); font-weight:500; }
        .summary-val { font-size:12px; font-weight:700; color:rgba(255,255,255,.85); text-align:right; }
        .summary-total-block { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.07); border-radius:16px; padding:1.1rem; margin:1rem 0; }
        .summary-total-label { font-size:10.5px; color:rgba(148,163,184,.45); margin-bottom:.3rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase; }
        .summary-total-amount { font-size:1.9rem; font-weight:800; letter-spacing:-.04em; background:linear-gradient(135deg,#fff 30%,#67E8F9); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .btn-book { width:100%; background:linear-gradient(135deg,var(--accent),#0891B2); color:#fff; border:none; border-radius:14px; padding:1rem; font-size:14px; font-weight:800; font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer; transition:all .2s; box-shadow:0 6px 20px rgba(6,182,212,.35); display:flex; align-items:center; justify-content:center; gap:.5rem; }
        .btn-book:hover { transform:translateY(-2px); box-shadow:0 12px 28px rgba(6,182,212,.5); }
        .btn-book:disabled { opacity:.45; cursor:not-allowed; transform:none; }
        .summary-secure { display:flex; align-items:center; justify-content:center; gap:.4rem; margin-top:.85rem; }
        .summary-secure span { font-size:11.5px; color:rgba(148,163,184,.35); }

        /* MOBILE BAR */
        .mobile-bar { display:none; position:fixed; bottom:0; inset-x:0; z-index:100; background:rgba(255,255,255,.97); backdrop-filter:blur(16px); border-top:1px solid var(--border); padding:.85rem 1.25rem; box-shadow:0 -8px 32px rgba(15,23,42,.1); }
        .mobile-bar-inner { display:flex; align-items:center; justify-content:space-between; gap:1rem; }
        .mobile-total-label { font-size:11px; color:var(--ink-4); font-weight:600; margin-bottom:.1rem; }
        .mobile-total-amount { font-size:1.25rem; font-weight:800; color:var(--ink); letter-spacing:-.02em; }
        .btn-book-mobile { background:linear-gradient(135deg,var(--brand),var(--brand-light)); color:#fff; border:none; border-radius:13px; padding:.8rem 1.5rem; font-size:13.5px; font-weight:800; font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer; white-space:nowrap; box-shadow:0 4px 16px rgba(37,99,235,.3); }
        .btn-book-mobile:disabled { opacity:.5; cursor:not-allowed; }

        /* RESPONSIVE */
        @media(max-width:960px) {
            .form-grid { grid-template-columns:1fr; }
            .summary-panel { display:none; }
            .mobile-bar { display:block; }
            body { padding-bottom:80px; }
            .hero-inner { flex-direction:column; align-items:flex-start; }
            .hero-steps { width:100%; }
        }
        @media(max-width:600px) {
            .page-body { padding:1.25rem 1rem 6rem; }
            .info-banner { padding:0 1rem; }
            .hero-inner { padding:0 1rem; }
            .nav-inner { padding:0 1rem; }
            .field-row { grid-template-columns:1fr; }
            .form-card { padding:1.25rem; }
            .service-grid { grid-template-columns:1fr 1fr; }
        }
    </style>
</head>
<body>

<nav class="nav">
    <div class="nav-inner">
        <a href="/" class="nav-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Beranda
        </a>
        <a href="/" class="nav-logo">
            <div class="nav-logo-mark">✈️</div>
            <span class="nav-logo-text">Sanu Travel</span>
        </a>
        <span class="nav-tag">Booking</span>
    </div>
</nav>

<div class="page-hero">
    <div class="hero-grid"></div>
    <div class="hero-glow1"></div>
    <div class="hero-glow2"></div>
    <div class="hero-inner">
        <div>
            <div class="hero-eyebrow">✈️ Formulir Pemesanan</div>
            <h1 class="hero-title">Pesan <span>Travel</span><br>Sekarang</h1>
            <p class="hero-sub">Isi data perjalanan Anda dengan lengkap. Konfirmasi dan pembayaran bisa dilakukan setelah booking dibuat.</p>
        </div>
        <div class="hero-steps">
            <p class="hero-steps-title">Alur Pemesanan</p>
            <div class="hero-step"><div class="hero-step-dot">1</div><span class="hero-step-text">Isi formulir booking</span></div>
            <div class="hero-step"><div class="hero-step-dot">2</div><span class="hero-step-text">Lakukan pembayaran</span></div>
            <div class="hero-step"><div class="hero-step-dot">3</div><span class="hero-step-text">Konfirmasi admin</span></div>
            <div class="hero-step"><div class="hero-step-dot">4</div><span class="hero-step-text">Driver menjemput 🚐</span></div>
        </div>
    </div>
</div>

<div class="info-banner">
    <div class="info-inner">
        <div class="info-icon">⏰</div>
        <div>
            <div class="info-title">Batas Waktu Pemesanan</div>
            <div class="info-text">Booking untuk keberangkatan hari yang sama hanya dapat dilakukan <strong>minimal 3 jam sebelum jadwal</strong>. Jadwal yang sudah melewati batas tidak dapat dipilih.</div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="form-grid">

        <!-- LEFT -->
        <div>
            <form method="POST" action="{{ route('booking.create') }}" id="bookingForm">
                @csrf

                <!-- LAYANAN -->
                <div class="form-card">
                    <div class="section-badge">Pilih Layanan</div>
                    <div class="service-grid">
                        <label class="service-label">
                            <input type="radio" name="service_id" value="1" checked hidden onclick="setService('reguler')">
                            <div id="regulerCard" class="service-card active-reguler">
                                <span class="svc-icon">🚐</span>
                                <div class="svc-name" id="regName" style="color:#fff">Reguler</div>
                                <div class="svc-price" id="regPrice" style="color:rgba(255,255,255,.7)">Rp 300.000 / orang</div>
                                <span class="svc-badge" id="regBadge" style="background:rgba(255,255,255,.18);color:#fff">Sharing Seat</span>
                            </div>
                        </label>
                        <label class="service-label">
                            <input type="radio" name="service_id" value="2" hidden onclick="setService('eksklusif')">
                            <div id="eksklusifCard" class="service-card">
                                <span class="svc-icon">✨</span>
                                <div class="svc-name" id="eksName" style="color:var(--ink)">Eksklusif</div>
                                <div class="svc-price" id="eksPrice" style="color:var(--ink-3)">Rp 600.000 / trip</div>
                                <span class="svc-badge" id="eksBadge" style="background:#FEF3C7;color:#B45309">Private Trip</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- JADWAL -->
                <div class="form-card">
                    <div class="section-badge">Jadwal Keberangkatan</div>
                    <div class="field-group">
                        <label class="field-label">📍 Area Penjemputan</label>
                        <div class="select-wrap">
                            <select name="area" id="areaSelect" class="field-input" style="padding-right:2.5rem" onchange="updateTotal()" required>
                                <option value="">Pilih area penjemputan</option>
                                <option value="cilegon">Cilegon</option>
                                <option value="serang">Serang</option>
                                <option value="lainnya">Luar Area (+Rp 100.000)</option>
                            </select>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">🗓 Tanggal Berangkat</label>
                            <input type="date" name="pickup_date" id="pickupDate" class="field-input" required>
                        </div>
                        <div class="field-group">
                            <label class="field-label">🕐 Jam Keberangkatan</label>
                            <div class="select-wrap">
                                <select name="pickup_time" id="timeSelect" class="field-input" style="padding-right:2.5rem" required>
                                    <option value="">Pilih jam</option>
                                    <option value="00:00">00:00 WIB</option>
                                    <option value="04:00">04:00 WIB</option>
                                    <option value="06:00">06:00 WIB</option>
                                    <option value="08:00">08:00 WIB</option>
                                    <option value="10:00">10:00 WIB</option>
                                    <option value="12:00">12:00 WIB</option>
                                    <option value="15:00">15:00 WIB</option>
                                    <option value="18:00">18:00 WIB</option>
                                    <option value="22:00">22:00 WIB</option>
                                </select>
                            </div>
                            <input type="time" name="custom_time" id="customTime" class="field-input" style="display:none;margin-top:.5rem">
                            <div id="exclusiveWarning" class="warning-box">⚠ Booking minimal dilakukan 3 jam sebelum keberangkatan.</div>
                        </div>
                    </div>
                </div>

                <!-- DATA DIRI -->
                <div class="form-card">
                    <div class="section-badge">Data Penumpang</div>
                    <div class="field-group">
                        <label class="field-label">👤 Nama Lengkap</label>
                        <input type="text" name="customer_name" class="field-input" placeholder="Masukkan nama lengkap Anda" required>
                    </div>
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">✉️ Email</label>
                            <input type="email" name="email" class="field-input" placeholder="email@contoh.com" required>
                        </div>
                        <div class="field-group">
                            <label class="field-label">📱 Nomor WhatsApp</label>
                            <input type="text" name="phone_number" class="field-input" placeholder="628xxxxxxxxxx" required>
                        </div>
                    </div>
                </div>

                <!-- LOKASI -->
                <div class="form-card">
                    <div class="section-badge">Lokasi Perjalanan</div>
                    <div class="field-group">
                        <label class="field-label">📍 Alamat Penjemputan</label>
                        <input type="text" name="pickup_location" class="field-input" placeholder="Alamat lengkap penjemputan" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">🏁 Tujuan Perjalanan</label>
                        <input type="text" name="destination" class="field-input" placeholder="Masukkan tujuan perjalanan" required>
                    </div>
                </div>

                <!-- PENUMPANG -->
                <div id="passengerBox" class="form-card">
                    <div class="section-badge">Jumlah Penumpang</div>
                    <div class="pax-row">
                        <button type="button" class="pax-btn" onclick="changePax(-1)">−</button>
                        <div>
                            <div class="pax-num" id="paxDisplay">1</div>
                            <div class="pax-sub">Orang</div>
                        </div>
                        <button type="button" class="pax-btn" onclick="changePax(1)">+</button>
                        <div class="pax-info">
                            <div class="pax-info-label">Estimasi biaya penumpang</div>
                            <div class="pax-info-value" id="paxEstimate">Rp 300.000</div>
                        </div>
                        <input type="hidden" name="total_passengers" id="paxInput" value="1">
                    </div>
                </div>

            </form>
        </div>

        <!-- RIGHT: SUMMARY -->
        <div>
            <div class="summary-panel">
                <div class="summary-top">
                    <div class="summary-top-icon">🧾</div>
                    <div>
                        <div class="summary-top-title">Ringkasan Booking</div>
                        <div class="summary-top-sub">Estimasi biaya perjalanan</div>
                    </div>
                </div>
                <div class="summary-row"><span class="summary-key">Layanan</span><span class="summary-val" id="summaryService">Reguler</span></div>
                <div class="summary-row"><span class="summary-key">Penumpang</span><span class="summary-val" id="summaryPax">1 orang</span></div>
                <div class="summary-row"><span class="summary-key">Area</span><span class="summary-val" id="summaryArea">—</span></div>
                <div class="summary-row" id="extraFeeRow" style="display:none"><span class="summary-key">Biaya Luar Area</span><span class="summary-val" style="color:#F59E0B">+Rp 100.000</span></div>
                <div class="summary-total-block">
                    <div class="summary-total-label">Total Pembayaran</div>
                    <div class="summary-total-amount" id="total">Rp 300.000</div>
                </div>
                <button type="submit" form="bookingForm" class="btn-book" id="bookingButton">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Booking Sekarang
                </button>
                <div class="summary-secure"><span>🔒</span><span>Data Anda aman dan terenkripsi</span></div>
            </div>
        </div>

    </div>
</div>

<!-- MOBILE BAR -->
<div class="mobile-bar">
    <div class="mobile-bar-inner">
        <div>
            <div class="mobile-total-label">Total Pembayaran</div>
            <div class="mobile-total-amount" id="totalMobile">Rp 300.000</div>
        </div>
        <button type="submit" form="bookingForm" class="btn-book-mobile" id="bookingButtonMobile">Booking →</button>
    </div>
</div>

<script>
let service = 'reguler', pax = 1;

function changePax(d) {
    pax = Math.max(1, Math.min(8, pax + d));
    document.getElementById('paxDisplay').textContent = pax;
    document.getElementById('paxInput').value = pax;
    updateTotal();
}

function setService(type) {
    service = type;
    const reg = document.getElementById('regulerCard');
    const eks = document.getElementById('eksklusifCard');
    const ts  = document.getElementById('timeSelect');
    const ct  = document.getElementById('customTime');
    const wb  = document.getElementById('exclusiveWarning');

    if (type === 'reguler') {
        reg.className = 'service-card active-reguler';
        eks.className = 'service-card';
        document.getElementById('regName').style.color = '#fff';
        document.getElementById('regPrice').style.color = 'rgba(255,255,255,.7)';
        document.getElementById('regBadge').style.cssText = 'background:rgba(255,255,255,.18);color:#fff';
        document.getElementById('eksName').style.color = 'var(--ink)';
        document.getElementById('eksPrice').style.color = 'var(--ink-3)';
        document.getElementById('eksBadge').style.cssText = 'background:#FEF3C7;color:#B45309';
        ts.style.display = 'block'; ts.required = true;
        ct.style.display = 'none'; ct.required = false; ct.value = '';
        wb.style.display = 'none';
        document.getElementById('summaryService').textContent = 'Reguler';
    } else {
        reg.className = 'service-card';
        eks.className = 'service-card active-eksklusif';
        document.getElementById('regName').style.color = 'var(--ink)';
        document.getElementById('regPrice').style.color = 'var(--ink-3)';
        document.getElementById('regBadge').style.cssText = 'background:#F1F5F9;color:var(--ink-3)';
        document.getElementById('eksName').style.color = 'var(--ink)';
        document.getElementById('eksPrice').style.color = 'var(--ink-3)';
        ts.style.display = 'none'; ts.required = false;
        ct.style.display = 'block'; ct.required = true;
        document.getElementById('summaryService').textContent = 'Eksklusif';
    }
    validateBookingTime();
    updateTotal();
}

function updateTotal() {
    const area = document.getElementById('areaSelect').value;
    const labels = { cilegon:'Cilegon', serang:'Serang', lainnya:'Luar Area' };
    const base = service === 'reguler' ? 300000 * pax : 600000;
    const fee  = area === 'lainnya' ? 100000 : 0;
    const total = base + fee;
    const fmt = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('total').textContent = fmt;
    document.getElementById('totalMobile').textContent = fmt;
    document.getElementById('paxEstimate').textContent = 'Rp ' + base.toLocaleString('id-ID');
    document.getElementById('summaryPax').textContent = service === 'eksklusif' ? pax + ' penumpang (Private)' : pax + ' orang';
    document.getElementById('summaryArea').textContent = labels[area] || '—';
    document.getElementById('extraFeeRow').style.display = fee ? 'flex' : 'none';
}

function validateBookingTime() {
    const wb   = document.getElementById('exclusiveWarning');
    const btn  = document.getElementById('bookingButton');
    const btnM = document.getElementById('bookingButtonMobile');
    wb.style.display = 'none';
    btn.disabled = false; btnM.disabled = false;
    const dateVal = document.getElementById('pickupDate').value;
    if (!dateVal) return;
    const now   = new Date();
    const today = now.toISOString().slice(0,10);
    if (dateVal !== today) return;
    const timeVal = service === 'reguler'
        ? document.getElementById('timeSelect').value
        : document.getElementById('customTime').value;
    if (!timeVal) return;
    const [h,m] = timeVal.split(':');
    const trip  = new Date(); trip.setHours(+h, +m, 0);
    if ((trip - now) / 3600000 < 3) {
        wb.style.display = 'block';
        btn.disabled = true; btnM.disabled = true;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('pickupDate').min = new Date().toISOString().split('T')[0];
    document.getElementById('pickupDate').addEventListener('change', validateBookingTime);
    document.getElementById('timeSelect').addEventListener('change', validateBookingTime);
    document.getElementById('customTime').addEventListener('input', validateBookingTime);
    document.getElementById('bookingForm').addEventListener('submit', e => {
        validateBookingTime();
        if (document.getElementById('bookingButton').disabled) {
            e.preventDefault();
            alert('Booking minimal 3 jam sebelum keberangkatan.');
            return;
        }
        const b  = document.getElementById('bookingButton');
        const bm = document.getElementById('bookingButtonMobile');
        b.disabled = true; bm.disabled = true;
        b.innerHTML  = '⏳ Memproses...';
        bm.innerHTML = '⏳ Loading...';
    });
    updateTotal();
    validateBookingTime();
});
</script>
</body>
</html>