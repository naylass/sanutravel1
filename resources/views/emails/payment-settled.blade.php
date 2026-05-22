<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Selesai</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>✅ Pembayaran Selesai</h2>

    <p>Halo {{ $payment->booking->customer_name }},</p>

    <p>
        Pembayaran Anda telah selesai diproses oleh admin.
    </p>

    <hr>

    <p>
        <strong>Kode Booking:</strong>
        {{ $payment->booking->booking_code }}
    </p>

    <p>
        <strong>Total Pembayaran:</strong>
        Rp {{ number_format($payment->booking->total_price,0,',','.') }}
    </p>

    <p>
        <strong>Status:</strong>
        SELESAI
    </p>

    <hr>

    <p>
        Terima kasih telah menggunakan
        <strong>Sanu Travel 🚐</strong>
    </p>

</body>
</html>