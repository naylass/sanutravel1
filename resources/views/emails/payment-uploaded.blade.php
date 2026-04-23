<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pembayaran Diterima</title>
</head>
<body style="font-family: Arial, sans-serif; line-height:1.6;">

    <h2>Halo {{ $payment->booking->user->name ?? 'Customer' }},</h2>

    <p>Bukti pembayaran Anda telah berhasil kami terima.</p>

    <h3>📌 Detail Booking</h3>
    <ul>
        <li><b>Kode Booking:</b> {{ $payment->booking->booking_code }}</li>
        <li><b>Layanan:</b> {{ ucfirst($payment->booking->pickup_type) }}</li>
        <li><b>Tanggal:</b> {{ $payment->booking->pickup_date }}</li>
        <li><b>Waktu:</b> {{ $payment->booking->pickup_time }}</li>
        <li><b>Tujuan:</b> {{ $payment->booking->destination }}</li>
        <li><b>Total:</b> Rp {{ number_format($payment->amount,0,',','.') }}</li>
    </ul>

    <h3>💳 Status Pembayaran</h3>
    <p>Status saat ini: <b>{{ ucfirst($payment->status) }}</b></p>

    @if($payment->proof_image)
        <p>
            <b>Bukti Transfer:</b><br>
            <a href="{{ asset('storage/'.$payment->proof_image) }}" target="_blank">
                Lihat Bukti
            </a>
        </p>
    @endif

    <p>
        Pembayaran akan segera diverifikasi oleh admin.<br>
        Anda akan mendapatkan notifikasi setelah pembayaran dikonfirmasi.
    </p>

    <br>
    <p>Terima kasih 🙏</p>
    <p><b>Sanu Travel</b></p>

</body>
</html>