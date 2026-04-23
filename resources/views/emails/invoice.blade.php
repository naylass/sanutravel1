<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; line-height:1.6;">

    <h2>🧾 INVOICE</h2>

    <p><b>Sanu Travel</b></p>
    <hr>

    <h3>📌 Data Customer</h3>
    <ul>
        <li><b>Nama:</b> {{ $payment->booking->user->name ?? '-' }}</li>
        <li><b>No HP:</b> {{ $payment->booking->phone_number }}</li>
    </ul>

    <h3>📦 Detail Booking</h3>
    <ul>
        <li><b>Kode Booking:</b> {{ $payment->booking->booking_code }}</li>
        <li><b>Layanan:</b> {{ ucfirst($payment->booking->pickup_type) }}</li>
        <li><b>Tanggal:</b> {{ $payment->booking->pickup_date }}</li>
        <li><b>Waktu:</b> {{ $payment->booking->pickup_time }}</li>
        <li><b>Tujuan:</b> {{ $payment->booking->destination }}</li>
        <li><b>Penumpang:</b> {{ $payment->booking->total_passengers }}</li>
    </ul>

    <h3>💳 Detail Pembayaran</h3>
    <ul>
        <li><b>Metode:</b> {{ ucfirst($payment->payment_method) }}</li>
        <li><b>Tanggal Bayar:</b> {{ $payment->payment_date }}</li>
        <li><b>Status:</b> {{ ucfirst($payment->status) }}</li>
    </ul>

    <h2>
        Total: Rp {{ number_format($payment->amount,0,',','.') }}
    </h2>

    <hr>

    <p>
        <b>Keterangan:</b><br>
        Pembayaran telah diterima dan dikonfirmasi.<br>
        Terima kasih telah menggunakan layanan kami.
    </p>

    <br>
    <p><b>Sanu Travel</b></p>

</body>
</html>