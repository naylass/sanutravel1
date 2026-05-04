<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body {
    font-family: Arial, sans-serif;
    font-size: 12px;
    background: #f4f6f8;
    color: #333;
}

.container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
}

.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.title {
    font-size: 22px;
    font-weight: bold;
}

.booking-code {
    font-size: 16px;
    letter-spacing: 2px;
    color: #2c3e50;
}

.box {
    border: 1px solid #eee;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 12px;
    background: #fafafa;
}

.label {
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th {
    background: #2c3e50;
    color: #fff;
    padding: 10px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.total {
    text-align: right;
    margin-top: 15px;
}

.total h2 {
    color: #27ae60;
    margin: 0;
}

.status {
    font-weight: bold;
}

.footer {
    margin-top: 30px;
    text-align: center;
    font-size: 11px;
    color: #777;
}
</style>
</head>

<body>
<div class="container">

@php
    $booking = $payment->booking;
@endphp

<!-- HEADER -->
<div class="header">
    <div>
        <div class="title">INVOICE</div>
        <div class="booking-code">{{ $booking->booking_code ?? '-' }}</div>
    </div>

    <div>
        <p><strong>Tanggal Invoice</strong><br>
        {{ \Carbon\Carbon::parse($payment->created_at)->translatedFormat('d F Y') }}</p>
    </div>
</div>

<!-- BOOKING -->
<div class="box">
    <p><span class="label">Tanggal Berangkat:</span>
        {{ $booking?->pickup_date 
            ? \Carbon\Carbon::parse($booking->pickup_date)->translatedFormat('d F Y')
            : '-' }}
    </p>
    <p><span class="label">Jam:</span> {{ $booking->pickup_time ?? '-' }}</p>
    <p><span class="label">Tipe:</span> {{ ucfirst($booking->pickup_type ?? '-') }}</p>
</div>

<!-- ROUTE -->
<div class="box">
    <p><span class="label">Dari:</span> {{ $booking->pickup_location ?? '-' }}</p>
    <p><span class="label">Ke:</span> {{ $booking->destination ?? '-' }}</p>
    <p><span class="label">Penumpang:</span> {{ $booking->total_passengers ?? 0 }} orang</p>
</div>

<!-- TABLE -->
<table>
<thead>
<tr>
    <th>Deskripsi</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Total</th>
</tr>
</thead>

<tbody>
<tr>
    <td>Transportasi Travel</td>
    <td>{{ $booking->total_passengers ?? 0 }}</td>
    <td>Rp {{ number_format($booking->price ?? 0, 0, ',', '.') }}</td>
    <td>
        Rp {{ number_format(($booking->price ?? 0) * ($booking->total_passengers ?? 0), 0, ',', '.') }}
    </td>
</tr>
</tbody>
</table>

<!-- TOTAL -->
<div class="total">
    <p>Total Pembayaran</p>
    <h2>Rp {{ number_format($payment->amount, 0, ',', '.') }}</h2>
</div>

<!-- PAYMENT -->
<div class="box">
    <p><span class="label">Metode:</span> {{ ucfirst($payment->payment_method) }}</p>

    <p><span class="label">Tanggal Bayar:</span>
        {{ $payment->payment_date 
            ? \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y H:i')
            : '-' }}
    </p>

    <p class="status">
        <span class="label">Status:</span>
        {{ strtoupper($payment->status) }}
    </p>

    @if($payment->transfer_info)
        <p><span class="label">Info Transfer:</span> {{ $payment->transfer_info }}</p>
    @endif
</div>

<!-- FOOTER -->
<div class="footer">
    Invoice ini sah tanpa tanda tangan.<br>
    Terima kasih telah menggunakan layanan kami 🙏
</div>

</div>
</body>
</html>