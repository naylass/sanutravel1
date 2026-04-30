<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delivery Order Baru</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f6f8; padding:20px;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<!-- CONTAINER -->
<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden;">

<!-- HEADER -->
<tr>
<td align="center" style="background:#2c3e50; color:#ffffff; padding:20px;">
    <h2 style="margin:0;">🚚 Delivery Order Baru</h2>
    <small>No: {{ $deliveryOrder->booking->booking_code }}</small>
</td>
</tr>

<!-- CONTENT -->
<tr>
<td style="padding:25px;">

<p style="margin:0 0 10px;">
    Halo <b>{{ $deliveryOrder->driver->name }}</b>,
</p>

<p style="margin:0 0 20px; color:#555;">
    Anda mendapatkan <b>Delivery Order</b> baru dari sistem.
</p>

<!-- BOX DETAIL -->
<table width="100%" style="border:1px solid #eee; border-radius:8px; padding:15px;">
<tr>
<td>

<h4 style="margin-top:0;">📋 Detail Delivery</h4>

<table width="100%" cellpadding="5">

<tr>
<td width="140"><b>Kode Booking</b></td>
<td>: {{ $deliveryOrder->booking->booking_code }}</td>
</tr>

<tr>
<td><b>Customer</b></td>
<td>: {{ $deliveryOrder->booking->user->name }}</td>
</tr>

<tr>
<td><b>Tujuan</b></td>
<td>: {{ $deliveryOrder->destination }}</td>
</tr>

<tr>
<td><b>Kendaraan</b></td>
<td>: {{ $deliveryOrder->vehicle->brand }}</td>
</tr>

</table>

</td>
</tr>
</table>

<!-- STATUS -->
<div style="margin-top:20px; padding:10px; background:#eef6ff; border-radius:6px;">
    <b>Status Awal:</b> 
    <span style="color:#3498db;">PREPARED</span>
</div>

<!-- INSTRUKSI -->
<div style="margin-top:20px;">
    <h4>🧾 Instruksi Driver</h4>
    <ul style="color:#555;">
        <li>Ubah status ke <b style="color:orange;">ONGOING</b> saat mulai perjalanan</li>
        <li>Ubah status ke <b style="color:green;">COMPLETED</b> saat selesai</li>
    </ul>
</div>

<!-- BUTTON -->
<div style="margin-top:25px; text-align:center;">
    <a href="#" 
       style="background:#2c3e50; color:#fff; padding:10px 20px; text-decoration:none; border-radius:6px;">
       Login ke Sistem
    </a>
</div>

<p style="margin-top:20px; font-size:13px; color:#777;">
    Detail lengkap tersedia pada lampiran PDF.
</p>

</td>
</tr>

<!-- FOOTER -->
<tr>
<td align="center" style="padding:15px; font-size:12px; color:#aaa;">
    © {{ date('Y') }} Sistem Delivery Order
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>