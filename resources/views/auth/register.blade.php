<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 flex items-center justify-center px-4 py-12">
<div class="w-full max-w-md">

    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-2 mb-4">
            <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </div>
            <span class="text-2xl font-extrabold text-green-700">Sanu<span class="text-gray-800">Travel</span></span>
        </a>
        <h1 class="text-2xl font-extrabold text-gray-900">Buat Akun Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar gratis dan mulai perjalanan Anda</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-green-100/60 border border-green-100 p-8">

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-5">
            @foreach($errors->all() as $error)
            <p class="text-red-700 text-sm">• {{ $error }}</p>
            @endforeach
        </div>
        @endif

        {{-- Info role otomatis --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-5 flex gap-3 items-center">
            <span class="text-2xl flex-shrink-0">ℹ️</span>
            <p class="text-green-700 text-sm">Akun baru otomatis mendapat role <strong>Customer</strong>.</p>
        </div>

        <form method="POST" action="/register" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required
                        class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition placeholder-gray-400">
                </div>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required
                        class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition placeholder-gray-400">
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input type="password" name="password" id="pwd1" placeholder="Minimal 8 karakter" required
                        class="w-full pl-11 pr-12 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition placeholder-gray-400">
                    <button type="button" onclick="togglePwd('pwd1')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <input type="password" name="password_confirmation" id="pwd2" placeholder="Ulangi password" required
                        class="w-full pl-11 pr-12 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition placeholder-gray-400">
                    <button type="button" onclick="togglePwd('pwd2')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            {{-- Terms --}}
            <div class="flex items-start gap-2.5">
                <input type="checkbox" name="terms" id="terms" required class="w-4 h-4 rounded text-green-600 border-gray-300 mt-0.5">
                <label for="terms" class="text-sm text-gray-500">
                    Saya setuju dengan <a href="#" class="text-green-600 font-semibold hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-green-600 font-semibold hover:underline">Kebijakan Privasi</a> Sanu Travel.
                </label>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-2xl transition shadow-lg shadow-green-200 text-sm">
                🚀 Buat Akun Sekarang
            </button>
        </form>

        <div class="flex items-center gap-4 my-5">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-xs text-gray-400 font-medium">ATAU</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        <p class="text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="/login" class="text-green-600 font-bold hover:text-green-700">Masuk di sini →</a>
        </p>
    </div>

    <div class="text-center mt-5">
        <a href="/" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-green-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
<script>
    function togglePwd(id) {
        const i = document.getElementById(id);
        i.type = i.type === 'password' ? 'text' : 'password';
    }
</script>
</body>
</html>