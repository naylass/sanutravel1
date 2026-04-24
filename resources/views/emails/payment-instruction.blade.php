<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instruksi Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">

    <h2>Halo {{ $booking->user->name ?? 'Customer' }},</h2>

    <p>Terima kasih telah melakukan pemesanan di <b>Sanu Travel</b>.</p>

    <h3>📌 Detail Booking</h3>
    <ul>
        <li><b>Kode Booking:</b> {{ $booking->booking_code }}</li>
        <li><b>Nama Customer:</b> {{ $booking->user->name ?? '-' }}</li>
        <li><b>Layanan:</b> {{ ucfirst($booking->pickup_type) }}</li>
        <li><b>Tanggal:</b> {{ $booking->pickup_date }}</li>
        <li><b>Waktu:</b> {{ $booking->pickup_time }}</li>
        <li><b>Tujuan:</b> {{ $booking->destination }}</li>
        <li><b>Total Penumpang:</b> {{ $booking->total_passengers }}</li>
        <li><b>Total Bayar:</b> Rp {{ number_format($booking->price, 0, ',', '.') }}</li>
    </ul>

    <h3>💳 Instruksi Pembayaran</h3>
    <p>Silakan transfer ke rekening berikut:</p>

    <ul>
        <li><b>Bank:</b> BCA</li>
        <li><b>No Rekening:</b> 1234567890</li>
        <li><b>Atas Nama:</b> PT SANU TRAVEL</li>
    </ul>

    <p>Setelah melakukan pembayaran, silakan upload bukti transfer melalui sistem.</p>

    <p><b>⚠️ Catatan:</b></p>
    <ul>
        <li>Pembayaran harus sesuai dengan nominal</li>
        <li>Booking akan diproses setelah pembayaran diverifikasi</li>
    </ul>

    <br>

    <p>Terima kasih 🙏</p>
    <p><b>Sanu Travel</b></p>

</body>
</html>