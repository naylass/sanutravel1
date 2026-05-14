<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Travel — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        input, select { -webkit-appearance: none; appearance: none; }
        input:focus, select:focus { outline: none; }
        .service-card { transition: all 0.2s ease; cursor: pointer; }
        .service-card:active { transform: scale(0.97); }
    </style>
</head>

<body class="bg-slate-100 min-h-screen pb-10">

{{-- STICKY HEADER --}}
<header class="bg-white/90 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="/" class="flex items-center gap-2 text-slate-500 hover:text-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="text-sm font-semibold">Beranda</span>
        </a>
        <span class="font-bold text-slate-800">Booking Travel</span>
        <div class="w-16"></div>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 py-6">

    <form method="POST" action="{{ route('booking.create') }}" class="space-y-5">
        @csrf

        {{-- SERVICE --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Pilih Layanan</p>
            <div class="grid grid-cols-2 gap-3">

                <label class="service-card">
                    <input type="radio" name="service_id" value="1" checked hidden onchange="setService('reguler')">
                    <div id="regulerCard" class="border-2 border-slate-800 bg-slate-800 text-white p-4 rounded-2xl">
                        <div class="text-2xl mb-2">🚐</div>
                        <p class="font-bold text-sm">Reguler</p>
                        <p class="text-slate-300 text-xs mt-0.5">Rp 300.000/orang</p>
                    </div>
                </label>

                <label class="service-card">
                    <input type="radio" name="service_id" value="2" hidden onchange="setService('eksklusif')">
                    <div id="eksklusifCard" class="border-2 border-slate-200 bg-white p-4 rounded-2xl">
                        <div class="text-2xl mb-2">✨</div>
                        <p class="font-bold text-sm text-slate-700">Eksklusif</p>
                        <p class="text-slate-400 text-xs mt-0.5">Rp 600.000</p>
                    </div>
                </label>

            </div>
        </div>

        {{-- AREA & JADWAL --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 space-y-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Jadwal & Area</p>

            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Area Jemput</label>
                <div class="relative">
                    <select name="area" id="areaSelect"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 pr-10"
                            onchange="updateTotal()" required>
                        <option value="">Pilih Area</option>
                        <option value="cilegon">Cilegon</option>
                        <option value="serang">Serang</option>
                        <option value="lainnya">Luar Area (+50.000)</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Tanggal</label>
                <input type="date" name="pickup_date"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300"
                       required>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Jam Keberangkatan</label>
                <div class="relative">
                    <select name="pickup_time" id="timeSelect"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 pr-10">
                        <option value="">Pilih Jam</option>
                        <option value="08:00:00">08:00 WIB</option>
                        <option value="12:00:00">12:00 WIB</option>
                        <option value="15:00:00">15:00 WIB</option>
                        <option value="18:00:00">18:00 WIB</option>
                        <option value="22:00:00">22:00 WIB</option>
                        <option value="00:00:00">00:00 WIB</option>
                        <option value="03:00:00">03:00 WIB</option>
                        <option value="06:00:00">06:00 WIB</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
                <input type="time" name="custom_time" id="customTime"
                       class="hidden w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 mt-2">
            </div>
        </div>

        {{-- DATA DIRI --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 space-y-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Data Penumpang</p>

            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Nama Lengkap</label>
                <input type="text" name="customer_name" placeholder="Masukkan nama lengkap"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Email</label>
                <input type="email" name="email" placeholder="email@contoh.com"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Nomor WhatsApp</label>
                <input type="text" name="phone_number" placeholder="628xxxxxxxxxx"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
        </div>

        {{-- LOKASI --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 space-y-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Lokasi</p>

            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Alamat Penjemputan</label>
                <input type="text" name="pickup_location" placeholder="Masukkan alamat lengkap"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 block mb-1.5">Tujuan</label>
                <input type="text" name="destination" placeholder="Tujuan perjalanan"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
        </div>

        {{-- PASSENGER --}}
        <div id="passengerBox" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Jumlah Penumpang</p>
            <div class="relative">
                <select name="total_passengers"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 pr-10"
                        onchange="updateTotal()">
                    @for($i=1; $i<=8; $i++)
                        <option value="{{ $i }}">{{ $i }} orang</option>
                    @endfor
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        {{-- TOTAL + SUBMIT --}}
        <div class="bg-slate-800 rounded-3xl p-5">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <p class="text-slate-400 text-xs font-medium mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-extrabold text-white" id="total">Rp 300.000</p>
                </div>
                <div class="text-3xl">🧾</div>
            </div>
            <button type="submit"
                    class="w-full bg-white hover:bg-slate-100 active:scale-98 text-slate-800 py-4 rounded-2xl font-extrabold text-sm transition-all">
                Booking Sekarang →
            </button>
        </div>

    </form>
</div>

<script>
let service = 'reguler';

function setService(type) {
    service = type;
    const regulerCard = document.getElementById('regulerCard');
    const eksklusifCard = document.getElementById('eksklusifCard');

    if (type === 'reguler') {
        regulerCard.className = 'border-2 border-slate-800 bg-slate-800 text-white p-4 rounded-2xl';
        eksklusifCard.className = 'border-2 border-slate-200 bg-white p-4 rounded-2xl';
        document.getElementById('passengerBox').style.display = 'block';
        document.getElementById('timeSelect').classList.remove('hidden');
        document.getElementById('customTime').classList.add('hidden');
    } else {
        regulerCard.className = 'border-2 border-slate-200 bg-white p-4 rounded-2xl';
        eksklusifCard.className = 'border-2 border-amber-400 bg-amber-50 p-4 rounded-2xl';
        document.getElementById('passengerBox').style.display = 'none';
        document.getElementById('timeSelect').classList.add('hidden');
        document.getElementById('customTime').classList.remove('hidden');
    }
    updateTotal();
}

function updateTotal() {
    let pax = document.querySelector('[name="total_passengers"]')?.value || 1;
    let area = document.getElementById('areaSelect').value;
    let base = service === 'reguler' ? 300000 * pax : 600000;
    let fee = (area === 'lainnya') ? 50000 : 0;
    document.getElementById('total').innerText = 'Rp ' + (base + fee).toLocaleString('id-ID');
}
</script>

</body>
</html>