<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:30px 15px; text-align:center;">

                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background:#0d6efd; padding:20px; text-align:center;">
                            <h2 style="color:#ffffff; margin:0;">
                                Konfirmasi Pembayaran
                            </h2>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:25px; color:#333333;">
                            <p style="font-size:15px; line-height:1.6;">
                                Halo <strong>Admin</strong>,
                            </p>

                            <p style="font-size:15px; line-height:1.6;">
                                User <strong><?= esc($user_name) ?></strong> telah mengirimkan
                                <strong>bukti pembayaran</strong> untuk booking berikut:
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="margin:20px 0; border-collapse:collapse;">
                                <tr>
                                    <td style="padding:10px; border:1px solid #e0e0e0; width:40%; background:#f9fafb;">
                                        ID Booking
                                    </td>
                                    <td style="padding:10px; border:1px solid #e0e0e0;">
                                        <?= esc($booking_id) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px; border:1px solid #e0e0e0; width:40%; background:#f9fafb;">
                                        Email Pemesan
                                    </td>
                                    <td style="padding:10px; border:1px solid #e0e0e0;">
                                        <?= esc($email_user) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px; border:1px solid #e0e0e0; background:#f9fafb;">
                                        Total Pembayaran
                                    </td>
                                    <td style="padding:10px; border:1px solid #e0e0e0;">
                                        <strong>Rp <?= number_format($amount, 0, ',', '.') ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px; border:1px solid #e0e0e0; background:#f9fafb;">
                                        Bukti Pembayaran
                                    </td>
                                    <td style="padding:10px; border:1px solid #e0e0e0;">
                                        <a href="<?= esc($payment_proof) ?>" target="_blank"
                                            style="color:#0d6efd; text-decoration:none;">
                                            Lihat Bukti Pembayaran
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:15px; line-height:1.6;">
                                Silakan login ke dashboard admin untuk melakukan
                                <strong>verifikasi pembayaran</strong>.
                            </p>

                            <!-- BUTTON -->
                            <div style="text-align:center; margin:30px 0;">
                                <a href="<?= base_url('dashboard/booking/' . $booking_id) ?>"
                                    style="background:#0d6efd; color:#ffffff; text-decoration:none; padding:12px 25px; border-radius:6px; font-weight:bold; display:inline-block;">
                                    Verifikasi Pembayaran
                                </a>
                            </div>

                            <p style="font-size:13px; color:#777777;">
                                Email ini dikirim secara otomatis oleh sistem.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f1f3f5; padding:15px; text-align:center; font-size:12px; color:#666;">
                            © <?= date('Y') ?> Rental Motor App — Admin Panel
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>