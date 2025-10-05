<!-- Footer -->
<footer>
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <img src="<?= base_url('img/asset/logo.png'); ?>" alt="Logo" height="100">
        </div>
        <div class="d-flex flex-wrap">
            <div class="flex-column mb-3">
                <h6>Menu</h6>
                <ul class="list-unstyled">
                    <li><a href="#hero">Beranda</a></li>
                    <li><a href="#produk">Produk</a></li>
                    <li><a href="#tentang">Tentang Kami</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h6>Ikuti Kami</h6>
                <a href="#">Instagram</a> |
                <a href="#">TikTok</a> |
                <a href="#">Facebook</a> |
                <a href="#">YouTube</a>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <p><?= "SewaSkuterJogja"; ?> - ©<?= date('Y'); ?></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('front/js/script.js'); ?>"></script>
</body>

</html>