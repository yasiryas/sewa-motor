<?php

use Faker\Provider\Base;
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
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
                <li class="nav-item mx-2 "><a class="nav-link <?= $title == 'Beranda' ? 'active text-warning' : ''; ?>" href="<?= base_url('/'); ?>">Beranda</a></li>
                <li class="nav-item mx-2 "><a class="nav-link <?= $title == 'Produk' ? 'active text-warning' : ''; ?>" href="<?= base_url('produk'); ?>">Produk</a></li>
                <li class="nav-item mx-2 "><a class="nav-link <?= $title == 'Tentang Kami' ? 'active text-warning' : ''; ?>" href="<?= base_url('tentang-kami'); ?>">Tentang Kami</a></li>
                <li class="nav-item mx-2 "><a class="nav-link <?= $title == 'FAQ' ? 'active text-warning' : ''; ?>" href="<?= base_url('faq'); ?>">FAQ</a></li>
                <li class="nav-item mx-2 "><a class="nav-link <?= $title == 'Kontak' ? 'active text-warning' : ''; ?>" href="<?= base_url('kontak'); ?>">Kontak</a></li>
            </ul>

            <!-- Tombol Login (desktop & mobile) -->
            <div class="mt-3 mt-lg-0">
                <a href="<?= base_url('login'); ?>" class="btn btn-warning rounded text-light px-4">Login</a>
            </div>
        </div>
    </div>
</nav>