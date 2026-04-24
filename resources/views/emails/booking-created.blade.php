<!DOCTYPE html>
<html>
<body>

<h2>📥 Booking Baru Masuk</h2>

<p>Ada booking baru dari customer:</p>

<ul>
    <li><b>Kode:</b> {{ $booking->booking_code }}</li>
    <li><b>Nama:</b> {{ $booking->user->name ?? '-' }}</li>
    <li><b>Layanan:</b> {{ ucfirst($booking->pickup_type) }}</li>
    <li><b>Tanggal:</b> {{ $booking->pickup_date }}</li>
    <li><b>Jam:</b> {{ $booking->pickup_time }}</li>
    <li><b>Tujuan:</b> {{ $booking->destination }}</li>
    <li><b>Penumpang:</b> {{ $booking->total_passengers }}</li>
</ul>

<p>Silakan cek di sistem admin.</p>

</body>
</html>