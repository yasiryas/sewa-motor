<!DOCTYPE html>
<html lang="id">


<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $booking['id']; ?></title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            background-color: #fff;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            width: 90%;
            margin: 40px auto;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header img {
            width: 90px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            color: #222;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .info-box {
            width: 48%;
        }

        .info-box h4 {
            margin-bottom: 8px;
            color: #111;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        table th {
            background-color: #f5f5f5;
            color: #333;
        }

        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            color: #111;
        }

        .status {
            text-transform: uppercase;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: bold;
            display: inline-block;
        }

        .status.pending {
            background-color: #f4c542;
            color: #fff;
        }

        .status.confirmed {
            background-color: #007bff;
            color: #fff;
        }

        .status.waiting_confirmation {
            background-color: #17a2b8;
            color: #fff;
        }

        .status.canceled {
            background-color: #dc3545;
            color: #fff;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 11px;
            color: #666;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
            font-size: 12px;
        }

        .signature p {
            margin: 5px 0;
        }

        .signature .line {
            border-top: 1px solid #333;
            width: 180px;
            float: right;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <img src="<?= base_url('img/asset/logo.png'); ?>" alt="Logo Rental Motor">
            <h2>INVOICE PEMBAYARAN</h2>
            <p><strong>ID Pesanan:</strong> #<?= $booking['id']; ?></p>
        </div>

        <div class="invoice-info">
            <div class="info-box">
                <h4>Dari:</h4>
                <p><strong>Rental Motor Indonesia</strong><br>
                    Jl. Karangwaru No. 12, Yogyakarta<br>
                    Telp: (021) 999-888<br>
                    Email: info@rentalmotor.id</p>
            </div>

            <div class="info-box">
                <h4>Kepada:</h4>
                <p><strong><?= esc($booking['full_name']); ?></strong><br>
                    <?= esc($booking['phone']); ?><br>
                    <?= esc($booking['email']); ?></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Harga per Hari</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= esc($booking['brand_name']); ?> <?= esc($booking['motor_name']); ?> (<?= esc($booking['number_plate']); ?>)</td>
                    <td><?= date('d M Y', strtotime($booking['rental_start_date'])); ?> - <?= date('d M Y', strtotime($booking['rental_end_date'])); ?></td>
                    <td>Rp <?= number_format($booking['price_per_day'], 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($booking['total_price'], 0, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>

        <p class="total">Total Pembayaran: Rp <?= number_format($booking['total_price'], 0, ',', '.'); ?></p>

        <p><strong>Metode Pembayaran:</strong> <?= ucfirst($booking['payment_method']); ?></p>
        <p><strong>Status:</strong>
            <span class="status <?= $booking['status']; ?>">
                <?= ucfirst(str_replace('_', ' ', $booking['status'])); ?>
            </span>
        </p>

        <div class="signature">
            <p>Yogyakarta, <?= date('d F Y'); ?></p>
            <div class="line"></div>
            <p><strong>Admin Rental Motor</strong></p>
        </div>

        <div class="footer">
            <p>Terima kasih telah mempercayakan perjalananmu kepada <strong>Rental Motor Indonesia</strong></p>
            <p>Website: www.rentalmotor.id | Email: support@rentalmotor.id</p>
        </div>
    </div>
</body>

</html>