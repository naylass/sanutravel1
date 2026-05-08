<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order — Sanu Travel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .modal-wrap {
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- HEADER --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">

        <a href="/driver/dashboard"
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
            Delivery Order
        </span>

        <form method="POST" action="/logout">
            @csrf

            <button type="submit"
                onclick="return confirm('Yakin keluar?')"
                class="text-xs text-gray-400 hover:text-red-500 font-medium py-1.5 px-2 rounded-xl hover:bg-red-50">

                Keluar
            </button>
        </form>
    </div>
</header>

@php

$badges = [

    'prepared' => [
        'label' => '🚗 Siap Jemput',
        'class' => 'bg-blue-100 text-blue-700'
    ],

    'ongoing' => [
        'label' => '🛣️ Dalam Perjalanan',
        'class' => 'bg-yellow-100 text-yellow-700'
    ],

    'completed' => [
        'label' => '✅ Selesai',
        'class' => 'bg-green-100 text-green-700'
    ],
];

@endphp

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 space-y-4">

    {{-- SUCCESS --}}
    @if(session('success'))

    <div class="bg-green-50 border border-green-200 rounded-2xl p-4">
        <p class="text-green-700 text-sm font-medium">
            {{ session('success') }}
        </p>
    </div>

    @endif

    {{-- SUMMARY --}}
    <div class="grid grid-cols-3 gap-3">

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <div class="text-2xl font-extrabold text-blue-600">
                {{ $orders->where('status','prepared')->count() }}
            </div>

            <div class="text-xs text-gray-400 font-medium mt-0.5">
                Siap Jemput
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <div class="text-2xl font-extrabold text-yellow-600">
                {{ $orders->where('status','ongoing')->count() }}
            </div>

            <div class="text-xs text-gray-400 font-medium mt-0.5">
                Berjalan
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <div class="text-2xl font-extrabold text-green-600">
                {{ $orders->where('status','completed')->count() }}
            </div>

            <div class="text-xs text-gray-400 font-medium mt-0.5">
                Selesai
            </div>
        </div>
    </div>

    {{-- ORDER LIST --}}
    @forelse($orders as $o)

    @php
        $st = $badges[$o->status] ?? [
            'label' => 'Unknown',
            'class' => 'bg-gray-100 text-gray-700'
        ];
    @endphp

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- TOP BAR --}}
        <div class="h-1.5
            {{ $o->booking->pickup_type === 'eksklusif'
                ? 'bg-gradient-to-r from-yellow-400 to-amber-400'
                : 'bg-gradient-to-r from-green-500 to-green-400' }}">
        </div>

        <div class="p-5">

            {{-- HEADER --}}
            <div class="flex items-start justify-between gap-3 mb-4">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center font-bold text-green-700 flex-shrink-0">

                        {{ strtoupper(substr($o->booking->user->name ?? 'U',0,1)) }}

                    </div>

                    <div>
                        <p class="font-bold text-gray-900 text-sm">
                            {{ $o->booking->user->name ?? '-' }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ $o->booking->booking_code }}
                        </p>
                    </div>
                </div>

                <span class="text-xs font-bold px-3 py-1.5 rounded-full flex-shrink-0 {{ $st['class'] }}">

                    {{ $st['label'] }}

                </span>
            </div>

            {{-- ROUTE --}}
            <div class="space-y-2 mb-4">

                <div class="flex items-start gap-2">

                    <span class="text-green-500 mt-0.5 flex-shrink-0">
                        📍
                    </span>

                    <div>
                        <p class="text-xs text-gray-400">
                            Penjemputan
                        </p>

                        <p class="text-sm font-semibold text-gray-700">
                            {{ $o->booking->pickup_location }}
                        </p>
                    </div>
                </div>

                <div class="ml-3 pl-2 border-l-2 border-dashed border-gray-200 h-3"></div>

                <div class="flex items-start gap-2">

                    <span class="mt-0.5 flex-shrink-0">
                        🏁
                    </span>

                    <div>
                        <p class="text-xs text-gray-400">
                            Tujuan
                        </p>

                        <p class="text-sm font-semibold text-gray-700">
                            {{ $o->booking->destination }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="flex items-center justify-between flex-wrap gap-2">

                <div class="flex items-center gap-2 text-xs text-gray-500">

                    <span>
                        🕐
                        {{ \Carbon\Carbon::parse($o->booking->pickup_time)->format('H:i') }}
                    </span>

                    <span>·</span>

                    <span>
                        👤
                        {{ $o->booking->total_passengers }} orang
                    </span>

                    <span>·</span>

                    <span class="{{ $o->booking->pickup_type === 'eksklusif'
                        ? 'text-yellow-600'
                        : 'text-green-600' }} font-semibold">

                        {{ ucfirst($o->booking->pickup_type) }}
                    </span>
                </div>

                @if($o->status !== 'completed')

                <button
                    onclick="openModal(
                        {{ $o->id }},
                        '/driver/delivery/{{ $o->id }}/update'
                    )"

                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-1.5 active:scale-95">

                    <svg class="w-3.5 h-3.5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>

                    Update Status
                </button>

                @else

                <span class="text-green-600 text-xs font-bold flex items-center gap-1">

                    <svg class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20">

                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                    </svg>

                    Selesai
                </span>

                @endif
            </div>
        </div>
    </div>

    @empty

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 text-center">

        <div class="text-5xl mb-4">
            🚐
        </div>

        <h3 class="font-bold text-gray-800 mb-1">
            Belum ada delivery order
        </h3>

        <p class="text-sm text-gray-400">
            Delivery order akan muncul di sini.
        </p>
    </div>

    @endforelse
