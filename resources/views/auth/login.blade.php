<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sanu Travel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 50%, #ecfdf5 100%);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen px-4">

<div class="w-full max-w-md">

    {{-- HEADER --}}
    <div class="text-center mb-8">
        <div class="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
            <span class="text-white font-bold text-xl">ST</span>
        </div>

        <h1 class="text-2xl font-extrabold text-gray-900">Sanu Travel</h1>
        <p class="text-gray-500 text-sm">Masuk untuk melanjutkan perjalanan</p>
    </div>

    {{-- CARD --}}
    <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm p-3 rounded-2xl">
                Email atau password salah
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Email</label>
                <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full mt-2 px-4 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none"
                    placeholder="email@contoh.com"
                    required>
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Password</label>

                <div class="relative mt-2">
                    <input type="password"
                        name="password"
                        id="password"
                        class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-green-500 outline-none"
                        placeholder="••••••••"
                        required>

                    <button type="button"
                        onclick="togglePassword()"
                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">

                        👁
                    </button>
                </div>
            </div>

            {{-- REMEMBER --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember"
                    class="w-4 h-4 text-green-600 rounded">
                <span class="text-sm text-gray-600">Ingat saya</span>
            </div>

            {{-- BUTTON --}}
            <button class="w-full bg-green-600 text-white py-3 rounded-2xl font-bold hover:bg-green-700 transition">
                Masuk
            </button>
        </form>

    </div>

    {{-- FOOTER --}}
    <p class="text-center text-xs text-gray-400 mt-5">
        © {{ date('Y') }} Sanu Travel
    </p>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>