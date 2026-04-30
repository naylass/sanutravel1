<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status Delivery</title>
</head>
<body style="font-family: Arial; background:#f4f4f4; padding:20px;">

<table width="100%">
<tr>
<td align="center">

<table width="600" style="background:#fff; border-radius:8px;" cellpadding="20">

<!-- HEADER -->
<tr>
<td align="center" style="background:#3498db; color:#fff;">
<h2>Status Delivery Update</h2>
</td>
</tr>

<!-- CONTENT -->
<tr>
<td>

<p>Halo <b>{{ $deliveryOrder->booking->user->name }}</b>,</p>

<p>Status delivery Anda telah diperbarui.</p>

<hr>

<p><b>Kode Booking:</b> {{ $deliveryOrder->booking->booking_code }}</p>
<p><b>Driver:</b> {{ $deliveryOrder->driver->name }}</p>
<p><b>Tujuan:</b> {{ $deliveryOrder->destination }}</p>

<hr>

<!-- STATUS -->
<h3>Status Saat Ini:</h3>

<p style="font-size:18px;">
    @if($deliveryOrder->status == 'prepared')
        <span style="color:blue;"><b>PREPARED</b></span>
        <br><small>Order sudah dibuat dan menunggu driver.</small>

    @elseif($deliveryOrder->status == 'ongoing')
        <span style="color:orange;"><b>ONGOING</b></span>
        <br><small>Driver sedang menuju lokasi penjemputan atau sedang dalam perjalanan.</small>

    @elseif($deliveryOrder->status == 'completed')
        <span style="color:green;"><b>COMPLETED</b></span>
        <br><small>Perjalanan telah selesai.</small>

    @else
        <span style="color:red;"><b>CANCELLED</b></span>
        <br><small>Order dibatalkan.</small>
    @endif
</p>

<hr>

<!-- PENJELASAN TAMBAHAN -->
<h4>Keterangan Status:</h4>
<ul style="font-size:13px; color:#555;">
    <li><b>Prepared</b> → Order sudah dibuat</li>
    <li><b>Ongoing</b> → Driver sedang menuju lokasi atau sedang perjalanan</li>
    <li><b>Completed</b> → Perjalanan selesai</li>
    <li><b>Cancelled</b> → Order dibatalkan</li>
</ul>

<p style="margin-top:15px;">
Terima kasih telah menggunakan layanan kami.
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center" style="font-size:12px; color:#aaa;">
© {{ date('Y') }} Sistem Delivery Order
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>