<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>
<!-- Hero Section -->
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
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 my-5">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4 font-weight-bold">Hubungi Kami</h3>
                        <form action="https://formspree.io/f/xwkrqzjy" method="POST">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Pesan</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="cta-about-us" class="bg-orange">
    <div class="container justify-content-center align-items-center text-white ">
        <div class="text-center py-5 col-md-8 mx-auto">
            <h3 class="font-weight-bold">Jelajahi Jogja, Sesukamu!</h3>
            <p>Dengan DScooter Jogja, rasakan petualangan tak terbatas di Kota Pelajar. Nikmati kemudahan bergerak dan ciptakan kenangan indah di setiap perjalanan.</p>
            <a href="<?= base_url('produk'); ?>" class="btn btn-light btn text-orange font-weight-bolder">Pesan Skuter Anda Sekarang!</a>
        </div>
    </div>
</section>

<?= $this->include('frontend/partials/footer'); ?>