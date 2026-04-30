<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delivery Order</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            letter-spacing: 2px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 6px;
            vertical-align: top;
        }

        .label {
            width: 150px;
            font-weight: bold;
        }

        .box {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 6px;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            color: #fff;
            font-size: 11px;
        }

        .prepared { background: #3498db; }
        .ongoing { background: #f39c12; }
        .completed { background: #2ecc71; }
        .cancelled { background: #e74c3c; }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #888;
        }

    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>DELIVERY ORDER</h2>
        <small>No: {{ $deliveryOrder->booking->booking_code }}</small>
    </div>

    <!-- INFO UTAMA -->
    <div class="section">
        <div class="section-title">Informasi Customer & Driver</div>

        <div class="box">
            <table>
                <tr>
                    <td class="label">Customer</td>
                    <td>: {{ $deliveryOrder->booking->user->name }}</td>
                </tr>
                <tr>
                    <td class="label">Sopir</td>
                    <td>: {{ $deliveryOrder->driver->name }}</td>
                </tr>
                <tr>
                    <td class="label">Kendaraan</td>
                    <td>: {{ $deliveryOrder->vehicle->brand }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- DETAIL PERJALANAN -->
    <div class="section">
        <div class="section-title">Detail Perjalanan</div>

        <div class="box">
            <table>
                <tr>
                    <td class="label">Tanggal</td>
                    <td>: {{ $deliveryOrder->departure_date }}</td>
                </tr>
                <tr>
                    <td class="label">Jam</td>
                    <td>: {{ $deliveryOrder->departure_time }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td>: {{ $deliveryOrder->pickup_point }}</td>
                </tr>
                <tr>
                    <td class="label">Tujuan</td>
                    <td>: {{ $deliveryOrder->destination }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- STATUS -->
    <div class="section">
        <div class="section-title">Status</div>

        <div class="box">
            <span class="status {{ $deliveryOrder->status }}">
                {{ strtoupper($deliveryOrder->status) }}
            </span>
        </div>
    </div>

    <!-- INSTRUKSI -->
    <div class="section">
        <div class="section-title">Instruksi Driver</div>

        <div class="box">
            <ul>
                <li>Ubah status ke <b>ONGOING</b> saat mulai perjalanan</li>
                <li>Ubah status ke <b>COMPLETED</b> saat selesai</li>
            </ul>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i') }} <br>
        Sistem Delivery Order
    </div>

</div>

</body>
</html>