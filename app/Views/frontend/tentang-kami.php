<?php

use Faker\Provider\Base;
?>
<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>
<!-- Section Produk -->
<section id="produk" class="py-5" style="height: 40vh;
        background:linear-gradient(0deg, rgba(255, 255, 255, 0.85),
        rgba(255, 255, 255, 0.85)),
        url('<?= base_url('img/asset/bg-tentang-kami.png'); ?>')
        center/cover no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;">
    <div class="container">
        <h2 class="text-center m-5 font-weight-bold text-dark"><?= $title; ?></h2>
    </div>
</section>
<section id="about-us">
    <div class="container">
        <div class="row py-5 justify-content-center">
            <div class="col-lg align-content-center text-center m-4">
                <img src="<?= base_url('img/asset/logo.png'); ?>" alt="tentang Kami">
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <h4><b>Mitra Perjalanan Skuter Anda di Kota Istimewa</b></h4>
                <p>DScooter Jogja adalah layanan sewa skuter matic terpercaya yang hadir untuk memberikan kebebasan dan kemudahan jelajah di Yogyakarta. Kami menawarkan armada skuter terbaru dan terawat, siap mengantar Anda menikmati setiap sudut kota.</p>
            </div>
            <div class="col-md-6">
                <img src="<?= base_url('img/asset/tentang-kami-1.png'); ?>" alt="About Us" class="img-fluid p-4">
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <img src="<?= base_url('img/asset/tentang-kami-2.png'); ?>" alt="About Us" class="img-fluid p-4">
            </div>
            <div class="col-md-6">
                <h4><b>Mengapa Kami Pilihan Terbaik?</b></h4>
                <p>Kami mengutamakan keamanan dan kenyamanan dengan skuter prima yang rutin diservis dan helm bersih. Proses booking online kami cepat dan mudah, didukung layanan antar-jemput fleksibel ke lokasi Anda, harga transparan tanpa biaya tersembunyi, serta pelayanan responsif yang selalu siap membantu.</p>
            </div>
        </div>
    </div>
</section>


<?= $this->include('frontend/partials/footer'); ?>