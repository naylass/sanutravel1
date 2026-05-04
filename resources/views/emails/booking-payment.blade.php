<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Berhasil</title>
</head>
<body style="margin:0; padding:0; background:#f3f4f6; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<!-- CONTAINER -->
<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; margin:30px auto; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">

    <!-- HEADER -->
    <tr>
        <td style="background:#16a34a; padding:20px; text-align:center;">
            <h1 style="color:white; margin:0;">Sanu Travel</h1>
            <p style="color:#d1fae5; margin:5px 0 0;">Layanan Travel Terpercaya</p>
        </td>
    </tr>

    <!-- BODY -->
    <tr>
        <td style="padding:30px;">

            <h2 style="color:#16a34a; margin-top:0;">
                Booking Berhasil 🎉
            </h2>

            <p style="font-size:14px; color:#374151;">
                Halo <b>{{ $booking->user->name }}</b>,
            </p>

            <p style="font-size:14px; color:#374151;">
                Terima kasih telah melakukan pemesanan di <b>Sanu Travel</b>.  
                Berikut detail booking kamu:
            </p>

            <!-- CARD DETAIL -->
            <table width="100%" cellpadding="10" cellspacing="0" style="background:#f9fafb; border-radius:8px; margin:20px 0;">
                <tr>
                    <td>Kode Booking</td>
                    <td align="right"><b>{{ $booking->booking_code }}</b></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td align="right">{{ $booking->pickup_date }}</td>
                </tr>
                <tr>
                    <td>Tujuan</td>
                    <td align="right">{{ $booking->destination }}</td>
                </tr>
                <tr>
                    <td>Total Pembayaran</td>
                    <td align="right" style="color:#16a34a; font-size:16px;">
                        <b>Rp {{ number_format($booking->price,0,',','.') }}</b>
                    </td>
                </tr>
            </table>

            <!-- ALERT -->
            <div style="background:#fef2f2; padding:15px; border-radius:8px; border-left:4px solid #ef4444;">
                <p style="margin:0; color:#991b1b; font-size:14px;">
                    ⚠️ Segera lakukan pembayaran agar booking dapat diproses.
                </p>
            </div>

            <!-- BUTTON -->
            <div style="text-align:center; margin:30px 0;">
                <a href="#"
                   style="background:#16a34a; color:white; padding:12px 25px; text-decoration:none; border-radius:8px; font-weight:bold;">
                    Bayar Sekarang
                </a>
            </div>

            <p style="font-size:13px; color:#6b7280;">
                Jika kamu tidak melakukan booking ini, abaikan email ini.
            </p>

        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td style="background:#f9fafb; padding:20px; text-align:center; font-size:12px; color:#6b7280;">
            <p style="margin:0;">
                © {{ date('Y') }} Sanu Travel
            </p>
            <p style="margin:5px 0 0;">
                Jombang, Indonesia
            </p>
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>