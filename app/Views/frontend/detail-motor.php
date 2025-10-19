<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>

<section id="produk" class="py-5">
    <div class="container pt-5">
        <div class="row ">
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>" class="img-fluid" style="height: 300px; object-fit: cover;" alt="<?= esc($motor['type']); ?>">
            </div>
            <div class="col-md-6">
                <h3 class="mb-4"><b><?= esc($motor['brand']); ?> - <?= esc($motor['name']); ?></b></h3>
                <p class="mb-4"><strong>Rp. <?= number_format($motor['price_per_day'], 0, ',', '.'); ?> </strong>/ Day</p>
                <!-- <p class="mb-4"><?php // esc($motor['description']);
                                        ?></p> -->
                <a href="<?= base_url('produk'); ?>" class="btn btn-warning text-white">Pesan Sekarang!</a>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>