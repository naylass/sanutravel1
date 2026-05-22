<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Collection — Sanu Travel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #2563EB; --brand-light: #3B82F6;
            --accent: #06B6D4;
            --amber: #F59E0B; --amber-light: #FCD34D;
            --green: #10B981;
            --ink: #0F172A; --ink-2: #334155; --ink-3: #64748B; --ink-4: #94A3B8;
            --border: #E2E8F0; --surface: #F8FAFC;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--surface); color: var(--ink); min-height: 100vh; padding-bottom: 7rem; }

        /* ── NAV ── */
        .nav { background: rgba(6,13,26,.9); backdrop-filter: blur(24px); border-bottom: 1px solid rgba(255,255,255,.06); position: sticky; top: 0; z-index: 100; }
        .nav-inner { max-width: 1000px; margin: 0 auto; padding: 0 1.5rem; height: 60px; display: flex; align-items: center; justify-content: space-between; }
        .nav-back { display: flex; align-items: center; gap: .45rem; color: rgba(255,255,255,.5); font-size: 13px; font-weight: 600; text-decoration: none; transition: color .2s; }
        .nav-back:hover { color: #fff; }
        .nav-brand { display: flex; align-items: center; gap: .6rem; text-decoration: none; }
        .nav-logo { width: 30px; height: 30px; border-radius: 8px; background: linear-gradient(135deg,var(--accent),var(--brand)); display: flex; align-items: center; justify-content: center; font-size: 14px; }
        .nav-title { font-size: 14px; font-weight: 800; color: #fff; letter-spacing: -.01em; }
        .nav-tag { font-size: 12px; font-weight: 700; color: rgba(255,255,255,.4); background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08); padding: .28rem .7rem; border-radius: 100px; }

        /* ── PAGE HERO ── */
        .page-hero {
            background: linear-gradient(145deg, #060D1A, #0C1D3A 55%, #091528);
            position: relative; overflow: hidden; padding: 2rem 0;
        }
        .hero-grid-bg { position: absolute; inset: 0; pointer-events: none; opacity: .03; background-image: linear-gradient(var(--border) 1px,transparent 1px), linear-gradient(90deg,var(--border) 1px,transparent 1px); background-size: 48px 48px; }
        .hero-glow-amber { position: absolute; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle,rgba(245,158,11,.14),transparent 65%); top: -180px; right: -80px; pointer-events: none; }
        .hero-glow-blue { position: absolute; width: 300px; height: 300px; border-radius: 50%; background: radial-gradient(circle,rgba(37,99,235,.1),transparent 65%); bottom: -100px; left: -50px; pointer-events: none; }
        .hero-inner { max-width: 1000px; margin: 0 auto; padding: 0 1.5rem; position: relative; z-index: 5; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: .4rem; background: rgba(245,158,11,.12); border: 1px solid rgba(245,158,11,.25); border-radius: 100px; padding: .28rem .8rem; font-size: 10.5px; font-weight: 700; color: #FCD34D; letter-spacing: .07em; text-transform: uppercase; margin-bottom: .7rem; }
        .hero-title { font-size: clamp(1.4rem,3.5vw,1.9rem); font-weight: 800; color: #fff; letter-spacing: -.03em; margin-bottom: .3rem; }
        .hero-title span { color: #FCD34D; }
        .hero-sub { font-size: 13px; color: rgba(148,163,184,.6); }
        .hero-count { background: rgba(245,158,11,.1); border: 1px solid rgba(245,158,11,.2); border-radius: 18px; padding: 1rem 1.4rem; text-align: center; flex-shrink: 0; }
        .hero-count-num { font-size: 2rem; font-weight: 800; line-height: 1; background: linear-gradient(135deg,#FCD34D,#F59E0B); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .hero-count-label { font-size: 10.5px; color: rgba(148,163,184,.5); margin-top: .25rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; }

        /* ── CONTENT WRAP ── */
        .content-wrap { max-width: 1000px; margin: 0 auto; padding: 1.75rem 1.5rem 0; }

        /* ALERT */
        .alert-success { background: #F0FDF4; border: 1.5px solid #BBF7D0; border-radius: 14px; padding: .85rem 1.1rem; display: flex; align-items: center; gap: .65rem; font-size: 13px; font-weight: 600; color: #15803D; margin-bottom: 1.25rem; }

        /* ── CARDS GRID ── */
        .cards-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }

        /* ── PAYMENT CARD ── */
        .payment-card { background: #fff; border-radius: 22px; border: 1.5px solid var(--border); overflow: hidden; box-shadow: 0 4px 20px rgba(15,23,42,.07); display: flex; flex-direction: column; transition: transform .22s, box-shadow .22s; }
        .payment-card:hover { transform: translateY(-3px); box-shadow: 0 14px 40px rgba(15,23,42,.13); }
        .card-top-bar { height: 3px; background: linear-gradient(90deg,#F59E0B,#FBBF24); }

        /* CARD HEADER */
        .card-hd { background: linear-gradient(145deg,#0A1628,#152038); padding: 1.1rem 1.25rem; display: flex; justify-content: space-between; align-items: flex-start; gap: .75rem; }
        .card-code-lbl { font-size: 10px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: rgba(148,163,184,.4); margin-bottom: .3rem; }
        .card-booking-code { font-size: 1.1rem; font-weight: 800; letter-spacing: .08em; background: linear-gradient(135deg,#fff 30%,#FCD34D); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-customer { font-size: 12px; color: rgba(148,163,184,.5); margin-top: .2rem; }
        .card-badge { display: inline-flex; align-items: center; gap: .3rem; background: rgba(245,158,11,.15); border: 1px solid rgba(245,158,11,.25); border-radius: 100px; padding: .35rem .8rem; font-size: 11px; font-weight: 700; color: #FCD34D; white-space: nowrap; flex-shrink: 0; }

        /* CARD BODY */
        .card-bd { padding: 1.1rem 1.25rem; flex: 1; display: flex; flex-direction: column; }

        /* DETAIL ROW */
        .detail-row { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; margin-bottom: 1rem; }
        .detail-cell { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: .8rem .95rem; }
        .detail-cell-lbl { font-size: 10.5px; color: var(--ink-4); font-weight: 600; margin-bottom: .25rem; }
        .detail-cell-val { font-size: 13px; font-weight: 700; color: var(--ink-2); line-height: 1.35; }
        .detail-cell-val.amount { font-size: 14.5px; background: linear-gradient(135deg,var(--ink),#334155); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* DIVIDER */
        .card-div { height: 1px; background: var(--border); margin-bottom: 1rem; }

        /* UPLOAD */
        .upload-label { font-size: 11.5px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: var(--ink-3); margin-bottom: .5rem; display: block; }
        .file-drop { border: 2px dashed var(--border); border-radius: 14px; padding: 1.5rem 1rem; text-align: center; cursor: pointer; background: var(--surface); transition: all .2s; margin-bottom: .85rem; }
        .file-drop:hover { border-color: var(--amber); background: #FFFBEB; }
        .file-drop-icon { font-size: 1.6rem; margin-bottom: .4rem; }
        .file-drop-name { font-size: 13px; font-weight: 600; color: var(--ink-3); }
        .file-drop-hint { font-size: 11.5px; color: var(--ink-4); margin-top: .25rem; }

        /* BTN */
        .btn-confirm { width: 100%; background: linear-gradient(135deg,#0A1628,#1E293B); color: #fff; border: none; border-radius: 12px; padding: .85rem; font-size: 13.5px; font-weight: 700; font-family: 'Plus Jakarta Sans',sans-serif; cursor: pointer; box-shadow: 0 4px 16px rgba(15,23,42,.2); transition: all .2s; display: flex; align-items: center; justify-content: center; gap: .5rem; margin-top: auto; }
        .btn-confirm:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(15,23,42,.3); }

        /* EMPTY */
        .empty-wrap { grid-column: 1/-1; }
        .empty-card { background: #fff; border-radius: 24px; border: 1.5px solid var(--border); text-align: center; padding: 4rem 2rem; box-shadow: 0 4px 20px rgba(15,23,42,.05); }
        .empty-icon { width: 80px; height: 80px; background: #FFFBEB; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; font-size: 2.2rem; }
        .empty-title { font-size: 1.05rem; font-weight: 800; color: var(--ink-2); margin-bottom: .4rem; }
        .empty-sub { font-size: 13px; color: var(--ink-4); }

        /* ── BOTTOM NAV ── */
        .bottom-nav { position: fixed; bottom: 1rem; left: 50%; transform: translateX(-50%); width: calc(100% - 2rem); max-width: 420px; z-index: 100; }
        .bottom-nav-inner { background: rgba(255,255,255,.92); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,.8); box-shadow: 0 8px 32px rgba(15,23,42,.14); border-radius: 24px; padding: .65rem .75rem; display: flex; align-items: center; }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: .2rem; padding: .55rem .75rem; border-radius: 16px; text-decoration: none; transition: background .2s; flex: 1; }
        .nav-item.active { background: linear-gradient(135deg,#0A1628,#1E293B); }
        .nav-item-icon { font-size: 1.1rem; }
        .nav-item-label { font-size: 11px; font-weight: 700; }
        .nav-item.active .nav-item-label { color: #fff; }
        .nav-item:not(.active) .nav-item-label { color: var(--ink-4); }
        .nav-item:not(.active):hover { background: var(--surface); }

        /* ── RESPONSIVE ── */
        @media (max-width: 700px) {
            .cards-grid { grid-template-columns: 1fr; }
            .hero-inner { flex-direction: column; align-items: flex-start; }
            .hero-count { align-self: flex-start; display: flex; align-items: center; gap: .75rem; text-align: left; }
        }
        @media (max-width: 540px) {
            .nav-inner { padding: 0 1rem; }
            .hero-inner { padding: 0 1rem; }
            .content-wrap { padding: 1.25rem 1rem 0; }
        }
    </style>
</head>
<body>

<nav class="nav">
    <div class="nav-inner">
        <a href="/driver/dashboard" class="nav-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
        <div class="nav-brand">
            <div class="nav-logo">✈️</div>
            <span class="nav-title">Sanu Travel</span>
        </div>
        <span class="nav-tag">Cash</span>
    </div>
</nav>

<div class="page-hero">
    <div class="hero-grid-bg"></div>
    <div class="hero-glow-amber"></div>
    <div class="hero-glow-blue"></div>
    <div class="hero-inner">
        <div>
            <div class="hero-eyebrow">💰 Konfirmasi Pembayaran</div>
            <h1 class="hero-title">Cash <span>Collection</span></h1>
            <p class="hero-sub">Upload bukti penerimaan cash dari customer</p>
        </div>
        <div class="hero-count">
            <div class="hero-count-num">{{ $payments->count() }}</div>
            <div class="hero-count-label">Menunggu</div>
        </div>
    </div>
</div>

<div class="content-wrap">

    @if(session('success'))
    <div class="alert-success">
        <span>✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="cards-grid">

        @forelse($payments as $payment)
        <div class="payment-card">
            <div class="card-top-bar"></div>

            <div class="card-hd">
                <div style="min-width:0">
                    <div class="card-code-lbl">Kode Booking</div>
                    <div class="card-booking-code">{{ $payment->booking->booking_code }}</div>
                    <div class="card-customer">{{ $payment->booking->customer_name }}</div>
                </div>
                <div class="card-badge">⏳ Waiting Cash</div>
            </div>

            <div class="card-bd">
                <div class="detail-row">
                    <div class="detail-cell">
                        <div class="detail-cell-lbl">🏁 Tujuan</div>
                        <div class="detail-cell-val">{{ $payment->booking->destination }}</div>
                    </div>
                    <div class="detail-cell">
                        <div class="detail-cell-lbl">💵 Total Cash</div>
                        <div class="detail-cell-val amount">Rp {{ number_format($payment->amount,0,',','.') }}</div>
                    </div>
                </div>

                <div class="card-div"></div>

                <form method="POST" action="{{ route('driver.payment.receive', $payment->id) }}" enctype="multipart/form-data" style="display:flex;flex-direction:column;flex:1">
                    @csrf
                    <span class="upload-label">Upload Bukti Cash</span>
                    <div class="file-drop" onclick="document.getElementById('proof_{{ $payment->id }}').click()">
                        <div class="file-drop-icon" id="icon_{{ $payment->id }}">📁</div>
                        <div class="file-drop-name" id="name_{{ $payment->id }}">Klik untuk upload foto bukti</div>
                        <div class="file-drop-hint">JPG, PNG — maks 5MB</div>
                        <img id="prev_{{ $payment->id }}" style="display:none;margin:1rem auto 0;border-radius:10px;max-height:150px;object-fit:contain;">
                    </div>
                    <input type="file" id="proof_{{ $payment->id }}" name="driver_proof" style="display:none;" accept="image/*" required onchange="previewProof(this,{{ $payment->id }})">
                    <button type="submit" class="btn-confirm">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Sudah Terima Cash
                    </button>
                </form>
            </div>
        </div>

        @empty
        <div class="empty-wrap">
            <div class="empty-card">
                <div class="empty-icon">💰</div>
                <h2 class="empty-title">Tidak Ada Cash Collection</h2>
                <p class="empty-sub">Belum ada pembayaran cash yang perlu dikonfirmasi</p>
            </div>
        </div>
        @endforelse

    </div>
</div>

<div class="bottom-nav">
    <div class="bottom-nav-inner">
        <a href="/driver/dashboard" class="nav-item">
            <span class="nav-item-icon">🏠</span>
            <span class="nav-item-label">Home</span>
        </a>
        <a href="/driver/delivery" class="nav-item">
            <span class="nav-item-icon">🚐</span>
            <span class="nav-item-label">Delivery</span>
        </a>
        <a href="/driver/payments" class="nav-item active">
            <span class="nav-item-icon">💰</span>
            <span class="nav-item-label">Payment</span>
        </a>
    </div>
</div>

<script>
function previewProof(input, id) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('prev_' + id).src = e.target.result;
        document.getElementById('prev_' + id).style.display = 'block';
        document.getElementById('name_' + id).innerText = file.name;
        document.getElementById('icon_' + id).innerText = '🖼️';
    };
    reader.readAsDataURL(file);
}
</script>
</body>
</html>