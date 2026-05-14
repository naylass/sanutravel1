<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Pembayaran Ditolak</title>
</head>

<body style="margin:0; background:#f3f4f6; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" 
style="background:#ffffff; margin:30px auto; border-radius:12px; overflow:hidden;">

    <!-- HEADER -->
    <tr>
        <td style="background:linear-gradient(135deg,#ef4444,#dc2626); padding:25px; text-align:center;">
            <h2 style="color:white; margin:0;">Sanu Travel</h2>
            <p style="color:#fee2e2; margin:5px 0 0;">
                Status Pembayaran
            </p>
        </td>
    </tr>

    <!-- BODY -->
    <tr>
        <td style="padding:30px;">

            <h2 style="color:#dc2626; margin-top:0;">
                Pembayaran Ditolak ❌
            </h2>

            <p style="margin:10px 0;">
                Halo <b>{{ $payment->booking->customer_name ?? '-' }}</b>,
            </p>

            <p style="margin:10px 0; color:#4b5563;">
                Kami tidak dapat memverifikasi pembayaran untuk booking berikut:
            </p>

            <!-- BOOKING BOX -->
            <div style="background:#f9fafb; padding:15px; border-radius:8px; margin:15px 0;">
                <p style="margin:5px 0;"><b>Kode Booking:</b> {{ $payment->booking->booking_code }}</p>
                <p style="margin:5px 0;"><b>Metode:</b> {{ ucfirst($payment->payment_method) }}</p>
                <p style="margin:5px 0;"><b>Jumlah:</b> Rp {{ number_format($payment->amount,0,',','.') }}</p>
            </div>

            <!-- ALERT -->
            <div style="background:#fef2f2; border-left:4px solid #dc2626; padding:15px; border-radius:6px;">
                <p style="margin:0; color:#991b1b;">
                    Silakan upload ulang bukti pembayaran yang valid agar pesanan Anda dapat diproses.
                </p>
            </div>

            <!-- BUTTON -->
            <div style="text-align:center; margin-top:25px;">
                <a href="{{ url('/payment/'.$payment->id) }}"
                   style="background:#dc2626; color:white; padding:12px 20px; 
                   text-decoration:none; border-radius:6px; font-weight:bold;">
                   Upload Ulang Bukti
                </a>
            </div>

        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="background:#f9fafb; padding:15px; text-align:center; font-size:12px; color:#6b7280;">
            © {{ date('Y') }} Sanu Travel <br>
            Email ini dikirim otomatis, mohon tidak membalas.
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>