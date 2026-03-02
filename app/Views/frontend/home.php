<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>
<!-- Hero Section -->
<section id="hero" class="py-4 py-lg-5" style="margin-top:70px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6 text-center order-2 order-lg-1">
                <img src="<?= base_url('img/asset/hero-section.png'); ?>" class="img-fluid" alt="Motor" style="max-width: 100%; height: auto;">
            </div>

            <div class="col-12 col-lg-6 d-flex flex-column justify-content-center text-center text-lg-left order-1 order-lg-2 mb-4 mb-lg-0">
                <h2
                    class="font-weight-bold" style="font-size: 1.5rem;"><strong>Jelajahi Setiap Sudut Jogja Tanpa Batas!</strong></h2>
                <p class="my-3">Mulai dari keramaian Malioboro hingga ketenangan alam pedesaan, nikmati kebebasan bergerak dengan armada skuter terawat kami. Bebas macet, bebas khawatir!</p>
                <div>
                    <a href="#produk" class="btn btn-warning text-white">Pesan Sekarang!</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 bg-light text-center">
    <div class="container">
        <h3 class="section-title">How It Works</h3>
        <div class="row d-flex justify-content-center align-items-stretch">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="card shadow h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-3">
                            <span class="badge badge-warning p-3" style="font-size: 1.2rem; border-radius: 50%; width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center;">1</span>
                        </div>
                        <h5 class="font-weight-bold mb-2">Pilih & Tentukan Jadwalmu</h5>
                        <p class="mb-0 text-muted">Klik skuter favoritmu, lalu tentukan tanggal dan durasi sewa yang kamu inginkan.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="card shadow h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-3">
                            <span class="badge badge-warning p-3" style="font-size: 1.2rem; border-radius: 50%; width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center;">2</span>
                        </div>
                        <h5 class="font-weight-bold mb-2">Isi Data & Selesaikan Pembayaran</h5>
                        <p class="mb-0 text-muted">Lengkapi formulir pemesanan lalu bayar melalui metode yang tersedia.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <div class="card shadow h-100">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-3">
                            <span class="badge badge-warning p-3" style="font-size: 1.2rem; border-radius: 50%; width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center;">3</span>
                        </div>
                        <h5 class="font-weight-bold mb-2">Siap Jelajahi Jogja!</h5>
                        <p class="mb-0 text-muted">Skuter siap kamu ambil langsung di tempat kami. Selamat menikmati petualanganmu!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Product -->
<section id="produk" class="py-5 text-center">
    <div class="container">
        <h3 class="section-title mb-4">Featured Product</h3>
        <div class="row justify-content-center">
            <?php foreach ($motors as $motor) : ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow border-0">
                        <img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>" class="card-img-top" alt="<?= esc($motor['name']); ?>" style="height: 160px; object-fit: cover;" loading="lazy">
                        <div class="card-body p-3 d-flex flex-column">
                            <h5 class="card-title font-weight-bold mb-1" style="font-size: 0.9rem;"><?= esc($motor['name']); ?></h5>
                            <p class="text-warning font-weight-bold mb-2" style="font-size: 0.95rem;">Rp. <?= number_format($motor['price_per_day'], 0, ',', '.'); ?> <small class="text-muted font-weight-normal">/hari</small></p>
                            <a href="<?= base_url('produk/' . $motor['id']); ?>" class="btn btn-warning btn-sm text-white mt-auto">Booking Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="<?= base_url("produk"); ?>" class="btn btn-outline-warning mt-3">Lihat yang lain →</a>
    </div>
</section>

<!-- Paket Explore -->
<section class="py-5 text-white text-center" style="background: linear-gradient(135deg, #d95f2a 0%, #e67e22 100%);">
    <div class="container my-3 my-lg-5">
        <h4 class="px-2 font-weight-bold">PAKET EXPLORE JOGJA: Skuter + Rekomendasi Destinasi!</h4>
        <p class="px-2 mt-3">Selain skuter terawat, kami berikan peta digital berisi rute wisata favorit dan rekomendasi kuliner Jogja yang wajib Anda coba. Liburan lebih terencana dan berkesan!</p>
        <a href="<?= base_url("produk"); ?>" class="btn btn-light text-orange mt-3">Lihat Paket Unggulan Kami!</a>
    </div>
</section>

<!-- Contact Form -->
<section id="kontak" class="py-5">
    <div class="container text-center">
        <h4 class="px-2">Masih Ada Pertanyaan?<br> Atau Ingin Langsung Pesan?</h4>
        <div class="mt-4 col-12 col-md-6 mx-auto alert-box" id="alertBox">
        </div>
        <form class="mt-4 col-12 col-md-6 mx-auto" action="<?= base_url('send-email'); ?>" method="post" id="formSendEmail">
            <?= csrf_field(); ?>
            <input type="email" class="form-control mb-3" placeholder="Email" name="email" id="email">
            <input type="text" class="form-control mb-3" placeholder="WhatsApp" name="whatsapp" id="whatsapp">
            <textarea class="form-control mb-3" style="height:150px" placeholder="Pesan" name="pesan" id="pesan"></textarea>
            <button type="submit" class="btn btn-warning text-white" id="btnSendEmail">Kirim Penawaran!</button>
        </form>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>