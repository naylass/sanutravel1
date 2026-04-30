<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .total {
            text-align: right;
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

    <!-- HEADER -->
    <div class="header">
        <!-- kalau punya logo -->
        <!-- <img src="{{ public_path('logo.png') }}" class="logo"> -->

        <div class="title">INVOICE PEMBAYARAN</div>
    </div>

    <!-- INFO -->
    <div class="info">
        <p><strong>Booking ID:</strong> {{ $payment->booking_id }}</p>
        <p><strong>Metode:</strong> {{ ucfirst($payment->method) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
        <p><strong>Tanggal:</strong> {{ $payment->created_at }}</p>
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

        {{-- contoh 1 item (kalau dari booking) --}}
        <tr>
            <td>Booking Travel</td>
            <td>1</td>
            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
        </tr>

        </tbody>

        <tfoot>
        <tr>
            <td colspan="3" class="total">TOTAL</td>
            <td>
                <strong>
                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                </strong>
            </td>
        </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Terima kasih telah menggunakan layanan kami 🙏
    </div>

</div>
</body>
</html>