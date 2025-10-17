<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>

<section id="produk" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= base_url('img/motors/' . $motor['image']); ?>" class="img-fluid" alt="<?= esc($motor['model']); ?>">
            </div>
            <div class="col-md-6">
                <h3 class="mb-4"><b><?= esc($motor['model']); ?></b></h3>
                <p class="mb-4">Rp. <?= number_format($motor['price_per_day'], 0, ',', '.'); ?> / Day</p>
                <p class="mb-4"><?= esc($motor['description']); ?></p>
                <a href="<?= base_url('produk'); ?>" class="btn btn-warning text-white">Pesan Sekarang!</a>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>