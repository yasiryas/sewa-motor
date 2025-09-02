<h2><?= esc($motor['name']); ?> - <?= esc($motor['brand']); ?></h2>
<img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>" width="300">
<p>Harga per hari: Rp <?= number_format($motor['price_per_day']); ?></p>

<form action="<?= site_url('booking'); ?>" method="POST">
    <?= csrf_field(); ?>
    <input type="hidden" name="motor_id" value="<?= $motor['id']; ?>">
    <label>Tanggal Mulai</label>
    <input type="date" name="start_date" required>
    <label>Tanggal Selesai</label>
    <input type="date" name="end_date" required>
    <button type="submit">Booking Sekarang</button>
</form>