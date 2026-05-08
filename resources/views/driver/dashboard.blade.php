<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Driver — Sanu Travel</title>

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

        <div class="flex items-center gap-2">

            <div class="w-8 h-8 bg-green-600 rounded-xl flex items-center justify-center shadow">

                <svg class="w-4 h-4 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2.5"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>

                </svg>

            </div>

            <span class="font-extrabold text-green-700">
                Sanu<span class="text-gray-800">Travel</span>
            </span>

        </div>

        <form method="POST" action="/logout">
            @csrf

            <button type="submit"
                onclick="return confirm('Yakin ingin keluar?')"
                class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-red-500 transition font-medium py-1.5 px-3 rounded-xl hover:bg-red-50">

                <svg class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>

                </svg>

                Keluar

            </button>
        </form>

    </div>

</header>

@php

    $driver = auth()->user();

    $statHariIni = [

        'customer'     => 4,
        'km'           => 320,
        'penghasilan'  => 1200000

    ];

@endphp

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 space-y-5">

    {{-- GREETING --}}
    <div class="bg-gradient-to-r from-green-700 to-green-500 rounded-3xl p-6 text-white relative overflow-hidden shadow-lg shadow-green-200">

        <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full"></div>

        <div class="relative flex items-start justify-between">

            <div>

                <p class="text-green-100 text-sm mb-1">
                    🚗 Driver Aktif
                </p>

                <h2 class="text-2xl font-extrabold mb-3">
                    {{ $driver->name }}
                </h2>

                <div class="flex flex-wrap gap-2">

                    <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">

                        {{ $driver->plate_number ?? 'Belum diatur' }}

                    </span>

                    <span class="bg-white/15 text-green-100 text-xs px-3 py-1 rounded-full">

                        {{ $driver->vehicle_name ?? 'Kendaraan Driver' }}

                    </span>

                </div>

            </div>

            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0">

                🚐

            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div>

        <h3 class="font-bold text-gray-700 text-sm mb-3 flex items-center gap-2">

            <span class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center text-xs">
                📊
            </span>

            Statistik Hari Ini

        </h3>

        <div class="grid grid-cols-3 gap-3">

            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">

                <div class="text-3xl font-extrabold text-green-700">

                    {{ $statHariIni['customer'] }}

                </div>

                <div class="text-xs text-gray-400 mt-1 font-medium">
                    Customer
                </div>

            </div>

            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">

                <div class="text-3xl font-extrabold text-blue-600">

                    {{ $statHariIni['km'] }}

                </div>

                <div class="text-xs text-gray-400 mt-1 font-medium">
                    KM
                </div>

            </div>

            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">

                <div class="text-2xl font-extrabold text-purple-600">

                    {{ number_format($statHariIni['penghasilan']/1000,0) }}K

                </div>

                <div class="text-xs text-gray-400 mt-1 font-medium">
                    Rp
                </div>

            </div>

        </div>

    </div>

    {{-- QUICK NAV --}}
    <div class="grid grid-cols-2 gap-4">

        <a href="/driver/delivery"
            class="bg-green-600 hover:bg-green-700 rounded-2xl p-6 text-white text-center transition shadow-lg shadow-green-200 active:scale-95">

            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl">

                📋

            </div>

            <div class="font-bold text-sm">
                Delivery Order
            </div>

            <div class="text-green-100 text-xs mt-1">
                Lihat daftar perjalanan
            </div>

        </a>

        <div class="bg-white rounded-2xl p-6 text-center border border-gray-100 shadow-sm">

            <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-2xl">

                👤

            </div>

            <div class="font-bold text-sm text-gray-800">
                Profil Saya
            </div>

            <div class="text-gray-400 text-xs mt-1">
                Informasi driver
            </div>

        </div>

    </div>

</div>

{{-- BOTTOM NAV --}}
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-40">

    <div class="max-w-2xl mx-auto px-4 flex justify-around py-1.5">

        <a href="/driver/dashboard"
            class="flex flex-col items-center p-2 text-green-600">

            <svg class="w-6 h-6"
                fill="currentColor"
                viewBox="0 0 20 20">

                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>

            </svg>

            <span class="text-xs font-bold mt-0.5">
                Home
            </span>

        </a>

        <a href="/driver/delivery"
            class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">

            <svg class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>

            </svg>

            <span class="text-xs font-medium mt-0.5">
                Delivery
            </span>

        </a>

    </div>

</nav>

<div class="h-20"></div>

</body>
</html>