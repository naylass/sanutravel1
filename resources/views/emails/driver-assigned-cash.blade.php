<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family:Arial,sans-serif">

<h2>🚐 Tugas Penjemputan Baru</h2>

<p>Halo Driver,</p>

<p>Anda mendapatkan tugas perjalanan baru dengan pembayaran CASH.</p>

<hr>

<p>
<b>Kode Booking:</b>
{{ $booking->booking_code }}
</p>

<p>
<b>Customer:</b>
{{ $booking->customer_name }}
</p>

<p>
<b>No HP:</b>
{{ $booking->phone_number }}
</p>

<p>
<b>Lokasi Jemput:</b>
{{ $booking->pickup_location }}
</p>

<p>
<b>Tujuan:</b>
{{ $booking->destination }}
</p>

<p>
<b>Tanggal:</b>
{{ $booking->pickup_date }}
</p>

<p>
<b>Jam:</b>
{{ $booking->pickup_time }}
</p>

<p>
<b>Total Tagihan:</b>
Rp {{ number_format($booking->total_price,0,',','.') }}
</p>

<hr>

<p>
Silakan lakukan penjemputan sesuai jadwal.
</p>

<p>
Terima kasih 🚐
</p>

</body>
</html>