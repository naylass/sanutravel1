<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

<body class="bg-gray-50 min-h-screen">

@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Booking;
    use App\Models\Payment;

    $user = Auth::user();

    $lastBooking = Booking::where('user_id', $user->id)
        ->latest()
        ->first();

    $totalBooking = Booking::where('user_id', $user->id)->count();

    $totalSpend = Payment::whereHas('booking', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->sum('amount');
@endphp

{{-- HEADER --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">

        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-green-600 rounded-xl flex items-center justify-center shadow">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </div>
            <span class="font-extrabold text-green-700">Sanu<span class="text-gray-800">Travel</span></span>
        </div>

        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="text-sm text-red-500 font-medium">Keluar</button>
        </form>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 space-y-5">

    {{-- GREETING --}}
    <div class="bg-gradient-to-r from-green-700 to-green-500 rounded-3xl p-6 text-white shadow-lg">
        <p class="text-green-100 text-sm">👋 Selamat datang kembali,</p>
        <h2 class="text-2xl font-extrabold mb-2">{{ $user->name }}</h2>
        <span class="text-xs bg-white/20 px-3 py-1 rounded-full">{{ $user->email }}</span>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 gap-4">

        <div class="bg-white rounded-2xl p-5 shadow-sm border">
            <div class="text-2xl font-extrabold">{{ $totalBooking }}</div>
            <div class="text-sm text-gray-500">Total Booking</div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border">
            <div class="text-2xl font-extrabold">
                Rp {{ number_format($totalSpend ?? 0, 0, ',', '.') }}
            </div>
            <div class="text-sm text-gray-500">Total Pengeluaran</div>
        </div>

    </div>

    {{-- LAST BOOKING --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border">

        <h3 class="font-bold mb-3">Booking Terakhir</h3>

        @if($lastBooking)
            <p class="font-bold text-gray-900">
                {{ $lastBooking->code ?? $lastBooking->id }}
            </p>

            <p class="text-sm text-gray-500">
                Tujuan: {{ $lastBooking->destination ?? '-' }}
            </p>

            @php
                $status = $lastBooking->status ?? 'pending';

                $badgeClass = match($lastBooking['status']) {
                    'confirmed' => 'bg-green-100 text-green-700',
                    'pending'   => 'bg-yellow-100 text-yellow-700',
                    'cancelled' => 'bg-red-100 text-red-600',
                    default     => 'bg-gray-100 text-gray-600',
                };

                $badgeLabel =  match($lastBooking['status']) {
                    'confirmed' => '✅ Dikonfirmasi',
                    'pending'   => '⏳ Menunggu',
                    'cancelled' => '❌ Dibatalkan',
                    default     => $lastBooking['status'],
                };
            @endphp

            <span class="inline-block mt-2 text-xs px-3 py-1 rounded-full {{ $badgeClass }}">
                {{ $badgeLabel }}
            </span>

        @else
            <p class="text-gray-400 text-sm">Belum ada booking</p>
        @endif

    </div>

    {{-- MENU --}}
    <div class="grid grid-cols-2 gap-4">

        <a href="/customer/booking" class="bg-green-600 text-white p-6 rounded-2xl text-center">
            <div class="text-2xl">✈️</div>
            <div class="font-bold text-sm mt-2">Pesan</div>
            <div class="text-green-100 text-xs mt-1">Buat booking baru</div>
        </a>

        <a href="/customer/history" class="bg-white p-6 rounded-2xl text-center border">
            <div class="text-2xl">>📋</div>
            <div class="font-bold text-sm mt-2">Riwayat</div>
            <div class="text-gray-400 text-xs mt-1">Lihat semua pesanan</div>
        </a>

        <a href="/customer/payment" class="bg-white p-6 rounded-2xl text-center border">
            <div class="text-2xl">💳</div>
            <div class="font-bold text-sm mt-2">Pembayaran</div>
            <div class="text-gray-400 text-xs mt-1">Upload bukti transfer</div>
        </a>

        <a href="#" class="bg-white p-6 rounded-2xl text-center border">
            <div class="text-2xl">👤</div>
            <div class="font-bold text-sm mt-2">Profil</div>
            <div class="text-gray-400 text-xs mt-1">Edit informasi akun</div>
        </a>

    </div>

</div>

{{-- BOTTOM NAV --}}
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-40">
    <div class="max-w-2xl mx-auto px-4 flex justify-around py-1.5">
        <a href="/customer/dashboard" class="flex flex-col items-center p-2 text-green-600">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
            <span class="text-xs font-bold mt-0.5">Home</span>
        </a>
        <a href="/customer/booking" class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="text-xs font-medium mt-0.5">Pesan</span>
        </a>
        <a href="/customer/history" class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
            <span class="text-xs font-medium mt-0.5">Riwayat</span>
        </a>
        <a href="/customer/payment" class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            <span class="text-xs font-medium mt-0.5">Bayar</span>
        </a>
    </div>
</nav>
<div class="h-20"></div>

</body>
</html>