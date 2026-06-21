<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<h2>💵 Cash Diterima Driver</h2>

<p>
    Driver telah menerima pembayaran cash dari customer.
</p>

<hr>

<p>
    <strong>Kode Booking:</strong>
    {{ $payment->booking->booking_code }}
</p>

<p>
    <strong>Customer:</strong>
    {{ $payment->booking->customer_name }}
</p>

<p>
    <strong>Total:</strong>
    Rp {{ number_format($payment->amount,0,',','.') }}
</p>

<p>
    <strong>Waktu:</strong>
    {{ $payment->driver_received_at }}
</p>

<p>
    Bukti pembayaran driver terlampir pada email ini.
</p>

</body>
</html>