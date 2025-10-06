<?php

use Faker\Provider\Base;
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="<?= base_url('img/asset/logo.png'); ?>" alt="Logo" height="40">
        </a>

        <!-- Toggle untuk mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu + Login -->
        <div class="collapse navbar-collapse justify-content-center text-center" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-2 <?= $title == 'Beranda' ? 'active text-warning' : ''; ?>"><a class="nav-link" href="<?= base_url('/'); ?>">Beranda</a></li>
                <li class="nav-item mx-2" <?= $title == 'Produk' ? 'active text-warning' : ''; ?>><a class="nav-link" href="<?= base_url('produk'); ?>">Produk</a></li>
                <li class="nav-item mx-2" <?= $title == 'Tentang Kami' ? 'active text-warning' : ''; ?>><a class="nav-link" href="#tentang">Tentang Kami</a></li>
                <li class="nav-item mx-2" <?= $title == 'FAQ' ? 'active text-warning' : ''; ?>><a class="nav-link" href="#faq">FAQ</a></li>
                <li class="nav-item mx-2" <?= $title == 'Kontak' ? 'active text-warning' : ''; ?>><a class="nav-link" href="#kontak">Kontak</a></li>
            </ul>

            <!-- Tombol Login (desktop & mobile) -->
            <div class="mt-3 mt-lg-0">
                <a href="<?= base_url('login'); ?>" class="btn btn-warning rounded text-light px-4">Login</a>
            </div>
        </div>
    </div>
</nav>