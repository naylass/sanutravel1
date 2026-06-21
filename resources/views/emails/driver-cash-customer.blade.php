<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<h2>✅ Pembayaran Cash Berhasil</h2>

<p>
    Halo {{ $payment->booking->customer_name }},
</p>

<p>
    Pembayaran cash Anda telah diterima oleh driver.
</p>

<hr>

<p>
    <strong>Kode Booking:</strong>
    {{ $payment->booking->booking_code }}
</p>

<p>
    <strong>Total Pembayaran:</strong>
    Rp {{ number_format($payment->amount,0,',','.') }}
</p>

<p>
    Status pembayaran Anda sekarang sudah diterima.
</p>

<p>
    Terima kasih telah menggunakan Sanu Travel 🚐
</p>

</body>
</html>