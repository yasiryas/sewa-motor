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
    <div class="container my-5">
        <div class="row no-gutters overflow-hidden shadow-sm" style="border-radius: 10px">
            <!-- MAP -->
            <div class="col-md-6 map-container p-0" style="height: 50vh;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.356789031508!2d110.41020421533287!3d-7.803249594386078!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a57b04028d327%3A0x5c4d64e59b13c3c7!2sYasyes%20Computer!5e0!3m2!1sid!2sid!4v1696879236574!5m2!1sid!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen=""
                    loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- CONTACT BOX -->
            <div class="col-md-6 contact-box d-flex flex-column justify-content-center p-5 bg-warning text-white">
                <div class="contact-item d-flex align-items-start mb-3">
                    <i class="fab fa-whatsapp fa-lg mr-3 mt-1"></i>
                    <div>
                        <strong>WhatsApp</strong><br>
                        <span>6289001231</span>
                    </div>
                </div>

                <div class="contact-item d-flex align-items-start mb-3">
                    <i class="far fa-envelope fa-lg mr-3 mt-1"></i>
                    <div>
                        <strong>Email</strong><br>
                        <span>admin@mail.com</span>
                    </div>
                </div>

                <div class="contact-item d-flex align-items-start">
                    <i class="fas fa-map-marker-alt fa-lg mr-3 mt-1"></i>
                    <div>
                        <strong>Alamat</strong><br>
                        <span>Yogyakarta</span>
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
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card border-0 my-5">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4 font-weight-bold">Hubungi Kami</h3>
                        <div class="mt-4 col-md-6 mx-auto alert-box" id="alertBox">
                        </div>
                        <form class="mt-4 col-md-6 mx-auto" action="<?= base_url('send-email'); ?>" method="post" id="formSendEmail">
                            <?= csrf_field(); ?>
                            <input type="email" class="form-control mb-3" placeholder="Email" name="email" id="email">
                            <input type="text" class="form-control mb-3" placeholder="WhatsApp" name="whatsapp" id="whatsapp">
                            <textarea class="form-control mb-3" style="height:150px" placeholder="Pesan" name="pesan" id="pesan"></textarea>
                            <button type="submit" class="btn btn-warning text-white" id="btnSendEmail">Kirim Penawaran!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $this->include('frontend/partials/footer'); ?>