<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Pembatalan Booking</title>
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
                                Notifikasi Sistem
                            </p>
                        </td>
                    </tr>

                    <!-- Status Banner -->
                    <tr>
                        <td style="background:#fef3c7; padding:15px; text-align:center;">
                            <span style="color:#b45309; font-weight:bold; font-size:16px;">
                                ⚠️ Pengajuan Pembatalan Booking
                            </span>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:25px; color:#334155;">

                            <p style="margin-top:0;">
                                Terdapat pengajuan pembatalan booking dari customer:
                            </p>

                            <!-- Customer Info -->
                            <div style="background:#f8fafc; border-radius:8px; padding:15px; margin-bottom:15px;">
                                <p style="margin:5px 0;"><b>Nama Customer</b><br>
                                    {{ $booking->user->name }}
                                </p>

                                <p style="margin:5px 0;"><b>Email</b><br>
                                    {{ $booking->user->email }}
                                </p>
                            </div>

                            <!-- Booking Info -->
                            <div style="background:#f8fafc; border-radius:8px; padding:15px; margin-bottom:15px;">
                                <p style="margin:5px 0;"><b>Kode Booking</b><br>
                                    {{ $booking->booking_code }}
                                </p>

                                <p style="margin:5px 0;"><b>Tanggal</b><br>
                                    {{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}
                                </p>

                                <p style="margin:5px 0;"><b>Tujuan</b><br>
                                    {{ $booking->destination }}
                                </p>
                            </div>

                            <!-- Optional Reason -->
                            @if(!empty($booking->cancel_reason))
                                <div style="background:#fff7ed; border-left:4px solid #f59e0b; padding:12px; border-radius:6px; margin-bottom:15px;">
                                    <b>Alasan Pembatalan:</b><br>
                                    {{ $booking->cancel_reason }}
                                </div>
                            @endif

                            <p>
                                Silakan lakukan tindakan melalui admin panel untuk menyetujui atau menolak pengajuan ini.
                            </p>

                            <!-- CTA -->
                            <div style="text-align:center; margin:25px 0;">
                                <a href="#" 
                                   style="background:#2563eb; color:#ffffff; padding:12px 20px; text-decoration:none; border-radius:6px; font-size:14px;">
                                    Buka Admin Panel
                                </a>
                            </div>

                            <p style="font-size:13px; color:#64748b;">
                                Disarankan untuk segera memproses permintaan ini agar tidak mengganggu jadwal operasional.
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