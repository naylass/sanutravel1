<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-bg { background: linear-gradient(145deg, #1e3a5f 0%, #2d5282 60%, #1a365d 100%); }
        @keyframes pop { 0% { transform: scale(0.7); opacity: 0; } 80% { transform: scale(1.05); } 100% { transform: scale(1); opacity: 1; } }
        .icon-pop { animation: pop 0.5s ease-out forwards; }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex items-start justify-center py-8 px-4">

<div class="w-full max-w-md">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">

        {{-- HERO TOP --}}
        <div class="hero-bg px-6 pt-12 pb-10 text-center text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-6 -translate-x-6"></div>

            <div class="icon-pop w-20 h-20 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full flex items-center justify-center mx-auto mb-5 text-4xl relative z-10">
                ✅
            </div>
            <h1 class="text-2xl font-extrabold mb-2 relative z-10">Booking Berhasil!</h1>
            <p class="text-blue-200 text-sm relative z-10">Terima kasih telah menggunakan layanan Sanu Travel</p>
        </div>

        {{-- BOOKING CODE --}}
        <div class="px-5 pt-5">
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 text-center">
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest mb-2">Kode Booking</p>
                <h2 class="text-2xl font-extrabold tracking-widest text-slate-800">{{ $booking->booking_code }}</h2>
            </div>
        </div>

        {{-- DETAIL --}}
        <div class="px-5 py-4 space-y-0 divide-y divide-slate-50">
            <div class="flex justify-between items-center py-3.5">
                <span class="text-slate-400 text-sm">Nama Customer</span>
                <span class="font-semibold text-slate-800 text-sm text-right max-w-[55%] truncate">{{ $booking->customer_name }}</span>
            </div>
            <div class="flex justify-between items-center py-3.5">
                <span class="text-slate-400 text-sm">Tujuan</span>
                <span class="font-semibold text-slate-800 text-sm text-right max-w-[55%]">{{ $booking->destination }}</span>
            </div>
            <div class="flex justify-between items-center py-3.5">
                <span class="text-slate-400 text-sm">Tanggal</span>
                <span class="font-semibold text-slate-800 text-sm">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between items-center py-3.5">
                <span class="text-slate-400 text-sm">Jam</span>
                <span class="font-semibold text-slate-800 text-sm">{{ substr($booking->pickup_time, 0, 5) }}</span>
            </div>
            <div class="flex justify-between items-center py-3.5">
                <span class="text-slate-400 text-sm">Jumlah Penumpang</span>
                <span class="font-semibold text-slate-800 text-sm">{{ $booking->total_passengers }} Orang</span>
            </div>
        </div>

        {{-- TOTAL --}}
        <div class="px-5 pb-2">
            <div class="bg-slate-800 rounded-2xl px-5 py-4 flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-medium mb-1">Total Pembayaran</p>
                    <h2 class="text-2xl font-extrabold text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h2>
                </div>
                <div class="text-4xl opacity-70">💳</div>
            </div>
        </div>

        {{-- WARNING --}}
        <div class="px-5 py-4">
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex gap-3">
                <span class="text-xl flex-shrink-0">⚠️</span>
                <div>
                    <p class="font-bold text-amber-800 text-sm mb-0.5">Menunggu Pembayaran</p>
                    <p class="text-amber-700 text-xs leading-relaxed">Silakan lakukan pembayaran agar booking Anda segera diproses oleh admin.</p>
                </div>
            </div>
        </div>

        {{-- ACTIONS --}}
        <div class="px-5 pb-7 space-y-3">
            <a href="{{ route('payment.check') }}"
               class="w-full bg-slate-800 hover:bg-slate-700 text-white py-4 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition">
                💳 Bayar Sekarang
            </a>
            <a href="{{ route('tracking') }}"
               class="w-full border border-slate-200 hover:border-slate-300 text-slate-700 py-4 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition bg-white">
                📋 Cek Booking
            </a>
            <a href="/" class="w-full text-center block text-sm text-slate-400 hover:text-slate-600 pt-1 transition">
                ← Kembali ke Beranda
            </a>
        </div>

    </div>
</div>

</body>
</html>