<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        input, select { -webkit-appearance: none; appearance: none; }
        input:focus, select:focus { outline: none; }
        .file-drop { border: 2px dashed #e2e8f0; transition: border-color 0.2s, background 0.2s; }
        .file-drop:hover { border-color: #94a3b8; background: #f8fafc; }
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
        <span class="font-bold text-slate-800">Pembayaran</span>
        <div class="w-16"></div>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 py-6 space-y-5">

    {{-- ALERTS --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3.5 flex items-center gap-3">
        <span class="text-xl">✅</span>
        <p class="text-emerald-700 font-semibold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-2xl px-4 py-3.5 flex items-center gap-3">
        <span class="text-xl">❌</span>
        <p class="text-red-700 font-semibold text-sm">{{ session('error') }}</p>
    </div>
    @endif

    {{-- SEARCH FORM --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
        <h2 class="text-base font-bold text-slate-800 mb-4">Cari Booking</h2>
        <form method="GET" action="{{ route('payment.check') }}" class="space-y-3">
            <div>
                <label class="text-sm font-semibold text-slate-600 block mb-1.5">Kode Booking</label>
                <input type="text" name="booking_code" value="{{ request('booking_code') }}"
                       placeholder="BOOK-XXXX"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-600 block mb-1.5">Nomor HP</label>
                <input type="text" name="phone_number" value="{{ request('phone_number') }}"
                       placeholder="08xxxx"
                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 placeholder-slate-300"
                       required>
            </div>
            <button class="w-full bg-slate-800 hover:bg-slate-700 active:scale-98 text-white py-4 rounded-2xl font-bold text-sm transition-all mt-1">
                🔍 Cari Booking
            </button>
        </form>
    </div>

    {{-- EMPTY STATE --}}
    @if(request()->filled('booking_code') && request()->filled('phone_number') && $bookings->count() == 0)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 text-center py-16 px-6">
        <div class="text-5xl mb-4">😢</div>
        <h2 class="font-bold text-slate-700 text-lg mb-2">Booking Tidak Ditemukan</h2>
        <p class="text-slate-400 text-sm">Pastikan kode booking dan nomor HP benar</p>
    </div>
    @endif

    {{-- BOOKING LIST --}}
    @foreach($bookings as $booking)
    @php
        $payment = $booking->payment;
        $status = $payment?->status ?? 'unpaid';
    @endphp

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-slate-600 to-slate-400"></div>

        <div class="p-5">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-5">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Kode Booking</p>
                    <h2 class="font-extrabold text-slate-800 text-lg">{{ $booking->booking_code }}</h2>
                </div>
                @if($status == 'unpaid')
                    <span class="bg-red-50 text-red-600 border border-red-100 text-xs font-bold px-3 py-1.5 rounded-full">Belum Bayar</span>
                @elseif($status == 'waiting_verification')
                    <span class="bg-amber-50 text-amber-600 border border-amber-100 text-xs font-bold px-3 py-1.5 rounded-full">⏳ Menunggu Verifikasi</span>
                @elseif($status == 'verified')
                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-bold px-3 py-1.5 rounded-full">✅ Verified</span>
                @elseif($status == 'rejected')
                    <span class="bg-red-50 text-red-600 border border-red-100 text-xs font-bold px-3 py-1.5 rounded-full">❌ Ditolak</span>
                @elseif($status == 'waiting_driver_collection')
                    <span class="bg-orange-50 text-orange-600 border border-orange-100 text-xs font-bold px-3 py-1.5 rounded-full">🔄 Bayar ke Driver</span>
                @elseif($status == 'cash_received')
                    <span class="bg-blue-50 text-blue-600 border border-blue-100 text-xs font-bold px-3 py-1.5 rounded-full">💵 Cash Diterima</span>
                @elseif($status == 'settled')
                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 text-xs font-bold px-3 py-1.5 rounded-full">✅ Selesai</span>
                @endif
            </div>

            {{-- Detail --}}
            <div class="grid grid-cols-2 gap-3 mb-5">
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Nama Customer</p>
                    <p class="font-bold text-slate-700 text-sm">{{ $booking->customer_name }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Tujuan</p>
                    <p class="font-bold text-slate-700 text-sm">{{ $booking->destination }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Jadwal</p>
                    <p class="font-bold text-slate-700 text-xs">
                        {{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }} · {{ substr($booking->pickup_time,0,5) }}
                    </p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-3.5">
                    <p class="text-xs text-slate-400 mb-1">Total</p>
                    <p class="font-extrabold text-slate-800 text-sm">Rp {{ number_format($booking->total_price,0,',','.') }}</p>
                </div>
            </div>

            {{-- FORM UPLOAD --}}
            @if(in_array($status, ['unpaid', 'rejected']))
            <form method="POST"
                  action="{{ route('payment.upload', $booking->id) }}"
                  enctype="multipart/form-data"
                  class="space-y-4">
                @csrf

                {{-- Method select --}}
                <div>
                    <label class="text-sm font-bold text-slate-700 block mb-1.5">Metode Pembayaran</label>
                    <div class="relative">
                        <select name="payment_method"
                                id="payment_method_{{ $booking->id }}"
                                onchange="togglePayment({{ $booking->id }})"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-slate-300 pr-10">
                            <option value="qris">📱 QRIS / Transfer</option>
                            <option value="cash">💵 Cash</option>
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                {{-- QRIS --}}
                <div id="qrisSection_{{ $booking->id }}" class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                    <h3 class="font-bold text-slate-800 mb-4 text-sm">📱 Scan QR untuk Pembayaran</h3>
                    <div class="bg-white rounded-2xl p-4 text-center border border-slate-100">
                        <img src="{{ asset('images/qris.png') }}" class="w-56 mx-auto rounded-xl">
                        <p class="text-xs text-slate-400 mt-4 mb-3">Scan menggunakan:</p>
                        <div class="flex flex-wrap justify-center gap-2">
                            @foreach(['DANA','OVO','GoPay','Mobile Banking'] as $app)
                            <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-medium">{{ $app }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- CASH --}}
                <div id="cashSection_{{ $booking->id }}" class="hidden bg-amber-50 border border-amber-100 rounded-2xl p-4">
                    <div class="flex gap-3 items-start">
                        <span class="text-xl">💵</span>
                        <div>
                            <p class="font-bold text-amber-800 text-sm">Pembayaran Cash</p>
                            <p class="text-amber-700 text-xs mt-1 leading-relaxed">Pembayaran dilakukan langsung kepada driver saat penjemputan.</p>
                        </div>
                    </div>
                </div>

                {{-- UPLOAD --}}
                <div id="uploadSection_{{ $booking->id }}">
                    <label class="text-sm font-bold text-slate-700 block mb-1.5">Upload Bukti Pembayaran</label>
                    <div class="file-drop rounded-2xl p-6 text-center bg-white cursor-pointer"
                         onclick="document.getElementById('fileInput_{{ $booking->id }}').click()">
                        <div class="text-3xl mb-2" id="uploadIcon_{{ $booking->id }}">📁</div>
                        <p class="text-sm font-semibold text-slate-500" id="uploadText_{{ $booking->id }}">Klik untuk upload bukti</p>
                        <img id="preview_{{ $booking->id }}" class="hidden mt-4 rounded-xl mx-auto max-h-44 object-contain">
                    </div>
                    <input type="file" id="fileInput_{{ $booking->id }}" name="payment_proof"
                           class="hidden" accept="image/*"
                           onchange="previewFile(this, {{ $booking->id }})">
                </div>

                <button class="w-full bg-slate-800 hover:bg-slate-700 active:scale-98 text-white py-4 rounded-2xl font-bold text-sm transition-all">
                    Konfirmasi Pembayaran
                </button>

            </form>
            @endif
        </div>
    </div>
    @endforeach

</div>

<script>
function togglePayment(id) {
    const method = document.getElementById('payment_method_' + id).value;
    const qris = document.getElementById('qrisSection_' + id);
    const cash = document.getElementById('cashSection_' + id);
    const upload = document.getElementById('uploadSection_' + id);

    if (method === 'cash') {
        qris.classList.add('hidden');
        cash.classList.remove('hidden');
        upload.classList.add('hidden');
    } else {
        qris.classList.remove('hidden');
        cash.classList.add('hidden');
        upload.classList.remove('hidden');
    }
}

function previewFile(input, id) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview_' + id).src = e.target.result;
        document.getElementById('preview_' + id).classList.remove('hidden');
        document.getElementById('uploadText_' + id).innerText = file.name;
        document.getElementById('uploadIcon_' + id).innerText = '🖼️';
    };
    reader.readAsDataURL(file);
}
</script>

</body>
</html>