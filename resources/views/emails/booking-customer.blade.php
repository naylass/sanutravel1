<h2>🚐 Booking Berhasil</h2>

<p>Halo {{ $booking->customer_name }},</p>

<p>
Booking travel Anda berhasil dibuat.
</p>

<hr>

<p>
<b>Kode Booking:</b><br>
{{ $booking->booking_code }}
</p>

<p>
<b>Tanggal:</b><br>
{{ $booking->pickup_date }}
</p>

<p>
<b>Jam:</b><br>
{{ $booking->pickup_time }}
</p>

<p>
<b>Total Pembayaran:</b><br>
Rp {{ number_format($booking->total_price,0,',','.') }}
</p>

<hr>

<p>
Silakan lakukan pembayaran melalui halaman pembayaran Sanu Travel.
</p>

<p>
Terima kasih 🚐
</p>