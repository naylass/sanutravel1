<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Tiket — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- HEADER --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
        <a href="/customer/dashboard" class="flex items-center gap-2 text-gray-500 hover:text-green-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span class="text-sm font-medium">Kembali</span>
        </a>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" onclick="return confirm('Yakin keluar?')"
                class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-red-500 transition font-medium py-1.5 px-3 rounded-xl hover:bg-red-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>
        </form>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
    <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Pesan Travel</h1>
    <p class="text-gray-500 text-sm mb-6">Isi formulir untuk membuat reservasi perjalanan</p>

    {{-- Pilih Layanan --}}
    <div class="mb-6">
        <label class="block text-sm font-bold text-gray-700 mb-3">Pilih Layanan *</label>
        <div class="grid grid-cols-2 gap-4" id="layananPicker">
            {{-- Reguler --}}
            <div onclick="selectLayanan('reguler')" id="card-reguler"
                class="layanan-card cursor-pointer border-2 border-green-500 bg-green-50 rounded-2xl p-4 transition">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-2 text-xl">🚐</div>
                <div class="font-bold text-gray-800 text-sm">Reguler</div>
                <div class="text-green-600 font-extrabold text-lg">Rp 300.000</div>
                <div id="check-reguler" class="mt-2 text-green-600 text-xs font-bold flex items-center gap-1">✓ Dipilih</div>
            </div>
            {{-- Eksklusif --}}
            <div onclick="selectLayanan('eksklusif')" id="card-eksklusif"
                class="layanan-card cursor-pointer border-2 border-gray-200 bg-white rounded-2xl p-4 transition">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mb-2 text-xl">⭐</div>
                <div class="font-bold text-gray-800 text-sm">Eksklusif</div>
                <div class="text-yellow-600 font-extrabold text-lg">Rp 600.000</div>
                <div id="check-eksklusif" class="mt-2 text-yellow-600 text-xs font-bold hidden items-center gap-1">✓ Dipilih</div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('customer.booking.store') }}" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-5">
        @csrf
        <input type="hidden" name="pickup_type" id="layananInput" value="reguler">
        <input type="hidden" name="service_id" id="serviceIdInput" value="1">

        {{-- Success --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex gap-3 items-center">
            <span class="text-2xl">✅</span>
            <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
            @foreach($errors->all() as $e)<p class="text-red-700 text-sm">• {{ $e }}</p>@endforeach
        </div>
        @endif

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Perjalanan *</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <input type="date" name="pickup_date" value="{{ old('pickup_date') }}" required
                    class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition">
            </div>
        </div>

{{-- Jam --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Jam Keberangkatan *
    </label>

    {{-- REGULER --}}
    <select
        name="pickup_time"
        id="slot_time"
        required
        class="w-full border border-gray-200 rounded-2xl p-3 bg-gray-50 focus:ring-2 focus:ring-green-500 focus:outline-none">

        <option value="">Pilih Jam</option>
        <option value="08:00:00">08:00 WIB</option>
        <option value="12:00:00">12:00 WIB</option>
        <option value="15:00:00">15:00 WIB</option>
        <option value="18:00:00">18:00 WIB</option>
        <option value="21:00:00">21:00 WIB</option>
        <option value="00:00:00">00:00 WIB</option>
        <option value="03:00:00">03:00 WIB</option>
    </select>

    {{-- EKSKLUSIF --}}
    <input
        type="time"
        id="free_time"
        class="hidden w-full border border-gray-200 rounded-2xl p-3 bg-gray-50 focus:ring-2 focus:ring-green-500 focus:outline-none mt-2">
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Nomor Telepon *
    </label>

    <div class="relative">

        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 5a2 2 0 012-2h3.28a2 2 0 011.894 1.368l1.516 4.547a2 2 0 01-.45 2.11l-2.547 2.547a16 16 0 006.586 6.586l2.547-2.547a2 2 0 012.11-.45l4.547 1.516A2 2 0 0121 18.72V22a2 2 0 01-2 2h-1C9.163 24 0 14.837 0 3V2a2 2 0 012-2h1z"/>
            </svg>
        </div>

        <input
            type="text"
            name="phone_number"
            value="{{ old('phone_number') }}"
            placeholder="Contoh: 08123456789"
            required
            class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition placeholder-gray-400">
    </div>
</div>

        {{-- Lokasi Jemput --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Penjemputan *</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <input type="text" name="pickup_location" value="{{ old('pickup_location') }}" placeholder="Contoh: Jl. Sudirman No.10, Jakarta" required
                    class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition placeholder-gray-400">
            </div>
        </div>

        {{-- Tujuan --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kota Tujuan *</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                </div>
                <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Contoh: Bandung, Bogor, Cilegon" required
                    class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition placeholder-gray-400">
            </div>
        </div>

        {{-- Jumlah Penumpang --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Penumpang *</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <select
                    name="total_passengers"
                    id="passengerSelect"
                    required
                    class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition appearance-none">
                    <option value="">Pilih jumlah penumpang</option>
                    @for($i = 1; $i <= 8; $i++)
                    <option value="{{ $i }}" {{ old('total_passengers') == $i ? 'selected' : '' }}>{{ $i }} Penumpang</option>
                    @endfor
                </select>
            </div>
        </div>

        {{-- Catatan --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
            <textarea name="catatan" rows="3" placeholder="Contoh: Ada barang besar, jemput di lobby gedung..."
                class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl text-sm bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition placeholder-gray-400 resize-none">{{ old('catatan') }}</textarea>
        </div>

        {{-- Ringkasan harga --}}
        <div class="bg-green-50 border border-green-100 rounded-2xl p-4">
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-gray-600">Total Pembayaran</span>
                <span class="text-green-700 font-extrabold text-xl" id="totalPrice">Rp 300.000</span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Pembayaran dilakukan setelah booking dikonfirmasi admin</p>
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-green-200 text-sm active:scale-95">
            🚗 Konfirmasi Pemesanan
        </button>
    </form>
</div>

{{-- BOTTOM NAV --}}
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-40">
    <div class="max-w-2xl mx-auto px-4 flex justify-around py-1.5">
        <a href="/customer/dashboard" class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-xs font-medium mt-0.5">Home</span>
        </a>
        <a href="/customer/booking" class="flex flex-col items-center p-2 text-green-600">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/></svg>
            <span class="text-xs font-bold mt-0.5">Pesan</span>
        </a>
        <a href="/customer/history" class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
            <span class="text-xs font-medium mt-0.5">Riwayat</span>
        </a>
        <a href="/customer/payment" class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            <span class="text-xs font-medium mt-0.5">Bayar</span>
        </a>
    </div>
</nav>
<div class="h-20"></div>

<script>

    let selectedLayanan = 'reguler';

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    function updatePrice() {

        let passengers =
            parseInt(document.getElementById('passengerSelect').value) || 1;

        let total = 0;

        // REGULER
        if (selectedLayanan === 'reguler') {

            total = 300000 * passengers;

        } else {

            // EKSKLUSIF
            total = 600000;
        }

        document.getElementById('totalPrice').textContent =
            formatRupiah(total);
    }

    function selectLayanan(val) {

        selectedLayanan = val;

        document.getElementById('layananInput').value = val;

        const reguler   = document.getElementById('card-reguler');
        const eksklusif = document.getElementById('card-eksklusif');

        reguler.className =
            'layanan-card cursor-pointer border-2 border-gray-200 bg-white rounded-2xl p-4 transition';

        eksklusif.className =
            'layanan-card cursor-pointer border-2 border-gray-200 bg-white rounded-2xl p-4 transition';

        document.getElementById('check-reguler').classList.add('hidden');
        document.getElementById('check-eksklusif').classList.add('hidden');

        const slotTime = document.getElementById('slot_time');
        const freeTime = document.getElementById('free_time');

        // REGULER
        if (val === 'reguler') {

            document.getElementById('serviceIdInput').value = 1;

            reguler.className =
                'layanan-card cursor-pointer border-2 border-green-500 bg-green-50 rounded-2xl p-4 transition';

            document.getElementById('check-reguler').classList.remove('hidden');
            document.getElementById('check-reguler').classList.add('flex');

            slotTime.classList.remove('hidden');
            freeTime.classList.add('hidden');

            slotTime.setAttribute('name', 'pickup_time');
            slotTime.setAttribute('required', true);

            freeTime.removeAttribute('name');
            freeTime.removeAttribute('required');

        } else {

            // EKSKLUSIF
            document.getElementById('serviceIdInput').value = 2;

            eksklusif.className =
                'layanan-card cursor-pointer border-2 border-yellow-400 bg-yellow-50 rounded-2xl p-4 transition';

            document.getElementById('check-eksklusif').classList.remove('hidden');
            document.getElementById('check-eksklusif').classList.add('flex');

            freeTime.classList.remove('hidden');
            slotTime.classList.add('hidden');

            freeTime.setAttribute('name', 'pickup_time');
            freeTime.setAttribute('required', true);

            slotTime.removeAttribute('name');
            slotTime.removeAttribute('required');
        }

        updatePrice();
    }

    // AUTO UPDATE PRICE
    document.getElementById('passengerSelect')
        .addEventListener('change', updatePrice);

    // INIT
    updatePrice();

</script>
</body>
</html>