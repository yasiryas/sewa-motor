<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>
<!-- Hero Section -->
<section id="hero" class="py-5" style="margin-top:70px;">
    <div class="container d-flex align-items-center">
        <div class="row w-60 mx-auto">
            <div class="col-md-6 text-center">
                <img src="<?= base_url('img/asset/hero-section.png'); ?>" class="img-fluid" alt="Motor">
            </div>
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <div>
                    <h2><strong>Jelajahi Setiap Sudut Jogja Tanpa Batas!</strong></h2>
                    <p>Mulai dari keramaian Malioboro hingga ketenangan alam pedesaan, nikmati kebebasan bergerak dengan armada skuter terawat kami. Bebas macet, bebas khawatir!</p>
                </div>
                <div>
                    <a href="#" class="btn btn-warning text-white">Pesan Sekarang!</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 bg-light text-center">
    <div class="container">
        <h3 class="section-title">How It Works</h3>
        <div class="row d-flex justify-content-cente align-items-center">
            <div class="col-12 col-md-4">
                <div class="card shadow m-2 col">
                    <div class="card-body p-3">
                        <h3><b>1</b></h3>
                        <p><strong>Pilih & Tentukan Jadwalmu</strong><br> Klik skuter favoritmu, lalu tentukan tanggal dan durasi sewa yang kamu inginkan.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow m-2 col">
                    <div class="card-body p-3">
                        <h3><b>2</b></h3>
                        <p><strong>Isi Data & Selesaikan Pembayaran</strong><br> Lengkapi formulir pemesanan lalu lakukan pembayaran melalui metode yang tersedia.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow m-2 col">
                    <div class="card-body p-3">
                        <h3><b>3</b></h3>
                        <p><strong>Siap Jelajahi Jogja!</strong><br> Skuter siap kamu ambil langsung di tempat kami. Selamat menikmati petualanganmu!</p>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Featured Product -->
<section id="produk" class="py-5 text-center">
    <div class="container">
        <h3 class="section-title">Featured Product</h3>
        <div class="row">
            <?php foreach ($motors as $motor) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>" class="card-img-top" alt="Fazzio">
                        <div class="card-body">
                            <h5><?= $motor['name']; ?></h5>
                            <p>Rp. <?php echo number_format($motor['price_per_day'], 0, ',', '.'); ?> /Day</p>
                            <a href="#" class="btn btn-warning btn-sm text-white px-4">Booking</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Tambahkan produk lain -->
        </div>
        <a href="#" class="btn btn-outline-warning mt-3">Lihat yang lain →</a>
    </div>
</section>

<!-- Paket Explore -->
<section class="py-5 text-white text-center" style="background: #d95f2a;">
    <div class="container">
        <h4>PAKET EXPLORE JOGJA: Skuter + Rekomendasi Destinasi!</h4>
        <p>Selain skuter terawat, kami berikan peta digital berisi rute wisata favorit dan rekomendasi kuliner Jogja yang wajib Anda coba.</p>
        <a href="#" class="btn btn-light rounded-pill">Lihat Paket Unggulan Kami!</a>
    </div>
</section>

<!-- Contact Form -->
<section id="kontak" class="py-5">
    <div class="container text-center">
        <h4>Masih Ada Pertanyaan? Atau Ingin Langsung Pesan?</h4>
        <form class="mt-4 col-md-6 mx-auto">
            <input type="email" class="form-control mb-3" placeholder="Email">
            <input type="text" class="form-control mb-3" placeholder="WhatsApp">
            <textarea class="form-control mb-3" placeholder="Pesan"></textarea>
            <button type="submit" class="btn btn-warning btn-block rounded-pill">Kirim Penawaran!</button>
        </form>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>