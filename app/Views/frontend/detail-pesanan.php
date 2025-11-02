<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>

<section id="produk" class="py-5" style="height: 40vh;
        background:linear-gradient(0deg, rgba(255, 255, 255, 0.85),
        rgba(255, 255, 255, 0.85)),
        url('<?= base_url('img/asset/bg-kontak.jpg'); ?>')
        center/cover no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;">
    <div class="container">
        <h2 class="text-center m-5 font-weight-bold text-dark"><?= $title; ?></h2>
    </div>
</section>
<section id="detailPesanan">
    <div class="container p-5">
        <div class="row">
            <div class="col-lg mx-auto">
                <div class="card shadow-sm rounded-4 border-0">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="<?= base_url('uploads/motors/') . $booking['photo']; ?>" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Motor: <?= esc($booking['brand_name']); ?> <?= esc($booking['motor_name']); ?></h3>
                                <p><strong>Tanggal Sewa:</strong> <?php echo date('d F Y', strtotime($booking['rental_start_date'])); ?></p>
                                <p><strong>Tanggal Kembali:</strong> <?php echo date('d F Y', strtotime($booking['rental_end_date'])); ?></p>
                                <p>Detail Tagihan</p>
                                <p><strong>Harga per Hari:</strong> Rp. <?= number_format($booking['price_per_day'], 0, ',', '.'); ?></p>
                                <p><strong>Total Harga:</strong> Rp. <?= number_format($booking['total_price'], 0, ',', '.'); ?></p>
                                <p><strong>Status:</strong>
                                    <?php if ($booking['status'] == 'pending'): ?>
                                        <span class="badge bg-warning  text-white">Pending</span>
                                    <?php elseif ($booking['status'] == 'confirmed'): ?>
                                        <span class="badge bg-primary  text-white">Confirmed</span>
                                    <?php elseif ($booking['status'] == 'canceled'): ?>
                                        <span class="badge bg-danger  text-white">Canceled</span>
                                    <?php endif; ?>
                                </p>
                                <a href="#" class="btn btn-sm btn-primary <?= $booking['status'] == 'confirmed' ? 'disabled' : '' ?>">Upload Bukti Pembayaran</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>