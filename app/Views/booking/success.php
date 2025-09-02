<h2>Booking Berhasil</h2>
<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;"><?= session()->getFlashdata('success'); ?></p>
<?php endif; ?>
<a href="<?= site_url('motors'); ?>">Kembali ke Daftar Motor</a>