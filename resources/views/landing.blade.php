<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanu Travel — Perjalanan Aman & Nyaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-bg { background: linear-gradient(135deg, #052e16 0%, #14532d 60%, #16a34a 100%); }
        .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(22,163,74,0.15); }
        .float { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    </style>
</head>
<body class="bg-white overflow-x-hidden">

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-green-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-2">
                <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center shadow">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <span class="text-xl font-extrabold text-green-700">Sanu<span class="text-gray-800">Travel</span></span>
            </a>
            <div class="hidden md:flex items-center gap-6">
                <a href="#layanan" class="text-sm font-medium text-gray-600 hover:text-green-600 transition">Layanan</a>
                <a href="#cara-pesan" class="text-sm font-medium text-gray-600 hover:text-green-600 transition">Cara Pesan</a>
                <a href="#testimoni" class="text-sm font-medium text-gray-600 hover:text-green-600 transition">Testimoni</a>
                <a href="/login" class="text-sm font-semibold text-green-700 hover:text-green-800 transition border border-green-200 px-4 py-2 rounded-full hover:bg-green-50">Masuk</a>
                <a href="/register" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded-full transition shadow-md">Daftar Gratis</a>
            </div>
            <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="md:hidden p-2 text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <div id="mobileMenu" class="hidden flex-col pb-4 gap-2 md:hidden border-t border-gray-100 pt-3">
            <a href="#layanan" class="py-2 text-sm text-gray-600 font-medium">Layanan</a>
            <a href="#cara-pesan" class="py-2 text-sm text-gray-600 font-medium">Cara Pesan</a>
            <a href="#testimoni" class="py-2 text-sm text-gray-600 font-medium">Testimoni</a>
            <div class="flex gap-3 pt-2">
                <a href="/login" class="flex-1 text-center border-2 border-green-600 text-green-700 text-sm font-bold py-2.5 rounded-full">Masuk</a>
                <a href="/register" class="flex-1 text-center bg-green-600 text-white text-sm font-bold py-2.5 rounded-full">Daftar</a>
            </div>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero-bg min-h-screen flex items-center pt-16 relative overflow-hidden">
    <div class="absolute top-20 right-[-6rem] w-96 h-96 bg-green-400/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 left-[-4rem] w-72 h-72 bg-emerald-300/10 rounded-full blur-2xl"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 grid md:grid-cols-2 gap-12 items-center w-full">
        <div class="text-white">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium text-green-200 mb-6">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Melayani 10.000+ Pelanggan Puas
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-5">
                Perjalanan <span class="text-green-300">Aman</span> &amp; Nyaman Bersama Sanu Travel
            </h1>
            <p class="text-green-100 text-base leading-relaxed mb-8 max-w-lg">
                Pilih paket perjalanan sesuai kebutuhan Anda. Dari layanan reguler hemat hingga eksklusif — semua tersedia di sini.
            </p>

            {{-- Price Cards --}}
            <div class="flex flex-wrap gap-3 mb-8">
                <div class="flex items-center gap-3 bg-white/10 border border-white/20 rounded-2xl px-4 py-3">
                    <div class="w-9 h-9 bg-green-400/30 rounded-xl flex items-center justify-center text-lg">🚐</div>
                    <div>
                        <div class="text-xs text-green-200 font-medium">Reguler</div>
                        <div class="text-white font-extrabold">Rp 300.000</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-yellow-400/20 border border-yellow-300/30 rounded-2xl px-4 py-3">
                    <div class="w-9 h-9 bg-yellow-400/30 rounded-xl flex items-center justify-center text-lg">⭐</div>
                    <div>
                        <div class="text-xs text-yellow-200 font-medium">Eksklusif</div>
                        <div class="text-white font-extrabold">Rp 600.000</div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="/register" class="bg-white text-green-700 font-bold px-7 py-3 rounded-full hover:bg-green-50 transition shadow-lg text-sm">
                    🚀 Pesan Sekarang
                </a>
                <a href="#layanan" class="border-2 border-white/40 text-white font-semibold px-7 py-3 rounded-full hover:bg-white/10 transition text-sm">
                    Lihat Layanan
                </a>
            </div>
        </div>

        {{-- Floating Card --}}
        <div class="hidden md:flex justify-center">
            <div class="float relative">
                <div class="w-72 bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-6 text-white space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="font-bold">Booking Aktif</span>
                        <span class="bg-green-400 text-xs font-bold text-white px-3 py-1 rounded-full">CONFIRMED</span>
                    </div>
                    <div class="bg-white/20 rounded-2xl p-4 space-y-3">
                        <div>
                            <div class="text-green-200 text-xs mb-1">Penjemputan</div>
                            <div class="font-semibold text-sm">📍 Ciwandan</div>
                        </div>
                        <div class="border-t border-white/20"></div>
                        <div>
                            <div class="text-green-200 text-xs mb-1">Tujuan</div>
                            <div class="font-semibold text-sm">🏁 Bandara Soekarno Hatta</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-green-200 text-xs">Total</div>
                            <div class="font-extrabold text-xl">Rp 600.000</div>
                        </div>
                        <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full">Eksklusif</span>
                    </div>
                </div>
                <div class="absolute -top-3 -right-3 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full shadow-lg">⭐ 4.9 Rating</div>
                <div class="absolute -bottom-3 -left-3 bg-white text-green-700 text-xs font-bold px-3 py-1 rounded-full shadow-lg">✅ 10K+ Trips</div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-14 bg-white" style="clip-path: ellipse(70% 100% at 50% 100%)"></div>
</section>

{{-- STATS --}}
<section class="py-12 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([['10K+','Pelanggan','👥'],['5K+','Perjalanan','🚗'],['50+','Kota','📍'],['4.9','Rating','⭐']] as $s)
        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 text-center">
            <div class="text-2xl mb-1">{{ $s[2] }}</div>
            <div class="text-2xl font-extrabold text-green-700">{{ $s[0] }}</div>
            <div class="text-sm text-gray-500">{{ $s[1] }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- LAYANAN --}}
<section id="layanan" class="py-20 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-bold text-sm uppercase tracking-widest">Paket Kami</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mt-2 mb-3">Pilih Layanan Terbaik</h2>
            <p class="text-gray-500 max-w-lg mx-auto">Dua pilihan layanan untuk semua kebutuhan perjalanan Anda.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {{-- REGULER --}}
            <div class="card-hover bg-white rounded-3xl overflow-hidden border border-green-100 shadow-sm">
                <div class="bg-gradient-to-br from-green-600 to-green-500 p-7 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3 text-2xl">🚐</div>
                    <span class="bg-green-700 text-white text-xs font-bold px-3 py-1 rounded-full">REGULER</span>
                    <div class="text-4xl font-extrabold mt-3">Rp 300.000</div>
                    <div class="text-green-100 text-sm">per perjalanan</div>
                </div>
                <div class="p-7">
                    <ul class="space-y-2.5 mb-6">
                        @foreach(['Minibus AC nyaman','Supir berpengalaman'] as $f)
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 text-green-600 text-xs">✓</span>
                            {{ $f }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="/register" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-2xl transition">
                        Pilih Reguler
                    </a>
                </div>
            </div>

            {{-- EKSKLUSIF --}}
            <div class="card-hover bg-white rounded-3xl overflow-hidden border-2 border-yellow-400 shadow-lg relative">
                <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full">⭐ POPULER</div>
                <div class="bg-gradient-to-br from-amber-500 to-yellow-400 p-7 text-white">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3 text-2xl">🌟</div>
                    <span class="bg-yellow-600 text-white text-xs font-bold px-3 py-1 rounded-full">EKSKLUSIF</span>
                    <div class="text-4xl font-extrabold mt-3">Rp 600.000</div>
                    <div class="text-yellow-100 text-sm">per perjalanan</div>
                </div>
                <div class="p-7">
                    <ul class="space-y-2.5 mb-6">
                        @foreach(['Supir profesional','private mobil', 'request jam penjemputan'] as $f)
                        <li class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="w-5 h-5 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 text-yellow-600 text-xs">✓</span>
                            {{ $f }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="/register" class="block w-full text-center bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white font-bold py-3.5 rounded-2xl transition shadow-md">
                        Pilih Eksklusif
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CARA PESAN --}}
<section id="cara-pesan" class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-bold text-sm uppercase tracking-widest">Mudah & Cepat</span>
            <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Cara Pesan Tiket</h2>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach([['01','Daftar Akun','Buat akun gratis dalam 1 menit','📝'],['02','Pilih Layanan','Reguler atau Eksklusif','🎯'],['03','Isi Formulir','Rute, tanggal & penumpang','📋'],['04','Bayar & Jalan','Upload bukti transfer, selesai!','✅']] as $s)
            <div class="text-center group">
                <div class="w-16 h-16 bg-green-600 text-white rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 group-hover:scale-110 transition shadow-lg shadow-green-200">{{ $s[3] }}</div>
                <div class="text-xs font-bold text-green-500 mb-1">LANGKAH {{ $s[0] }}</div>
                <div class="font-bold text-gray-800 mb-1">{{ $s[1] }}</div>
                <div class="text-sm text-gray-500">{{ $s[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TESTIMONI --}}
<section id="testimoni" class="py-20 bg-green-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <span class="text-green-600 font-bold text-sm uppercase tracking-widest">Testimoni</span>
            <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Kata Pelanggan Kami</h2>
        </div>
        <div class="grid sm:grid-cols-3 gap-6">
            @foreach([
                ['Budi S.','Ciwandan','Pelayanan luar biasa! Tepat waktu dan sopir sangat ramah.','eksklusif'],
                ['Sari R.','Tangerang','Harga reguler terjangkau, kualitasnya ga kalah. Pasti order lagi!','reguler'],
                ['Ahmad F.','Merak','Sudah 5x pesan, tidak pernah kecewa. Highly recommended!','eksklusif'],
            ] as $t)
            <div class="card-hover bg-white rounded-2xl p-6 shadow-sm border border-green-100">
                <div class="text-yellow-400 text-sm mb-3">★★★★★</div>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">"{{ $t[2] }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr($t[0],0,1)) }}</div>
                    <div>
                        <div class="font-semibold text-gray-800 text-sm">{{ $t[0] }}</div>
                        <div class="text-xs text-gray-400">{{ $t[1] }} · {{ ucfirst($t[3]) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="hero-bg py-20 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-48 h-48 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-2xl mx-auto px-4">
        <h2 class="text-3xl font-extrabold mb-4">Siap Memulai Perjalanan?</h2>
        <p class="text-green-100 mb-8">Daftar sekarang dan nikmati kemudahan booking travel online.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/register" class="bg-white text-green-700 font-bold px-8 py-3.5 rounded-full hover:bg-green-50 transition shadow-lg">Daftar Gratis</a>
            <a href="/login/auth" class="border-2 border-white/50 text-white font-bold px-8 py-3.5 rounded-full hover:bg-white/10 transition">Sudah Punya Akun?</a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-gray-900 text-gray-400 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
            <span class="text-white font-bold">SanuTravel</span>
        </div>
        <div class="text-sm">© {{ date('Y') }} Sanu Travel. Semua hak dilindungi.</div>
        <div class="flex gap-4 text-sm">
            <a href="#" class="hover:text-white transition">Privasi</a>
            <a href="#" class="hover:text-white transition">Syarat & Ketentuan</a>
        </div>
    </div>
</footer>

</body>
</html>