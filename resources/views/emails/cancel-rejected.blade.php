<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pembatalan Ditolak</title>
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
                                Layanan Transportasi & Travel
                            </p>
                        </td>
                    </tr>

                    <!-- Status Banner -->
                    <tr>
                        <td style="background:#fee2e2; padding:15px; text-align:center;">
                            <span style="color:#dc2626; font-weight:bold; font-size:16px;">
                                ❌ Pembatalan Ditolak
                            </span>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:25px; color:#334155;">

                            <p style="margin-top:0;">
                                Halo <b>{{ $booking->user->name }}</b>,
                            </p>

                            <p>
                                Kami mohon maaf, permintaan pembatalan booking Anda <b>tidak dapat disetujui</b>.
                            </p>

                            <p>
                                Booking tetap berjalan sesuai jadwal yang telah ditentukan.
                            </p>

                            <!-- Detail Card -->
                            <div style="background:#f8fafc; border-radius:8px; padding:15px; margin:20px 0;">
                                
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
                                <div style="background:#fff1f2; border-left:4px solid #dc2626; padding:12px; border-radius:6px; margin-bottom:15px;">
                                    <b>Alasan Penolakan:</b><br>
                                    {{ $booking->cancel_reason }}
                                </div>
                            @endif

                            <!-- CTA -->
                            <div style="text-align:center; margin:25px 0;">
                                <a href="#" 
                                   style="background:#2563eb; color:#ffffff; padding:12px 20px; text-decoration:none; border-radius:6px; font-size:14px;">
                                    Lihat Detail Booking
                                </a>
                            </div>

                            <p style="font-size:13px; color:#64748b;">
                                Jika Anda membutuhkan bantuan atau ingin mengajukan pertanyaan, silakan hubungi tim support kami.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f1f5f9; padding:20px; text-align:center; font-size:12px; color:#64748b;">
                            
                            <p style="margin:0;">
                                © {{ date('Y') }} Sanu Travel. All rights reserved.
                            </p>

                            <p style="margin:5px 0;">
                                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>