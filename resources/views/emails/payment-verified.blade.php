<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Pembayaran Berhasil</title>
</head>

<body style="margin:0; background:#f3f4f6; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0"
style="background:#ffffff; margin:30px auto; border-radius:12px; overflow:hidden;">

    <!-- HEADER -->
    <tr>
        <td style="background:linear-gradient(135deg,#16a34a,#15803d); padding:25px; text-align:center;">
            <h2 style="color:white; margin:0;">Sanu Travel</h2>
            <p style="color:#d1fae5; margin:5px 0 0;">
                Status Pembayaran
            </p>
        </td>
    </tr>

    <!-- BODY -->
    <tr>
        <td style="padding:30px;">

            <h2 style="color:#15803d; margin-top:0;">
                Pembayaran Berhasil ✅
            </h2>

            <p>Halo <b>{{ $payment->booking->user->name }}</b>,</p>

            <p style="color:#4b5563;">
                Pembayaran Anda telah berhasil diverifikasi. Booking Anda sekarang sudah dikonfirmasi.
            </p>

            <!-- BOOKING INFO -->
            <div style="background:#f9fafb; padding:15px; border-radius:8px; margin-top:20px;">
                <p style="margin:6px 0;"><b>Kode Booking:</b> {{ $payment->booking->booking_code }}</p>
                <p style="margin:6px 0;"><b>Metode:</b> {{ ucfirst($payment->payment_method) }}</p>
                <p style="margin:6px 0;"><b>Tanggal Bayar:</b> 
                    {{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y H:i') }}
                </p>
            </div>

            <!-- TOTAL -->
            <div style="margin-top:20px; text-align:center;">
                <p style="margin:0; color:#6b7280;">Total Pembayaran</p>
                <h2 style="margin:5px 0; color:#16a34a;">
                    Rp {{ number_format($payment->amount,0,',','.') }}
                </h2>
            </div>

            <!-- INFO TAMBAHAN -->
            <div style="background:#ecfdf5; border-left:4px solid #16a34a; padding:15px; border-radius:6px; margin-top:20px;">
                <p style="margin:0; color:#065f46;">
                    E-ticket / invoice Anda tersedia dalam bentuk PDF pada lampiran email ini.
                </p>
            </div>

            <!-- BUTTON -->
            <div style="text-align:center; margin-top:25px;">
                <a href="{{ url('/booking/'.$payment->booking->id) }}"
                   style="background:#16a34a; color:white; padding:12px 20px; 
                   text-decoration:none; border-radius:6px; font-weight:bold;">
                   Lihat Detail Booking
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