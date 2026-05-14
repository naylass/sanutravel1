<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanu Travel — Booking Mudah & Cepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-bg { background: linear-gradient(145deg, #0f172a 0%, #1e3a5f 55%, #0f2340 100%); }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:active { transform: scale(0.97); }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fadeUp 0.6s ease-out forwards; }
        .fade-up-2 { animation: fadeUp 0.6s 0.15s ease-out both; }
        .fade-up-3 { animation: fadeUp 0.6s 0.30s ease-out both; }
    </style>
</head>

<body class="bg-slate-100 pb-20 sm:pb-0">

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-sm z-50">
    <div class="max-w-6xl mx-auto px-5 h-16 flex justify-between items-center">

        <a href="/" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-slate-800 rounded-xl flex items-center justify-center text-sm">🚐</div>
            <span class="font-extrabold text-slate-800 text-base tracking-tight">SanuTravel</span>
        </a>

        <div class="hidden md:flex items-center gap-6 text-sm font-semibold">
            <a href="#layanan" class="text-slate-500 hover:text-slate-800 transition">Layanan</a>
            <a href="/tracking" class="text-slate-500 hover:text-slate-800 transition">Cek Status</a>
            <a href="/payment/check" class="text-slate-500 hover:text-slate-800 transition">Pembayaran</a>
        </div>

        <a href="/booking/create"
           class="bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-2xl text-sm font-bold transition">
            Pesan Sekarang
        </a>

    </div>
</nav>

{{-- HERO --}}
<section class="hero-bg text-white pt-28 pb-20 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full -translate-y-32 translate-x-32 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500/10 rounded-full translate-y-20 -translate-x-20 blur-3xl pointer-events-none"></div>

    <div class="max-w-3xl mx-auto px-5 text-center relative z-10">

        <div class="fade-up inline-block bg-white/10 border border-white/20 text-xs font-bold px-4 py-1.5 rounded-full mb-5 text-blue-200">
            ✈️ Travel Premium Terpercaya
        </div>

        <h1 class="fade-up text-4xl sm:text-5xl font-extrabold leading-tight mb-5 tracking-tight">
            Perjalanan Aman<br>& <span class="text-blue-300">Nyaman</span>
        </h1>

        <p class="fade-up-2 text-slate-300 text-base leading-relaxed max-w-lg mx-auto mb-10">
            Booking travel tanpa ribet. Tanpa login. Tanpa registrasi.<br>
            Cukup isi form dan langsung berangkat.
        </p>

        <div class="fade-up-3 flex flex-wrap justify-center gap-3">
            <a href="/booking/create"
               class="card-hover bg-white text-slate-800 px-6 py-3.5 rounded-2xl font-extrabold text-sm shadow-xl shadow-black/20 transition">
                🚐 Pesan Sekarang
            </a>
            <a href="/tracking"
               class="card-hover bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-3.5 rounded-2xl font-bold text-sm transition">
                📋 Cek Status
            </a>
            <a href="/payment/check"
               class="card-hover bg-white/10 hover:bg-white/20 border border-white/20 text-white px-6 py-3.5 rounded-2xl font-bold text-sm transition">
                💳 Pembayaran
            </a>
        </div>

    </div>
</section>

{{-- QUICK STATS --}}
<div class="max-w-4xl mx-auto px-4 -mt-6 relative z-20">
    <div class="bg-white rounded-3xl shadow-md border border-slate-100 grid grid-cols-3 divide-x divide-slate-100 overflow-hidden">
        <div class="py-5 px-4 text-center">
            <div class="text-xl mb-1">🚀</div>
            <p class="font-bold text-slate-700 text-sm">Cepat</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-tight hidden sm:block">Konfirmasi dalam menit</p>
        </div>
        <div class="py-5 px-4 text-center">
            <div class="text-xl mb-1">🛡️</div>
            <p class="font-bold text-slate-700 text-sm">Aman</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-tight hidden sm:block">Driver terverifikasi</p>
        </div>
        <div class="py-5 px-4 text-center">
            <div class="text-xl mb-1">💳</div>
            <p class="font-bold text-slate-700 text-sm">Fleksibel</p>
            <p class="text-xs text-slate-400 mt-0.5 leading-tight hidden sm:block">QRIS, Transfer, Cash</p>
        </div>
    </div>
</div>

{{-- LAYANAN --}}
<section id="layanan" class="max-w-4xl mx-auto px-4 py-14">

    <div class="text-center mb-8">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Pilihan Layanan</p>
        <h2 class="text-2xl font-extrabold text-slate-800">Layanan Kami</h2>
    </div>

    <div class="grid sm:grid-cols-2 gap-4">

        {{-- REGULER --}}
        <div class="card-hover bg-slate-800 text-white rounded-3xl p-6 shadow-md">
            <div class="flex justify-between items-start mb-5">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-2xl">🚐</div>
                <span class="bg-white/15 text-white text-xs font-bold px-3 py-1 rounded-full">Populer</span>
            </div>
            <h3 class="font-extrabold text-xl mb-1">Reguler</h3>
            <p class="text-slate-300 text-sm leading-relaxed mb-5">Cocok untuk perjalanan hemat dan sharing penumpang. Nyaman dan terjangkau.</p>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs text-slate-400 mb-0.5">Mulai dari</p>
                    <p class="text-xl font-extrabold">Rp 300.000 <span class="text-sm font-normal text-slate-400">/ orang</span></p>
                </div>
                <a href="/booking/create" class="bg-white text-slate-800 text-xs font-bold px-4 py-2.5 rounded-2xl hover:bg-slate-100 transition">
                    Pesan →
                </a>
            </div>
        </div>

        {{-- EKSKLUSIF --}}
        <div class="card-hover bg-white border border-amber-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-start mb-5">
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-2xl">✨</div>
                <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">Premium</span>
            </div>
            <h3 class="font-extrabold text-xl text-slate-800 mb-1">Eksklusif</h3>
            <p class="text-slate-400 text-sm leading-relaxed mb-5">Private travel, bebas pilih jam sendiri, lebih privat dan nyaman.</p>
            <div class="flex items-end justify-between">
                <div>
                    <p class="text-xs text-slate-400 mb-0.5">Harga flat</p>
                    <p class="text-xl font-extrabold text-slate-800">Rp 600.000 <span class="text-sm font-normal text-slate-400">/ trip</span></p>
                </div>
                <a href="/booking/create" class="bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-2xl hover:bg-slate-700 transition">
                    Pesan →
                </a>
            </div>
        </div>

    </div>

</section>

{{-- CARA PESAN --}}
<section class="bg-white py-14">
    <div class="max-w-4xl mx-auto px-4">

        <div class="text-center mb-8">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Mudah & Cepat</p>
            <h2 class="text-2xl font-extrabold text-slate-800">Cara Pemesanan</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-5 text-center relative">
                <div class="absolute -top-3 -left-1 w-7 h-7 bg-slate-800 text-white text-xs font-extrabold rounded-full flex items-center justify-center">1</div>
                <div class="text-3xl mb-3">📝</div>
                <p class="font-bold text-slate-700 text-sm mb-1">Isi Form</p>
                <p class="text-xs text-slate-400 leading-relaxed">Masukkan data perjalanan</p>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-5 text-center relative">
                <div class="absolute -top-3 -left-1 w-7 h-7 bg-slate-800 text-white text-xs font-extrabold rounded-full flex items-center justify-center">2</div>
                <div class="text-3xl mb-3">🎫</div>
                <p class="font-bold text-slate-700 text-sm mb-1">Dapat Kode</p>
                <p class="text-xs text-slate-400 leading-relaxed">Booking code otomatis</p>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-5 text-center relative">
                <div class="absolute -top-3 -left-1 w-7 h-7 bg-slate-800 text-white text-xs font-extrabold rounded-full flex items-center justify-center">3</div>
                <div class="text-3xl mb-3">💳</div>
                <p class="font-bold text-slate-700 text-sm mb-1">Pembayaran</p>
                <p class="text-xs text-slate-400 leading-relaxed">QRIS atau Cash</p>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-5 text-center relative">
                <div class="absolute -top-3 -left-1 w-7 h-7 bg-slate-800 text-white text-xs font-extrabold rounded-full flex items-center justify-center">4</div>
                <div class="text-3xl mb-3">🚐</div>
                <p class="font-bold text-slate-700 text-sm mb-1">Berangkat</p>
                <p class="text-xs text-slate-400 leading-relaxed">Tinggal tunggu jadwal</p>
            </div>
        </div>

    </div>
</section>

{{-- WHY US --}}
<section class="max-w-4xl mx-auto px-4 py-14">
    <div class="text-center mb-8">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Keunggulan</p>
        <h2 class="text-2xl font-extrabold text-slate-800">Mengapa Sanu Travel?</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 divide-y divide-slate-50">
        <div class="flex items-center gap-4 px-5 py-4">
            <div class="w-11 h-11 bg-slate-50 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">🛡️</div>
            <div>
                <p class="font-bold text-slate-700 text-sm">Terpercaya & Aman</p>
                <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">Driver berpengalaman dengan rekam jejak terbaik dan terverifikasi</p>
            </div>
        </div>
        <div class="flex items-center gap-4 px-5 py-4">
            <div class="w-11 h-11 bg-slate-50 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">📍</div>
            <div>
                <p class="font-bold text-slate-700 text-sm">Door-to-Door</p>
                <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">Dijemput langsung dari rumah hingga tiba di tujuan</p>
            </div>
        </div>
        <div class="flex items-center gap-4 px-5 py-4">
            <div class="w-11 h-11 bg-slate-50 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">💳</div>
            <div>
                <p class="font-bold text-slate-700 text-sm">Pembayaran Fleksibel</p>
                <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">Bayar via QRIS, transfer bank, atau cash langsung ke driver</p>
            </div>
        </div>
        <div class="flex items-center gap-4 px-5 py-4">
            <div class="w-11 h-11 bg-slate-50 rounded-2xl flex items-center justify-center text-xl flex-shrink-0">📲</div>
            <div>
                <p class="font-bold text-slate-700 text-sm">Booking Mudah</p>
                <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">Pesan kapan saja, tanpa akun, konfirmasi cepat dari admin</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA BOOKING --}}
<section id="booking" class="max-w-4xl mx-auto px-4 pb-14">
    <div class="hero-bg rounded-3xl px-6 py-12 text-center text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-16 translate-x-16 blur-2xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-36 h-36 bg-white/5 rounded-full translate-y-10 -translate-x-10 blur-2xl pointer-events-none"></div>

        <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mb-3 relative z-10">Mulai Sekarang</p>
        <h2 class="text-2xl font-extrabold mb-3 relative z-10">Mulai Booking Sekarang</h2>
        <p class="text-slate-300 text-sm mb-7 max-w-sm mx-auto leading-relaxed relative z-10">
            Tidak perlu akun. Langsung isi data perjalanan Anda dan berangkat!
        </p>
        <a href="/booking/create"
           class="card-hover inline-block bg-white text-slate-800 px-8 py-3.5 rounded-2xl font-extrabold text-sm shadow-xl shadow-black/20 relative z-10 transition">
            🚐 Pesan Sekarang
        </a>
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-slate-900 text-white py-8">
    <div class="max-w-4xl mx-auto px-5 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-white/10 rounded-xl flex items-center justify-center text-sm">🚐</div>
            <span class="font-extrabold text-sm">SanuTravel</span>
        </div>
        <p class="text-slate-400 text-xs">© {{ date('Y') }} Sanu Travel. Semua Hak Dilindungi.</p>
        <div class="flex gap-5 text-xs font-semibold">
            <a href="#layanan" class="text-slate-400 hover:text-white transition">Layanan</a>
            <a href="/tracking" class="text-slate-400 hover:text-white transition">Cek Status</a>
            <a href="/payment/check" class="text-slate-400 hover:text-white transition">Pembayaran</a>
        </div>
    </div>
</footer>

{{-- STICKY MOBILE CTA --}}
<div class="fixed bottom-0 left-0 right-0 p-4 bg-white/90 backdrop-blur-md border-t border-slate-100 z-50 sm:hidden">
    <a href="/booking/create"
       class="block w-full bg-slate-800 hover:bg-slate-700 text-white py-4 rounded-2xl font-extrabold text-sm text-center transition">
        🚐 Pesan Sekarang
    </a>
</div>

</body>
</html>