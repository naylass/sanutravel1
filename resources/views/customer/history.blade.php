<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking — Sanu Travel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

<header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">

    <div class="max-w-2xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">

        <a href="/customer/dashboard"
           class="flex items-center gap-2 text-gray-500 hover:text-green-600 transition">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>

            </svg>

            <span class="text-sm font-medium">
                Kembali
            </span>

        </a>

        <span class="font-bold text-gray-800">
            Riwayat Booking
        </span>

        <form method="POST" action="/logout">

            @csrf

            <button type="submit"
                    onclick="return confirm('Yakin keluar?')"
                    class="text-xs text-gray-400 hover:text-red-500 transition font-medium py-1.5 px-2 rounded-xl hover:bg-red-50">

                Keluar

            </button>

        </form>

    </div>

</header>

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 space-y-4">

    {{-- ALERT --}}
    @if(session('success'))

    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-2xl text-sm font-medium">
        {{ session('success') }}
    </div>

    @endif

    {{-- KOSONG --}}
    @if($bookings->count() == 0)

    <div class="text-center py-16">

        <div class="text-5xl mb-4">
            📋
        </div>

        <div class="text-gray-400 font-medium mb-4">
            Belum ada riwayat booking
        </div>

        <a href="/customer/booking"
           class="bg-green-600 text-white text-sm font-bold px-6 py-3 rounded-2xl inline-block">

            Pesan Sekarang

        </a>

    </div>

    @else

    {{-- LOOP DATA --}}
    @foreach($bookings as $booking)

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- BAR --}}
        <div class="h-1.5
            {{ $booking->pickup_type == 'eksklusif'
                ? 'bg-gradient-to-r from-yellow-400 to-amber-500'
                : 'bg-gradient-to-r from-green-500 to-green-400' }}">
        </div>

        <div class="p-5">

            {{-- HEADER --}}
            <div class="flex items-start justify-between gap-3 mb-4">

                <div>

                    <p class="text-xs text-gray-400 mb-0.5">
                        Kode Booking
                    </p>

                    <p class="font-extrabold text-gray-900 text-base">
                        {{ $booking->booking_code }}
                    </p>

                </div>

                {{-- STATUS --}}
                @if($booking->status == 'pending')

<span class="text-xs font-bold px-3 py-1.5 rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
    ⏳ Menunggu
</span>

@elseif($booking->status == 'confirmed')

<span class="text-xs font-bold px-3 py-1.5 rounded-full bg-green-100 text-green-700 border border-green-200">
    ✅ Dikonfirmasi
</span>

@elseif($booking->status == 'cancel_request')

<span class="text-xs font-bold px-3 py-1.5 rounded-full bg-orange-100 text-orange-700 border border-orange-200">
    ⏳ Menunggu Persetujuan Cancel
</span>

@else

<span class="text-xs font-bold px-3 py-1.5 rounded-full bg-red-100 text-red-700 border border-red-200">
    ❌ Dibatalkan
</span>

@endif

            {{-- GRID --}}
            <div class="grid grid-cols-2 gap-2.5 mb-4">

                <div class="bg-gray-50 rounded-xl p-3">

                    <p class="text-xs text-gray-400 mb-0.5">
                        Penjemputan
                    </p>

                    <p class="font-semibold text-gray-700 text-xs">
                        {{ $booking->pickup_location }}
                    </p>

                </div>

                <div class="bg-gray-50 rounded-xl p-3">

                    <p class="text-xs text-gray-400 mb-0.5">
                        Tujuan
                    </p>

                    <p class="font-semibold text-gray-700 text-sm">
                        📍 {{ $booking->destination }}
                    </p>

                </div>

                <div class="bg-gray-50 rounded-xl p-3">

                    <p class="text-xs text-gray-400 mb-0.5">
                        Tanggal & Jam
                    </p>

                    <p class="font-semibold text-gray-700 text-xs">
                        {{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}
                        ·
                        {{ $booking->pickup_time }}
                    </p>

                </div>

                <div class="bg-gray-50 rounded-xl p-3">

                    <p class="text-xs text-gray-400 mb-0.5">
                        Total Harga
                    </p>

                    <p class="font-bold text-green-700 text-sm">
                        Rp {{ number_format($booking->price, 0, ',', '.') }}
                    </p>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between flex-wrap gap-2">

                <div class="flex items-center gap-2">

                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $booking->pickup_type == 'eksklusif'
                            ? 'bg-yellow-50 text-yellow-700'
                            : 'bg-green-50 text-green-700' }}">

                        {{ ucfirst($booking->pickup_type) }}

                    </span>

                    <span class="text-xs text-gray-400">
                        👤 {{ $booking->total_passengers }} orang
                    </span>

                </div>

                {{-- CANCEL --}}
                @if($booking->status == 'confirmed')

                <form method="POST"
                      action="{{ route('customer.booking.cancel', $booking->id) }}"
                      onsubmit="return confirm('Yakin ingin cancel booking ini?')">

                    @csrf
                    @method('PATCH')

                    <button type="submit"
                            class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition">

                        Ajukan Cancel

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