<?= $this->include('frontend/partials/header') ?>
<?= $this->include('frontend/partials/navbar') ?>

<!-- Hero Section -->
<section id="beranda" class="hero d-flex align-items-center">
    <div class="container text-center">
        <h1 class="fw-bold display-4 text-primary">Sewa Motor Mudah & Nyaman 🚀</h1>
        <p class="lead text-muted mt-3">Temukan motor terbaik dengan harga terjangkau untuk perjalananmu</p>
        <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg mt-4 px-5 shadow">Mulai Booking</a>
    </div>
</section>

<!-- Layanan -->
<section id="layanan" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title mb-5">Layanan Kami</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center p-4 hover-card">
                    <i class="fas fa-motorcycle fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Sewa Harian</h5>
                    <p class="text-muted">Motor berkualitas dengan harga terjangkau untuk kebutuhan harianmu.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center p-4 hover-card">
                    <i class="fas fa-calendar-week fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Sewa Mingguan</h5>
                    <p class="text-muted">Pilihan hemat untuk perjalanan lebih lama dengan motor andalan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center p-4 hover-card">
                    <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Sewa Bulanan</h5>
                    <p class="text-muted">Harga spesial untuk penggunaan jangka panjang.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold text-primary">Pilihan Motor Kami</h2>

        <div class="row g-4">
            <?php foreach ($motors as $motor): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>"
                            class="card-img-top"
                            alt="<?= esc($motor['name']); ?>"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= esc($motor['name']); ?> - <?= esc($motor['brand']); ?></h5>
                            <p class="card-text text-muted mb-3">
                                Harga per hari: <span class="fw-bold text-success">Rp <?= number_format($motor['price_per_day']); ?></span>
                            </p>

                            <form action="<?= site_url('booking'); ?>" method="POST" class="mt-auto">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="motor_id" value="<?= $motor['id']; ?>">
                                <div class="mb-2">
                                    <label class="form-label small">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-2">Booking Sekarang</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- Tentang Kami -->
<section id="tentang" class="py-5">
    <div class="container text-center">
        <h2 class="section-title mb-4">Tentang Kami</h2>
        <p class="text-muted w-75 mx-auto">
            Kami menyediakan layanan persewaan motor terpercaya dengan unit motor terbaru, harga bersaing,
            dan pelayanan ramah untuk kebutuhan perjalanan Anda.
        </p>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h2 class="fw-bold">Siap Berpetualang dengan Motor Idamanmu?</h2>
        <p class="mt-2 mb-4">Booking sekarang dan nikmati perjalanan tanpa ribet!</p>
        <a href="<?= base_url('motors') ?>" class="btn btn-light btn-lg px-5 shadow">Lihat Motor</a>
    </div>
</section>

<!-- Kontak -->
<section id="kontak" class="py-5">
    <div class="container text-center">
        <h2 class="section-title mb-4">Kontak Kami</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <p><i class="fas fa-phone text-primary"></i> 0857-1387-8266</p>
                <p><i class="fas fa-envelope text-primary"></i> support@rentalmotor.com</p>
                <p><i class="fas fa-map-marker-alt text-primary"></i> Jl. Merdeka No. 123, Jakarta</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">FAQ</h2>
        <div class="accordion w-75 mx-auto" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq1">
                        Apa syarat sewa motor?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Cukup membawa KTP dan SIM C yang masih berlaku.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#faq2">
                        Apakah ada layanan antar motor?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ya, kami menyediakan layanan antar-jemput motor ke lokasi Anda.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('frontend/partials/footer') ?>