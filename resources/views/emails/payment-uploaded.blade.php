<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembayaran Diterima</title>
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
            <h2 style="margin:0;">Sanu Travel</h2>
            <p style="margin:5px 0 0; font-size:12px; color:#cbd5f5;">
                Konfirmasi Pembayaran
            </p>
        </td>
    </tr>

    <!-- Banner -->
    <tr>
        <td style="background:#dcfce7; padding:15px; text-align:center;">
            <span style="color:#16a34a; font-weight:bold; font-size:16px;">
                ✅ Pembayaran Berhasil Diterima
            </span>
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:25px; color:#334155;">

            <p style="margin-top:0;">
                Halo <b>{{ $payment->booking->user->name ?? 'Customer' }}</b>,
            </p>

            <p>
                Kami telah menerima pembayaran Anda. Berikut detail transaksi Anda:
            </p>

            <!-- Booking Info -->
            <div style="background:#f8fafc; border-radius:8px; padding:15px; margin:20px 0;">

                <p style="margin:5px 0;"><b>Kode Booking</b><br>
                    {{ $payment->booking->booking_code }}
                </p>

                <p style="margin:5px 0;"><b>Layanan</b><br>
                    {{ $payment->booking->service->name 
                        ?? ($payment->booking->pickup_type ? ucfirst($payment->booking->pickup_type) : '-') }}
                </p>

                <p style="margin:5px 0;"><b>Tanggal</b><br>
                    {{ \Carbon\Carbon::parse($payment->booking->pickup_date)->format('d M Y') }}
                </p>

                <p style="margin:5px 0;"><b>Waktu</b><br>
                    {{ $payment->booking->pickup_time }}
                </p>

                <p style="margin:5px 0;"><b>Tujuan</b><br>
                    {{ $payment->booking->destination }}
                </p>

                <p style="margin:5px 0;"><b>Total Pembayaran</b><br>
                    <span style="font-size:18px; font-weight:bold; color:#16a34a;">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </span>
                </p>

            </div>

            <!-- Payment Status -->
            <div style="margin-bottom:15px;">
                <b>Status Pembayaran:</b><br>

                @if($payment->status == 'pending')
                    <span style="color:#f59e0b; font-weight:bold;">PENDING</span>
                @elseif($payment->status == 'paid')
                    <span style="color:#16a34a; font-weight:bold;">PAID</span>
                @elseif($payment->status == 'failed')
                    <span style="color:#dc2626; font-weight:bold;">FAILED</span>
                @else
                    {{ strtoupper($payment->status) }}
                @endif
            </div>

            <!-- Proof -->
            @if($payment->proof_image)
                <div style="background:#fef9c3; border-left:4px solid #facc15; padding:12px; border-radius:6px; margin:15px 0;">
                    Kami telah menyimpan bukti pembayaran Anda.
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
                   style="background:#0f172a; color:#ffffff; padding:12px 20px; text-decoration:none; border-radius:6px; font-size:14px;">
                    Lihat Detail Booking
                </a>
            </div>

            <p style="font-size:13px; color:#64748b;">
                Terima kasih telah menggunakan layanan Sanu Travel. Kami akan segera memproses perjalanan Anda.
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f1f5f9; padding:20px; text-align:center; font-size:12px; color:#64748b;">
            © {{ date('Y') }} Sanu Travel System
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>