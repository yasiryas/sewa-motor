<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>

<section id="pesanan" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4 font-weight-bold">Detail Pesanan Anda</h2>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3"><b><?= esc($motor['brand']); ?> <?= esc($motor['name']); ?></b></h4>
                        <p class="card-text"><strong>Harga Sewa per Hari:</strong> Rp <?= number_format($motor['price_per_day'], 0, ',', '.'); ?> </p>
                        <p class="card-text"><strong>Tanggal Sewa:</strong> <?= esc($booking['start_date']); ?> - <?= esc($booking['end_date']); ?></p>
                        <p class="card-text"><strong>Total Harga:</strong> Rp <?= number_format($booking['total_price'], 0, ',', '.'); ?> </p>
                        <p class="card-text"><strong>Metode Pembayaran:</strong> <?= esc($booking['payment_method']); ?></p>
                        <p class="card-text"><strong>Status Pembayaran:</strong> <?= esc($booking['payment_status']); ?></p>
                        <p class="card-text"><strong>Status Pesanan:</strong> <?= esc($booking['booking_status']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>