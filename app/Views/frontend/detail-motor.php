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
                <h3 class="mb-4"><b><?= esc($motor['brand']); ?> <?= esc($motor['name']); ?></b></h3>
                <p class="mb-4"><strong>Rp. <?= number_format($motor['price_per_day'], 0, ',', '.'); ?> </strong>/ Day</p>
                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="form-group w-50">
                        <label for="tanggal_sewa">Pilih Tanggal Sewa</label>
                        <div class="input-group ">
                            <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group w-50">
                        <label for="tanggal_kembali">Pilih Tanggal Kembali</label>
                        <div class="input-group">
                            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" autocomplete="off">
                        </div>
                    </div>
                    <!-- Preview hasil -->
                    <p id="preview_tanggal" class="text-muted mt-2"></p>
                    <a href="<?= base_url('produk'); ?>" class="btn btn-warning text-white">Pesan Sekarang!</a>
                <?php else: ?>
                    <div class="alert alert-warning text-center mt-4" role="alert">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        Anda harus <a href="<?= base_url('login'); ?>" class="alert-link">login</a> terlebih dahulu untuk memesan.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="mt-5">
                <h4 class="mb-3"><b>Deskripsi Motor</b></h4>
                <p><?= $motor['description']; ?></p>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>