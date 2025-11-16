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
            background: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Notifikasi Booking Baru</h2>
        </div>
        <div class="content">
            <p>Ada booking baru yang perlu diproses:</p>

            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>ID Booking</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $booking_id ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Customer</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $user_name ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Motor</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $motor_name ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Periode</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= date('d M Y', strtotime($start_date)) ?> - <?= date('d M Y', strtotime($end_date)) ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong>Total</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">Rp <?= number_format($total_price, 0, ',', '.') ?></td>
                </tr>
            </table>

            <p style="margin-top: 20px;">Silakan login ke dashboard admin untuk memproses booking ini.</p>
        </div>
    </div>
</body>

</html>