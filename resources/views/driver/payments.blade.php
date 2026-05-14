<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Collection — Sanu Travel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .file-drop {
            border: 2px dashed #e2e8f0;
            transition: border-color 0.2s, background 0.2s;
        }
        .file-drop:hover { border-color: #94a3b8; background: #f8fafc; }
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
        <span class="font-bold text-slate-800">Cash Collection</span>
        <div class="w-16"></div>
    </div>
</header>

<div class="max-w-2xl mx-auto px-4 py-6 space-y-4">

    {{-- SUCCESS --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3.5 flex items-center gap-3">
        <span class="text-xl">✅</span>
        <p class="text-emerald-700 font-semibold text-sm">{{ session('success') }}</p>
    </div>
    @endif

    {{-- PAGE TITLE --}}
    <div class="pt-2">
        <h1 class="text-xl font-extrabold text-slate-800">Cash Collection Driver</h1>
        <p class="text-slate-400 text-sm mt-1">Upload bukti penerimaan cash dari customer</p>
    </div>

    @foreach($payments as $payment)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="h-1.5 bg-gradient-to-r from-amber-400 to-orange-400"></div>

        <div class="p-5">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-5">
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-1">Kode Booking</p>
                    <h2 class="font-extrabold text-slate-800 text-lg">{{ $payment->booking->booking_code }}</h2>
                    <p class="text-slate-500 text-sm mt-1">{{ $payment->booking->customer_name }}</p>
                </div>
                <span class="bg-amber-50 text-amber-600 border border-amber-100 text-xs font-bold px-3 py-1.5 rounded-full">
                    ⏳ Waiting Cash
                </span>
            </div>

            {{-- Detail --}}
            <div class="grid grid-cols-2 gap-3 mb-5">
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-xs text-slate-400 font-medium mb-1">Tujuan</p>
                    <p class="font-bold text-slate-700 text-sm leading-snug">{{ $payment->booking->destination }}</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-4">
                    <p class="text-xs text-slate-400 font-medium mb-1">Total</p>
                    <p class="font-extrabold text-slate-800">Rp {{ number_format($payment->amount,0,',','.') }}</p>
                </div>
            </div>

            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('driver.payment.receive', $payment->id) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Upload Bukti Cash
                    </label>
                    <div class="file-drop rounded-2xl p-5 text-center cursor-pointer"
                         onclick="document.getElementById('driverProof_{{ $payment->id }}').click()">
                        <div class="text-3xl mb-2" id="dropIcon_{{ $payment->id }}">📁</div>
                        <p class="text-sm font-semibold text-slate-500" id="dropLabel_{{ $payment->id }}">
                            Klik untuk upload foto bukti
                        </p>
                        <img id="dropPreview_{{ $payment->id }}" class="hidden mt-4 rounded-xl mx-auto max-h-40 object-contain">
                    </div>
                    <input type="file"
                           id="driverProof_{{ $payment->id }}"
                           name="driver_proof"
                           class="hidden"
                           accept="image/*"
                           required
                           onchange="previewDriverProof(this, {{ $payment->id }})">
                </div>

                <button class="w-full bg-slate-800 hover:bg-slate-700 active:scale-98 text-white py-4 rounded-2xl font-bold text-sm transition-all">
                    ✅ Sudah Terima Cash
                </button>
            </form>
        </div>
    </div>
    @endforeach

    @if($payments->count() == 0)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 text-center py-20 px-6">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-5 text-4xl">💰</div>
        <h2 class="font-bold text-slate-700 text-lg mb-2">Tidak Ada Cash Collection</h2>
        <p class="text-slate-400 text-sm">Belum ada pembayaran cash yang perlu dikonfirmasi</p>
    </div>
    @endif

</div>

<script>
function previewDriverProof(input, id) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('dropPreview_' + id).src = e.target.result;
        document.getElementById('dropPreview_' + id).classList.remove('hidden');
        document.getElementById('dropLabel_' + id).innerText = file.name;
        document.getElementById('dropIcon_' + id).innerText = '🖼️';
    };
    reader.readAsDataURL(file);
}
</script>

</body>
</html>