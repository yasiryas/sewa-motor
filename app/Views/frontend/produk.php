<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>

<!-- Section Produk -->
<section id="produk" class="py-5" style="height: 40vh;
        background: url('<?= base_url('img/asset/bg-produk.png'); ?>') center/cover no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;">
    <div class="container">
        <h2 class="text-center m-5 font-weight-bold text-dark">Produk</h2>
    </div>
</section>

<!-- Kategori -->
<section id="kategori" class="py-3 bg-gradient-orange">
    <div class="container ">
        <div class="text-center m-5">
            <h3 class="font-weight-bold mb-4 text-secondary ">Brand</h3>
            <div class="row justify-content-center">
                <?php foreach ($brands as $brand) : ?>
                    <div class="col-md-3 mb-4">
                        <a href="<?= base_url('produk/brand/' . $brand['id']); ?>" class="text-decoration-none">
                            <div class="card border-0 shadow-sm text-white brand-card">
                                <img src="<?= base_url('uploads/brands/' . $brand['featured_image']); ?>"
                                    class="card-img brand-img"
                                    alt="<?= esc($brand['brand']); ?>">
                                <div class="card-img-overlay d-flex align-items-end justify-content-center text-center p-3">
                                    <h6 class="font-weight-bold mb-0 text-white">
                                        <?= esc($brand['brand']); ?> <span class="ml-1">&rarr;</span>
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endforeach ?>

            </div>
        </div>
    </div>
</section>
<!-- Daftar Produk -->
<!-- Featured Product -->
<section id="produk" class="py-5 text-center">
    <div class="container">
        <h3 class="section-title mb-4">Daftar Produk</h3>
        <form action="<?= base_url('produk'); ?>" method="get" class="d-flex justify-content-center mb-3">
            <div class="input-group w-50">
                <input type="text" name="search" class="form-control w-50 rounded-left" placeholder="Cari produk favoritmu">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-warning rounded-right text-white px-4"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
        <div class="row mt-5">
            <?php foreach ($motors as $motor) : ?>
                <div class="col-md-3 mb-4 d-flex align-items-stretch">
                    <div class="card h-100 shadow">
                        <img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>" class="card-img-top" alt="<?= esc($motor['name']); ?>">
                        <div class="card-body d-flex flex-column">
                            <div class="mt-auto">
                                <h5 class="card-title"><?= esc($motor['name']); ?></h5>
                                <p class="card-text mb-4">Rp. <?= number_format($motor['price_per_day'], 0, ',', '.'); ?> / Day</p>
                                <a href="#" class="btn btn-warning btn-sm text-white px-4">Booking</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="#" class="btn btn-outline-warning mt-3">Lihat yang lain →</a>
    </div>
</section>




<?= $this->include('frontend/partials/footer'); ?>