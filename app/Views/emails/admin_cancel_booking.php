<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Booking Dibatalkan</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; background:#f4f6f9; margin:0; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08); overflow:hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#e74c3c; padding:20px; color:#ffffff;">
                            <h2 style="margin:0; font-size:20px;">
                                Booking Dibatalkan
                            </h2>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:25px; color:#333;">
                            <p style="margin-top:0;">
                                Halo Admin,
                            </p>

                            <p>
                                User <strong><?= esc($user_name) ?></strong> telah
                                <span style="color:#e74c3c; font-weight:bold;">
                                    membatalkan booking
                                </span>.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin:15px 0; background:#f8f9fa; border-radius:6px;">
                                <tr>
                                    <td style="padding:10px;">
                                        <strong>ID Booking:</strong>
                                    </td>
                                    <td style="padding:10px;">
                                        <?= esc($booking_id) ?>
                                    </td>
                                </tr>
                            </table>

                            <p>
                                Silakan login ke dashboard admin untuk melihat detail
                                dan melakukan tindakan lanjutan.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;">
                            Rental Motor App <br>
                            Notifikasi otomatis – mohon tidak membalas email ini
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>