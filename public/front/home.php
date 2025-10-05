<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sewa Skuter Jogja</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff8f0;
            scroll-behavior: smooth;
        }

        .btn-warning {
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            background: #ff9d00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .navbar-nav .nav-link {
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ff9d00 !important;
        }

        .card {
            border: none;
            transition: all 0.3s ease;
            border-radius: 15px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-weight: bold;
            color: #f4a300;
            margin-bottom: 30px;
            position: relative;
        }

        .section-title::after {
            content: "";
            width: 60px;
            height: 3px;
            background: #f4a300;
            display: block;
            margin: 10px auto 0;
            border-radius: 3px;
        }

        footer {
            background: #fdf5ec;
            padding: 40px 0;
        }

        footer a {
            color: #333;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #f4a300;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="logo.png" alt="Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active"><a class="nav-link text-warning font-weight-bold" href="#hero">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                </ul>
                <a href="#" class="btn btn-warning rounded-pill">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="py-5" style="margin-top:70px;">
        <div class="container d-flex align-items-center">
            <div class="row w-100">
                <div class="col-md-6 text-center">
                    <img src="motor.png" class="img-fluid" alt="Motor">
                </div>
                <div class="col-md-6 d-flex flex-column justify-content-center">
                    <h2><strong>Jelajahi Setiap Sudut Jogja Tanpa Batas!</strong></h2>
                    <p>Mulai dari keramaian Malioboro hingga ketenangan alam pedesaan, nikmati kebebasan bergerak dengan armada skuter terawat kami. Bebas macet, bebas khawatir!</p>
                    <a href="#" class="btn btn-warning rounded-pill">Pesan Sekarang!</a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h3 class="section-title">How It Works</h3>
            <div class="row">
                <div class="col-md-4">
                    <h4>1</h4>
                    <p><strong>Pilih & Tentukan Jadwalmu</strong><br> Klik skuter favoritmu, lalu tentukan tanggal dan durasi sewa yang kamu inginkan.</p>
                </div>
                <div class="col-md-4">
                    <h4>2</h4>
                    <p><strong>Isi Data & Selesaikan Pembayaran</strong><br> Lengkapi formulir pemesanan lalu lakukan pembayaran melalui metode yang tersedia.</p>
                </div>
                <div class="col-md-4">
                    <h4>3</h4>
                    <p><strong>Siap Jelajahi Jogja!</strong><br> Skuter siap kamu ambil langsung di tempat kami. Selamat menikmati petualanganmu!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Product -->
    <section id="produk" class="py-5 text-center">
        <div class="container">
            <h3 class="section-title">Featured Product</h3>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="scooter1.png" class="card-img-top" alt="Fazzio">
                        <div class="card-body">
                            <h5>Fazzio</h5>
                            <p>Rp. 80.000 /Day</p>
                            <a href="#" class="btn btn-warning btn-sm rounded-pill">Booking</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="scooter2.png" class="card-img-top" alt="Grand Filano">
                        <div class="card-body">
                            <h5>Grand Filano</h5>
                            <p>Rp. 100.000 /Day</p>
                            <a href="#" class="btn btn-warning btn-sm rounded-pill">Booking</a>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan produk lain -->
            </div>
            <a href="#" class="btn btn-outline-warning rounded-pill mt-3">Lihat yang lain →</a>
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

    <!-- Footer -->
    <footer>
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <img src="logo.png" alt="Logo" height="40">
                <p class="mt-2 mb-0">Teman Setia Keliling Jogja</p>
            </div>
            <div>
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
        <div class="text-center mt-4">
            <small>sewaskuterjogja.com - ©2025</small>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>