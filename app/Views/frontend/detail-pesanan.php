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
                    <div class="card-body">
                        <div class="justify-content-center mb-4 mx-sm-5 d-flex">
                            <img src="<?= base_url('uploads/motors/') . $booking['photo']; ?>" class="image-fluid justify-content-center" alt="">
                        </div>
                        <p><strong>Motor:</strong> <?= esc($booking['brand_name']); ?> <?= esc($booking['motor_name']); ?></p>
                        <p><strong>Tanggal Sewa:</strong> <?php echo date('d F Y', strtotime($booking['rental_start_date'])); ?></p>
                        <p><strong>Tanggal Kembali:</strong> <?php echo date('d F Y', strtotime($booking['rental_end_date'])); ?></p>
                        <p><strong>Status:</strong>
                            <?php if ($booking['status'] == 'pending'): ?>
                                <span class="badge bg-warning  text-white">Pending</span>
                            <?php elseif ($booking['status'] == 'confirmed'): ?>
                                <span class="badge bg-primary  text-white">Confirmed</span>
                            <?php elseif ($booking['status'] == 'canceled'): ?>
                                <span class="badge bg-danger  text-white">Canceled</span>
                            <?php endif; ?>
                        </p>
                        <a href="#" class="btn btn-sm btn-primary">Upload Bukti Pembayaran</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>