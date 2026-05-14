<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Driver — Sanu Travel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body{
            background: #f6f8fc;
        }

        .glass{
            backdrop-filter: blur(14px);
        }

        .card-hover{
            transition: all .2s ease;
        }

        .card-hover:active{
            transform: scale(.98);
        }

        .card-hover:hover{
            transform: translateY(-2px);
        }

        .soft-shadow{
            box-shadow:
                0 10px 30px rgba(15, 23, 42, 0.06),
                0 2px 10px rgba(15, 23, 42, 0.03);
        }
    </style>
</head>

<body class="min-h-screen">

{{-- MAIN CONTAINER --}}
<div class="max-w-md mx-auto min-h-screen relative">

    {{-- HEADER --}}
    <div class="relative overflow-hidden rounded-b-[34px] bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700">

        {{-- ORNAMENT --}}
        <div class="absolute -top-14 -right-10 w-44 h-44 bg-white/5 rounded-full"></div>
        <div class="absolute top-28 -left-10 w-32 h-32 bg-white/5 rounded-full"></div>

        <div class="relative px-5 pt-8 pb-7">

            {{-- TOPBAR --}}
            <div class="flex items-start justify-between">

                <div>
                    <p class="text-slate-300 text-xs font-medium tracking-wide mb-1">
                        DRIVER PANEL
                    </p>

                    <h1 class="text-white text-[26px] font-extrabold leading-tight">
                        Halo 👋
                    </h1>

                    <p class="text-slate-300 text-sm mt-1">
                        Semoga perjalanan hari ini lancar
                    </p>
                </div>

                <form method="POST" action="/logout">
                    @csrf

                    <button
                        class="bg-white/10 glass border border-white/10 text-white text-sm px-4 py-2 rounded-2xl active:scale-95 transition">
                        Logout
                    </button>
                </form>

            </div>

            {{-- PROFILE CARD --}}
            <div class="mt-6 bg-white/10 glass border border-white/10 rounded-[28px] p-4">

                <div class="flex items-center gap-4">

                    {{-- PHOTO --}}
                    @if($driver?->photo)

                        <img
                            src="{{ asset('storage/'.$driver->photo) }}"
                            class="w-[68px] h-[68px] rounded-[22px] object-cover border-2 border-white/20 shadow-lg flex-shrink-0"
                        >

                    @else

                        <div class="w-[68px] h-[68px] rounded-[22px] bg-white/10 flex items-center justify-center text-3xl flex-shrink-0">
                            👤
                        </div>

                    @endif

                    {{-- INFO --}}
                    <div class="min-w-0 flex-1">

                        <h2 class="text-white text-lg font-bold truncate">
                            {{ $driver->name ?? '-' }}
                        </h2>

                        <p class="text-slate-300 text-sm truncate mt-0.5">
                            {{ $driver->phone ?? '-' }}
                        </p>

                        <div class="mt-3 flex items-center gap-2">

                            <div class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></div>

                            <span class="text-emerald-100 text-xs font-semibold">
                                Driver Aktif
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="px-4 pt-5 pb-32">

        {{-- STATS --}}
        <div class="grid grid-cols-2 gap-4">

            {{-- CUSTOMER --}}
            <div class="bg-white rounded-[28px] p-5 soft-shadow border border-slate-100">

                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-xl mb-4">
                    👥
                </div>

                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">
                    Total Customer
                </p>

                <h2 class="text-[32px] leading-none font-extrabold text-slate-800 mt-2">
                    {{ $customerCount }}
                </h2>

                <p class="text-slate-400 text-xs mt-2">
                    Customer aktif hari ini
                </p>

            </div>

            {{-- DELIVERY --}}
            <div class="bg-white rounded-[28px] p-5 soft-shadow border border-slate-100">

                <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-xl mb-4">
                    🚐
                </div>

                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">
                    Delivery
                </p>

                <h2 class="text-[32px] leading-none font-extrabold text-slate-800 mt-2">
                    {{ $ordersToday ?? 0 }}
                </h2>

                <p class="text-slate-400 text-xs mt-2">
                    Perjalanan hari ini
                </p>

            </div>

        </div>

        {{-- MENU --}}
        <div class="mt-7">

            <div class="flex items-center justify-between mb-4">

                <h3 class="font-bold text-slate-700">
                    Menu Utama
                </h3>

                <span class="text-xs text-slate-400">
                    Sanu Travel
                </span>

            </div>

            <div class="space-y-4">

                {{-- DELIVERY --}}
                <a href="/driver/delivery"
                   class="card-hover relative overflow-hidden block rounded-[30px] bg-gradient-to-br from-slate-800 to-slate-700 p-5 text-white soft-shadow">

                    <div class="absolute right-0 top-0 w-40 h-40 bg-white/5 rounded-full"></div>

                    <div class="relative flex items-center justify-between">

                        <div>

                            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-2xl mb-4">
                                🚐
                            </div>

                            <h2 class="font-bold text-lg">
                                Delivery Order
                            </h2>

                            <p class="text-slate-300 text-sm mt-1 leading-relaxed">
                                Kelola perjalanan customer dengan mudah
                            </p>

                        </div>

                        <div class="text-2xl opacity-40">
                            →
                        </div>

                    </div>

                </a>

                {{-- PAYMENT --}}
                <a href="/driver/payments"
                   class="card-hover block bg-white rounded-[30px] p-5 border border-slate-100 soft-shadow">

                    <div class="flex items-center justify-between gap-4">

                        <div>

                            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-2xl mb-4">
                                💰
                            </div>

                            <h2 class="font-bold text-slate-800 text-lg">
                                Cash Payment
                            </h2>

                            <p class="text-slate-400 text-sm mt-1 leading-relaxed">
                                Upload bukti pembayaran cash customer
                            </p>

                        </div>

                        <div class="text-2xl text-slate-300 flex-shrink-0">
                            →
                        </div>

                    </div>

                </a>

            </div>

        </div>

    </div>

    {{-- BOTTOM NAV --}}
    <div class="fixed bottom-4 left-0 right-0 z-50 px-4">

        <div class="max-w-md mx-auto">

            <div class="bg-white/90 glass border border-white rounded-[28px] px-6 py-3 soft-shadow">

                <div class="flex items-center justify-around">

                    {{-- HOME --}}
                    <a href="/driver/dashboard"
                       class="flex flex-col items-center text-slate-800">

                        <div class="w-11 h-11 rounded-2xl bg-slate-100 flex items-center justify-center mb-1 text-lg">
                            🏠
                        </div>

                        <span class="text-[11px] font-bold">
                            Home
                        </span>

                    </a>

                    {{-- DELIVERY --}}
                    <a href="/driver/delivery"
                       class="flex flex-col items-center text-slate-400">

                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-1 text-lg">
                            🚐
                        </div>

                        <span class="text-[11px] font-semibold">
                            Delivery
                        </span>

                    </a>

                    {{-- PAYMENT --}}
                    <a href="/driver/payments"
                       class="flex flex-col items-center text-slate-400">

                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-1 text-lg">
                            💰
                        </div>

                        <span class="text-[11px] font-semibold">
                            Payment
                        </span>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>