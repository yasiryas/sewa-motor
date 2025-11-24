<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background: #f9f9f9;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Konfirmasi Booking Rental Motor</h2>
        </div>
        <div class="content">
            <p>Halo <strong><?= $user_name ?></strong>,</p>
            <p>Terima kasih telah melakukan booking di Rental Motor App. Berikut detail booking Anda:</p>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>ID Booking</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $booking_id ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Motor</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $motor_name ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Tanggal Mulai</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= date('d F Y', strtotime($start_date)) ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Tanggal Selesai</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= date('d F Y', strtotime($end_date)) ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Total Harga</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">Rp <?= number_format($total_price, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Status Pembayaran</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $status; ?></td>
                </tr>
            </table>

            <p style="margin-top: 20px;">Terima kasih sudah menggunakan Rental Motor App.</p>
        </div>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> Rental Motor App. All rights reserved.</p>
        </div>
    </div>
</body>

</html>