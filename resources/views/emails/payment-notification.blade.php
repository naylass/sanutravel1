<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Masuk</title>
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center" style="padding:30px 15px;">

<!-- Container -->
<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden;">

    <!-- Header -->
    <tr>
        <td style="background:#0f172a; color:#ffffff; padding:20px;">
            <h2 style="margin:0;">Sanu Travel - Admin</h2>
            <p style="margin:5px 0 0; font-size:12px; color:#cbd5f5;">
                Notifikasi Pembayaran
            </p>
        </td>
    </tr>

    <!-- Banner -->
    <tr>
        <td style="background:#dcfce7; padding:15px; text-align:center;">
            <span style="color:#16a34a; font-weight:bold; font-size:16px;">
                💳 Pembayaran Masuk
            </span>
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:25px; color:#334155;">

            <p style="margin-top:0;">
                Terdapat pembayaran baru dari customer:
            </p>

            <!-- Customer Info -->
            <div style="background:#f8fafc; border-radius:8px; padding:15px; margin-bottom:15px;">
                <p style="margin:5px 0;"><b>Nama Customer</b><br>
                    {{ $payment->booking->user->name ?? '-' }}
                </p>
            </div>

            <!-- Payment Info -->
            <div style="background:#f8fafc; border-radius:8px; padding:15px; margin-bottom:15px;">

                <p style="margin:5px 0;"><b>Kode Booking</b><br>
                    {{ $payment->booking->booking_code }}
                </p>

                <p style="margin:5px 0;"><b>Metode Pembayaran</b><br>
                    {{ ucfirst($payment->payment_method) }}
                </p>

                <p style="margin:5px 0;"><b>Total Pembayaran</b><br>
                    <span style="font-size:18px; font-weight:bold; color:#16a34a;">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </span>
                </p>

                <p style="margin:5px 0;"><b>Status</b><br>
                    @if($payment->status == 'pending')
                        <span style="color:#f59e0b;"><b>PENDING</b></span>
                    @elseif($payment->status == 'paid')
                        <span style="color:#16a34a;"><b>PAID</b></span>
                    @elseif($payment->status == 'failed')
                        <span style="color:#dc2626;"><b>FAILED</b></span>
                    @else
                        {{ strtoupper($payment->status) }}
                    @endif
                </p>

            </div>

            <!-- Proof -->
            @if($payment->proof_image)
                <div style="background:#fef9c3; border-left:4px solid #facc15; padding:12px; border-radius:6px; margin-bottom:15px;">
                    <b>Bukti Transfer Tersedia</b><br>
                    Silakan cek bukti pembayaran dari customer.
                </div>

                <div style="text-align:center; margin:15px 0;">
                    <a href="{{ asset('storage/'.$payment->proof_image) }}" 
                       target="_blank"
                       style="background:#2563eb; color:#ffffff; padding:10px 18px; text-decoration:none; border-radius:6px; font-size:14px;">
                        Lihat Bukti Transfer
                    </a>
                </div>
            @endif

            <!-- CTA -->
            <div style="text-align:center; margin:25px 0;">
                <a href="#" 
                   style="background:#16a34a; color:#ffffff; padding:12px 20px; text-decoration:none; border-radius:6px; font-size:14px;">
                    Verifikasi Pembayaran
                </a>
            </div>

            <p style="font-size:13px; color:#64748b;">
                Segera lakukan verifikasi untuk mempercepat proses booking customer.
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f1f5f9; padding:20px; text-align:center; font-size:12px; color:#64748b;">
            
            <p style="margin:0;">
                © {{ date('Y') }} Sanu Travel System
            </p>

            <p style="margin:5px 0;">
                Email ini merupakan notifikasi otomatis dari sistem.
            </p>

        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>