<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>
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
<section id="faq" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion " id="faqAccordion">
                    <?php foreach ($faqs as $index => $faq) : ?>
                        <div class="card mb-0 shadow-sm">
                            <div class="card-header" id="heading<?= $index; ?>">
                                <h2 class="mb-0">
                                    <button class="btn btn-block text-left font-weight-bold <?= $index !== 0 ? 'collapsed' : ''; ?>" type="button" data-toggle="collapse" data-target="#collapse<?= $index; ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?= $index; ?>">
                                        <?= esc($faq['question']); ?>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse<?= $index; ?>" class="collapse <?= $index === 0 ? 'show' : ''; ?>" aria-labelledby="heading<?= $index; ?>" data-parent="#faqAccordion">
                                <div class="card-body">
                                    <?= esc($faq['answer']); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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