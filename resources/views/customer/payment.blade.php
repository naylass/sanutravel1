<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran — Sanu Travel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .drop-zone {
            border: 2.5px dashed #bbf7d0;
            transition: all .2s;
        }

        .drop-zone:hover,
        .drop-zone.dragover {
            border-color: #16a34a;
            background: #f0fdf4;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

{{-- HEADER --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-40 shadow-sm">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">

        <a href="/customer/dashboard"
            class="flex items-center gap-2 text-gray-500 hover:text-green-600 transition">

            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />

            </svg>

            <span class="text-sm font-medium">
                Kembali
            </span>
        </a>

        <span class="font-bold text-gray-800">
            Pembayaran
        </span>

        <form method="POST" action="/logout">
            @csrf

            <button type="submit"
                onclick="return confirm('Yakin keluar?')"
                class="text-xs text-gray-400 hover:text-red-500 transition font-medium py-1.5 px-2 rounded-xl hover:bg-red-50">

                Keluar

            </button>
        </form>
    </div>
</header>

{{-- VALIDASI JIKA TIDAK ADA BOOKING --}}
@if(!$booking)

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

    <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm">

        <div class="text-5xl mb-4">
            📭
        </div>

        <h2 class="font-bold text-gray-800 text-lg mb-2">
            Tidak ada pembayaran
        </h2>

        <p class="text-gray-500 text-sm mb-5">
            Kamu belum memiliki booking yang menunggu pembayaran.
        </p>

        <a href="/customer/booking"
            class="bg-green-600 text-white px-5 py-3 rounded-2xl font-bold text-sm inline-block">

            Booking Sekarang

        </a>

    </div>

</div>

@else

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 space-y-5">

    {{-- SUCCESS --}}
    @if(session('success'))

    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex gap-3 items-center">

        <span class="text-2xl">
            ✅
        </span>

        <p class="text-green-700 text-sm font-medium">
            {{ session('success') }}
        </p>

    </div>

    @endif

    {{-- ERROR --}}
    @if($errors->any())

    <div class="bg-red-50 border border-red-200 rounded-2xl p-4">

        @foreach($errors->all() as $e)

        <p class="text-red-700 text-sm">
            • {{ $e }}
        </p>

        @endforeach

    </div>

    @endif

    {{-- RINGKASAN --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">

        <h2 class="font-bold text-gray-800 mb-4 flex items-center gap-2">

            <span class="w-8 h-8 bg-green-50 rounded-xl flex items-center justify-center text-base">
                📄
            </span>

            Ringkasan Pesanan

        </h2>

        <div class="space-y-2.5">

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">
                    Kode Booking
                </span>

                <span class="font-semibold text-gray-800">
                    {{ $booking->booking_code }}
                </span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">
                    Penjemputan
                </span>

                <span class="font-semibold text-gray-800 text-right max-w-[60%]">
                    {{ $booking->pickup_location }}
                </span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">
                    Tujuan
                </span>

                <span class="font-semibold text-gray-800">
                    {{ $booking->destination }}
                </span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">
                    Tanggal
                </span>

                <span class="font-semibold text-gray-800">
                    {{ \Carbon\Carbon::parse($booking->pickup_date)->translatedFormat('d F Y') }}
                </span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">
                    Jam
                </span>

                <span class="font-semibold text-gray-800">
                    {{ $booking->pickup_time }}
                </span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">
                    Layanan
                </span>

                <span class="font-semibold text-gray-800 capitalize">
                    {{ $booking->pickup_type }}
                </span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">
                    Penumpang
                </span>

                <span class="font-semibold text-gray-800">
                    {{ $booking->total_passengers }} orang
                </span>
            </div>

            <div class="border-t border-gray-100 pt-3 flex justify-between items-center">

                <span class="font-bold text-gray-800">
                    Total Pembayaran
                </span>

                <span class="font-extrabold text-green-700 text-2xl">

                    Rp {{ number_format($booking->price,0,',','.') }}

                </span>
            </div>
        </div>
    </div>

    {{-- REKENING --}}
    <div class="bg-green-50 border border-green-200 rounded-2xl p-5">

        <h3 class="font-bold text-green-800 mb-3 flex items-center gap-2">

            <span class="text-xl">
                🏦
            </span>

            Transfer ke Rekening Berikut

        </h3>

        <div class="space-y-2">

            <div class="flex justify-between text-sm">
                <span class="text-green-700">Bank</span>
                <span class="font-bold text-green-900">BCA</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-green-700">No. Rekening</span>
                <span class="font-bold text-green-900">1234567890</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-green-700">Atas Nama</span>
                <span class="font-bold text-green-900">SANU TRAVEL</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-green-700">Nominal</span>

                <span class="font-bold text-green-900">

                    Rp {{ number_format($booking->price,0,',','.') }}

                </span>
            </div>
        </div>

        <div class="mt-3 bg-green-100 rounded-xl p-3 text-xs text-green-700 flex gap-2">

            <span class="flex-shrink-0">
                ⚠️
            </span>

            Harap transfer tepat nominal untuk mempercepat verifikasi admin.

        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">

        <h2 class="font-bold text-gray-800 mb-4 flex items-center gap-2">

            <span class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-base">
                📤
            </span>

            Upload Bukti Pembayaran

        </h2>

        <form method="POST"
            action="{{ route('customer.payment.upload') }}"
            enctype="multipart/form-data">

            @csrf

            <input type="hidden"
                name="booking_id"
                value="{{ $booking->id }}">

            {{-- DROP ZONE --}}
            <div class="drop-zone rounded-2xl p-8 text-center mb-4 cursor-pointer bg-gray-50"
                id="dropZone"
                onclick="document.getElementById('fileInput').click()"
                ondragover="event.preventDefault();this.classList.add('dragover')"
                ondragleave="this.classList.remove('dragover')"
                ondrop="handleDrop(event)">

                <div id="uploadPlaceholder">

                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3 text-3xl">
                        📁
                    </div>

                    <p class="font-bold text-gray-700 text-sm mb-1">
                        Klik atau drag & drop file di sini
                    </p>

                    <p class="text-xs text-gray-400">
                        Format: JPG, PNG · Maks. 2MB
                    </p>

                </div>

                <div id="previewContainer" class="hidden">

                    <img id="imgPreview"
                        src=""
                        alt="Preview"
                        class="max-h-48 mx-auto rounded-xl object-cover mb-3">

                    <p id="fileNameLabel"
                        class="text-sm font-semibold text-green-700"></p>

                </div>

                <input type="file"
                    id="fileInput"
                    name="bukti_pembayaran"
                    accept="image/*"
                    class="hidden"
                    required
                    onchange="handleFile(this.files[0])">

            </div>

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-green-200 text-sm active:scale-95">

                📤 Kirim Bukti Pembayaran

            </button>
        </form>
    </div>
</div>

@endif

{{-- BOTTOM NAV --}}
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-40">

    <div class="max-w-2xl mx-auto px-4 flex justify-around py-1.5">

        <a href="/customer/dashboard"
            class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">

            <span class="text-xs mt-0.5">Home</span>
        </a>

        <a href="/customer/booking"
            class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">

            <span class="text-xs mt-0.5">Pesan</span>
        </a>

        <a href="/customer/history"
            class="flex flex-col items-center p-2 text-gray-400 hover:text-green-600">

            <span class="text-xs mt-0.5">Riwayat</span>
        </a>

        <a href="/customer/payment"
            class="flex flex-col items-center p-2 text-green-600">

            <span class="text-xs font-bold mt-0.5">Bayar</span>
        </a>

    </div>
</nav>

<div class="h-20"></div>

<script>

    function handleFile(file)
    {
        if (!file) return;

        document
            .getElementById('uploadPlaceholder')
            .classList.add('hidden');

        document
            .getElementById('previewContainer')
            .classList.remove('hidden');

        document
            .getElementById('fileNameLabel')
            .textContent = file.name;

        const reader = new FileReader();

        reader.onload = function(e)
        {
            document
                .getElementById('imgPreview')
                .src = e.target.result;
        };

        reader.readAsDataURL(file);
    }

    function handleDrop(e)
    {
        e.preventDefault();

        document
            .getElementById('dropZone')
            .classList.remove('dragover');

        const file = e.dataTransfer.files[0];

        if (file)
        {
            const dt = new DataTransfer();

            dt.items.add(file);

            document.getElementById('fileInput').files = dt.files;

            handleFile(file);
        }
    }

</script>

</body>
</html>