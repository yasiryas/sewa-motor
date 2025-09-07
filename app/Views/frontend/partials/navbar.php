<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <!-- Logo Kiri -->
        <a class="navbar-brand fw-bold text-primary" href="<?= base_url('/') ?>">
            🚲 Wigati Rental
        </a>

        <!-- Toggle Button (Mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Tengah -->
        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
            <ul class="navbar-nav mb-2 mb-lg-0 gap-lg-4">
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark" href="#beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark" href="#layanan">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark" href="#tentang">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark" href="#kontak">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold text-dark" href="#faq">FAQ</a>
                </li>
            </ul>
        </div>

        <!-- Tombol Login Kanan -->
        <div class="d-flex">
            <a href="<?= base_url('login') ?>" class="btn btn-primary fw-semibold px-4 shadow-sm">
                Login
            </a>
        </div>
    </div>
</nav>