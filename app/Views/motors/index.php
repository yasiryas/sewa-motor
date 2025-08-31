<h2>Daftar Motor</h2>

<?php if (!empty($motors)): ?>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        <?php foreach ($motors as $motor): ?>
            <div style="border:1px solid #ccc; padding: 10px; text-align: center;">
                <img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>" width="200">
                <h3><?= esc($motor['name']); ?> (<?= esc($motor['brand']); ?>)</h3>
                <p>Harga per hari: Rp <?= number_format($motor['price_per_day']); ?></p>
                <a href="<?= site_url('motors/' . $motor['id']); ?>">Lihat Detail</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Tidak ada motor tersedia.</p>
<?php endif; ?>