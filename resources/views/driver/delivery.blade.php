<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Driver — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        select { -webkit-appearance: none; appearance: none; }
    </style>
</head>

<body class="bg-slate-100 min-h-screen pb-10">

{{-- STICKY HEADER --}}
<header class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="/driver/dashboard" class="flex items-center gap-2 text-slate-500 hover:text-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="text-sm font-semibold">Kembali</span>
        </a>
        <span class="font-bold text-slate-800">Delivery Order</span>
        <div class="w-16"></div>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 py-6 space-y-4">

    @forelse($orders as $o)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        {{-- Status bar --}}
        <div class="h-1.5
            @if($o->status == 'prepared') bg-gradient-to-r from-blue-400 to-blue-500
            @elseif($o->status == 'ongoing') bg-gradient-to-r from-amber-400 to-orange-400
            @elseif($o->status == 'completed') bg-gradient-to-r from-emerald-400 to-teal-400
            @else bg-gradient-to-r from-red-400 to-rose-400
            @endif">
        </div>

        <div class="p-5">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-5">
                <div>
                    <h2 class="font-extrabold text-slate-800 text-lg leading-tight">{{ $o->booking->customer_name ?? '-' }}</h2>
                    <p class="text-slate-400 text-xs mt-1 font-medium">{{ $o->booking->booking_code ?? '-' }}</p>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full
                    @if($o->status == 'prepared') bg-blue-50 text-blue-600 border border-blue-100
                    @elseif($o->status == 'ongoing') bg-amber-50 text-amber-600 border border-amber-100
                    @elseif($o->status == 'completed') bg-emerald-50 text-emerald-600 border border-emerald-100
                    @else bg-red-50 text-red-600 border border-red-100
                    @endif">
                    {{ strtoupper($o->status) }}
                </span>
            </div>

            {{-- Detail pills --}}
            <div class="space-y-2.5 mb-5">
                <div class="flex items-start gap-3 bg-slate-50 rounded-2xl px-4 py-3">
                    <span class="text-base mt-0.5">📍</span>
                    <div class="min-w-0">
                        <p class="text-xs text-slate-400 font-medium">Penjemputan</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $o->booking->pickup_location ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 bg-slate-50 rounded-2xl px-4 py-3">
                    <span class="text-base mt-0.5">🏁</span>
                    <div class="min-w-0">
                        <p class="text-xs text-slate-400 font-medium">Tujuan</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $o->booking->destination ?? '-' }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex items-center gap-2 bg-slate-50 rounded-2xl px-4 py-3">
                        <span>🕐</span>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Jam</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $o->booking->pickup_time ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 bg-slate-50 rounded-2xl px-4 py-3">
                        <span>👤</span>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Penumpang</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $o->booking->total_passengers ?? 0 }} orang</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTION --}}
            @if($o->status != 'completed' && $o->status != 'cancel')
            <form method="POST" action="/driver/delivery/{{ $o->id }}/update">
                @csrf
                @method('PATCH')
                <div class="relative mb-3">
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 font-semibold text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 pr-10">
                        <option value="ongoing">🔄 On Going</option>
                        <option value="completed">✅ Completed</option>
                        <option value="cancel">❌ Cancel</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <button class="w-full bg-slate-800 hover:bg-slate-700 active:scale-98 text-white py-3.5 rounded-2xl font-bold text-sm transition-all">
                    Update Status
                </button>
            </form>
            @else
            <div class="flex items-center justify-center gap-2 bg-emerald-50 border border-emerald-100 rounded-2xl py-3.5">
                <span>✅</span>
                <p class="text-emerald-600 font-bold text-sm">Perjalanan selesai</p>
            </div>
            @endif
        </div>
    </div>

    @empty
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 text-center py-20 px-6">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-4xl">🚐</div>
        <h2 class="font-bold text-slate-700 text-lg mb-2">Belum Ada Delivery</h2>
        <p class="text-slate-400 text-sm">Delivery order akan muncul di sini</p>
    </div>
    @endforelse

</div>

</body>
</html>