</div>

{{-- MODAL --}}
<div id="statusModal"
    class="fixed inset-0 z-50 hidden items-center justify-center p-4">

    <div class="absolute inset-0 bg-black/50 modal-wrap"
        onclick="closeModal()"></div>

    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-6">

        <button onclick="closeModal()"
            class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200">

            ✕
        </button>

        <h3 class="font-extrabold text-gray-900 text-lg mb-1">
            Update Status
        </h3>

        <p class="text-gray-400 text-sm mb-5">
            Pilih status perjalanan saat ini
        </p>

        <form method="POST" id="modalForm">

            @csrf
            @method('PATCH')

            <div class="space-y-3 mb-6">

                <label class="flex items-center gap-3 p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:border-blue-300 transition">

                    <input type="radio"
                        name="status"
                        value="prepared"
                        class="text-blue-600">

                    <span class="text-xl">🚗</span>

                    <div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Siap Jemput
                        </p>

                        <p class="text-xs text-gray-400">
                            Menuju lokasi penjemputan
                        </p>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:border-yellow-300 transition">

                    <input type="radio"
                        name="status"
                        value="ongoing"
                        class="text-yellow-600">

                    <span class="text-xl">🛣️</span>

                    <div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Dalam Perjalanan
                        </p>

                        <p class="text-xs text-gray-400">
                            Penumpang sudah dijemput
                        </p>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-4 border-2 border-gray-100 rounded-2xl cursor-pointer hover:border-green-300 transition">

                    <input type="radio"
                        name="status"
                        value="completed"
                        class="text-green-600">

                    <span class="text-xl">✅</span>

                    <div>
                        <p class="font-semibold text-gray-800 text-sm">
                            Selesai
                        </p>

                        <p class="text-xs text-gray-400">
                            Penumpang tiba dengan selamat
                        </p>
                    </div>
                </label>
            </div>

            <div class="flex gap-3">

                <button type="button"
                    onclick="closeModal()"
                    class="flex-1 py-3 border-2 border-gray-200 text-gray-600 font-semibold rounded-2xl hover:bg-gray-50 transition text-sm">

                    Batal
                </button>

                <button type="submit"
                    class="flex-1 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl transition text-sm">

                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- BOTTOM NAV --}}
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-40">

    <div class="max-w-2xl mx-auto px-4 flex justify-around py-1.5">

        <a href="/driver/dashboard"
            class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">

            <svg class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>

            <span class="text-xs mt-0.5">
                Home
            </span>
        </a>

        <a href="/driver/delivery"
            class="flex flex-col items-center p-2 text-green-600">

            <svg class="w-6 h-6"
                fill="currentColor"
                viewBox="0 0 20 20">

                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>

                <path fill-rule="evenodd"
                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
            </svg>

            <span class="text-xs font-bold mt-0.5">
                Delivery
            </span>
        </a>
    </div>
</nav>

<div class="h-20"></div>

<script>

    function openModal(id, url) {

        document.getElementById('modalForm').action = url;

        document.getElementById('statusModal')
            .classList.remove('hidden');

        document.getElementById('statusModal')
            .classList.add('flex');
    }

    function closeModal() {

        document.getElementById('statusModal')
            .classList.add('hidden');

        document.getElementById('statusModal')
            .classList.remove('flex');
    }

</script>

</body>
</html>