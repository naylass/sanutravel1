<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Booking — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        input:focus { outline: none; }
    </style>
</head>

<body class="bg-slate-100 min-h-screen pb-10">

{{-- STICKY HEADER --}}
<header class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2 text-slate-500 hover:text-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="text-sm font-semibold">Beranda</span>
        </a>
        <span class="font-bold text-slate-800">Cek Booking</span>
        <div class="w-16"></div>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 py-6 space-y-5">

    {{-- SUCCESS FLASH --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3.5 flex items-center gap-3">
        <span class="text-xl">✅</span>
        <p class="text-emerald-700 font-semibold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- FORM TRACKING --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
        <h2 class="text-base font-bold text-slate-800 mb-4">Lacak Booking</h2>
        <form method="GET" action="{{ route('tracking') }}" class="space-y-3">
            <div>
                <label class="text-sm font-semibold text-slate-600 block mb-1.5">Kode Booking</label>
                <input type="text" name="booking_code" value="{{ request('booking_code') }}"
                       placeholder="BOOK-XXXXXXX"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-600 block mb-1.5">Nomor WhatsApp</label>
                <input type="text" name="phone_number" value="{{ request('phone_number') }}"
                       placeholder="628xxxxxxxxxx"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
            <button type="submit"
                    class="w-full bg-slate-800 hover:bg-slate-700 active:scale-98 text-white py-4 rounded-2xl font-bold text-sm transition-all">
                🔍 Cek Booking
            </button>
        </form>
    </div>

    {{-- EMPTY STATE --}}
    @if(request()->filled('booking_code') && $bookings->count() == 0)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 text-center py-16 px-6">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-4xl">📋</div>
        <h3 class="font-bold text-slate-700 text-lg mb-2">Booking Tidak Ditemukan</h3>
        <p class="text-slate-400 text-sm mb-6">Pastikan kode booking dan nomor WhatsApp benar.</p>
        <a href="/booking/create"
           class="inline-block bg-slate-800 hover:bg-slate-700 text-white text-sm font-bold px-6 py-3.5 rounded-2xl transition">
            Pesan Sekarang →
        </a>
    </div>

    @else

    @foreach($bookings as $booking)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- TOP COLOR BAR --}}
        <div class="h-1.5
            {{ strtolower($booking->service?->name ?? '') == 'eksklusif'
                ? 'bg-gradient-to-r from-amber-400 to-orange-400'
                : 'bg-gradient-to-r from-slate-500 to-slate-400' }}">
        </div>

        <div class="p-5">

            {{-- HEADER --}}
            <div class="flex items-start justify-between gap-3 mb-5">
                <div>
                    <p class="text-xs text-slate-400 mb-1 font-medium">Kode Booking</p>
                    <p class="font-extrabold text-slate-900 text-lg tracking-wide">{{ $booking->booking_code }}</p>
                </div>

                {{-- STATUS BADGE --}}
                @if($booking->status == 'pending')
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-amber-50 text-amber-600 border border-amber-100">⏳ Pending</span>
                @elseif($booking->status == 'confirmed')
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 border border-blue-100">✅ Confirmed</span>
                @elseif($booking->status == 'completed')
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">🚐 Selesai</span>
                @elseif($booking->status == 'cancel_request')
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-orange-50 text-orange-600 border border-orange-100">⏳ Menunggu Cancel</span>
                @else
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-red-50 text-red-600 border border-red-100">❌ Dibatalkan</span>
                @endif
            </div>

            {{-- DETAIL --}}
            <div class="grid grid-cols-2 gap-2.5 mb-5">
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Customer</p>
                    <p class="font-semibold text-slate-700 text-sm">👤 {{ $booking->customer_name }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Nomor HP</p>
                    <p class="font-semibold text-slate-700 text-sm">📞 {{ $booking->phone_number }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Penjemputan</p>
                    <p class="font-semibold text-slate-700 text-xs leading-snug">📍 {{ $booking->pickup_location }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Tujuan</p>
                    <p class="font-semibold text-slate-700 text-sm">🚩 {{ $booking->destination }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Jadwal</p>
                    <p class="font-semibold text-slate-700 text-xs">
                        🗓 {{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }} · {{ substr($booking->pickup_time, 0, 5) }}
                    </p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Penumpang</p>
                    <p class="font-semibold text-slate-700 text-sm">👥 {{ $booking->total_passengers }} Orang</p>
                </div>
            </div>

            {{-- PAYMENT --}}
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 mb-5">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Status Pembayaran</p>
                        @if(optional($booking->payment)->status == 'waiting')
                        <p class="font-bold text-amber-600 text-sm">⏳ Menunggu Verifikasi</p>
                        @elseif(optional($booking->payment)->status == 'verified')
                        <p class="font-bold text-emerald-600 text-sm">✅ Pembayaran Verified</p>
                        @elseif(optional($booking->payment)->status == 'rejected')
                        <p class="font-bold text-red-600 text-sm">❌ Pembayaran Ditolak</p>
                        @else
                        <p class="font-bold text-red-500 text-sm">❌ Belum Dibayar</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400 mb-1">Metode</p>
                        <p class="font-semibold text-slate-700 text-sm">
                            @if(optional($booking->payment)->method == 'transfer')
                                💳 QRIS / Transfer
                            @elseif(optional($booking->payment)->method == 'cash')
                                💵 Cash
                            @else
                                —
                            @endif
                        </p>
                    </div>
                </div>

                @if(optional($booking->payment)->payment_date)
                <div class="mb-3 pt-3 border-t border-slate-200">
                    <p class="text-xs text-slate-400 mb-1">Tanggal Pembayaran</p>
                    <p class="text-sm font-semibold text-slate-700">
                        🗓 {{ \Carbon\Carbon::parse($booking->payment->payment_date)->format('d M Y H:i') }}
                    </p>
                </div>
                @endif

                @if(optional($booking->payment)->proof_image)
                <a href="{{ asset('storage/' . $booking->payment->proof_image) }}" target="_blank"
                   class="text-sm text-blue-600 hover:underline font-medium">
                    📎 Lihat Bukti Pembayaran
                </a>
                @endif
            </div>

            {{-- TOTAL + CANCEL --}}
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-extrabold text-slate-800">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </p>
                </div>

                @if($booking->status == 'pending' || $booking->status == 'confirmed')
                <form method="POST"
                      action="{{ route('booking.cancel', $booking->id) }}"
                      onsubmit="return confirm('Yakin ingin cancel booking ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="bg-red-50 hover:bg-red-100 active:scale-95 text-red-600 border border-red-200 text-xs font-bold px-4 py-3 rounded-2xl transition">
                        ❌ Ajukan Cancel
                    </button>
                </form>
                @endif
            </div>

        </div>
    </div>
    @endforeach
    @endif

</div>

</body>
</html>