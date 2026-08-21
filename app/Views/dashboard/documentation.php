<?= $this->include('dashboard/partials/header'); ?>
<!-- Page Wrapper -->
<div id="wrapper">

    <?= $this->include('dashboard/partials/sidebar'); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?= $this->include('dashboard/partials/topbar'); ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <style>
                    .btn-outline-orange {
                        color: #D96F32;
                        border-color: #D96F32;
                    }

                    .btn-outline-orange:hover {
                        color: #fff;
                        background-color: #D96F32;
                        border-color: #D96F32;
                    }
                </style>

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dokumentasi</h1>
                </div>

                <!-- Navigasi cepat -->
                <div class="card shadow mb-4">
                    <div class="card-body py-3">
                        <span class="font-weight-bold text-gray-800 mr-2">Navigasi cepat:</span>
                        <a href="#alur-bisnis" class="btn btn-sm btn-outline-orange mr-1 mb-1">Alur Kerja Bisnis</a>
                        <a href="#alur-booking" class="btn btn-sm btn-outline-orange mr-1 mb-1">Alur Booking</a>
                        <a href="#status-arti" class="btn btn-sm btn-outline-orange mr-1 mb-1">Arti Status</a>
                        <a href="#panduan-modul" class="btn btn-sm btn-outline-orange mb-1">Cara Penggunaan Modul</a>
                    </div>
                </div>

                <!-- Alur Kerja Bisnis -->
                <div class="card shadow mb-4" id="alur-bisnis">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-orange"><i class="fas fa-project-diagram mr-2"></i>Alur Kerja Bisnis</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-700">
                            Bisnis rental motor ini berjalan dengan 5 tahap besar: customer memesan online,
                            mengirim berkas &amp; pembayaran, admin memverifikasi, motor disewakan (dicatat di logbook),
                            lalu direkap dalam report.
                        </p>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-warning shadow-sm h-100 py-2 px-3">
                                    <h6 class="font-weight-bold text-gray-800"><span class="badge badge-warning mr-1">1</span> Pemesanan Online</h6>
                                    <small class="text-gray-600">Customer memilih motor di halaman Produk, menentukan tanggal sewa &amp; kembali, lalu membuat booking (wajib login). Status awal: <b>pending</b>.</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-info shadow-sm h-100 py-2 px-3">
                                    <h6 class="font-weight-bold text-gray-800"><span class="badge badge-info mr-1">2</span> Berkas &amp; Pembayaran</h6>
                                    <small class="text-gray-600">Customer mengunggah kartu identitas (KTP/SIM) dan bukti pembayaran (transfer bank atau COD) lewat menu <b>Pesanan Saya</b>.</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-primary shadow-sm h-100 py-2 px-3">
                                    <h6 class="font-weight-bold text-gray-800"><span class="badge badge-primary mr-1">3</span> Verifikasi Admin</h6>
                                    <small class="text-gray-600">Admin memeriksa identitas &amp; bukti bayar di menu <b>Booking/Transaksi</b>, lalu menyetujui (confirmed) atau membatalkan (canceled). Email notifikasi otomatis terkirim ke customer.</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-success shadow-sm h-100 py-2 px-3">
                                    <h6 class="font-weight-bold text-gray-800"><span class="badge badge-success mr-1">4</span> Operasional (Logbook)</h6>
                                    <small class="text-gray-600">Saat motor keluar, lakukan <b>Check Out</b>; saat kembali, lakukan <b>Check In</b>. Catat foto kondisi, level bahan bakar, dan catatan kondisi motor.</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-secondary shadow-sm h-100 py-2 px-3">
                                    <h6 class="font-weight-bold text-gray-800"><span class="badge badge-secondary mr-1">5</span> Laporan</h6>
                                    <small class="text-gray-600">Rekap transaksi, performa motor, dan data penyewa tersedia di menu <b>Report</b>, dapat difilter per periode dan diekspor ke Excel.</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-danger shadow-sm h-100 py-2 px-3">
                                    <h6 class="font-weight-bold text-gray-800"><span class="badge badge-danger mr-1">+</span> Pendukung</h6>
                                    <small class="text-gray-600">Inventaris (brand, tipe, motor) menjadi master data. FAQ di website dikelola lewat <b>Settings &gt; FAQ</b>.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alur Booking Detail -->
                <div class="card shadow mb-4" id="alur-booking">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-orange"><i class="fas fa-route mr-2"></i>Alur Booking dari Awal sampai Selesai</h6>
                    </div>
                    <div class="card-body">
                        <ol class="text-gray-700 mb-0">
                            <li class="mb-2"><b>Customer memilih motor</b> di halaman Produk (frontend), bisa difilter per brand atau dicari langsung.</li>
                            <li class="mb-2"><b>Mengisi tanggal sewa &amp; tanggal kembali</b>. Total harga dihitung otomatis: harga per hari &times; jumlah hari.</li>
                            <li class="mb-2"><b>Klik booking</b>. Jika belum login, sistem mengarahkan ke halaman login/register.</li>
                            <li class="mb-2"><b>Booking tercipta dengan status <span class="badge badge-warning text-white">Pending</span></b>. Customer menerima email pemberitahuan.</li>
                            <li class="mb-2"><b>Customer membuka menu Pesanan Saya</b> &rarr; Detail, lalu:
                                <ul>
                                    <li>Memilih metode pembayaran: <b>Transfer Bank</b> atau <b>Bayar di Tempat (COD)</b>,</li>
                                    <li>Mengunggah <b>kartu identitas</b> (KTP/SIM, maks 1 MB),</li>
                                    <li>Mengunggah <b>bukti pembayaran</b> (wajib untuk transfer),</li>
                                    <li>Bisa menambahkan catatan.</li>
                                </ul>
                            </li>
                            <li class="mb-2"><b>Admin memverifikasi</b> di menu Booking/Transaksi: cek identitas, cek bukti transfer, lalu ubah status pembayaran menjadi <b>completed</b> (booking jadi confirmed) atau tolak/batalkan (canceled).</li>
                            <li class="mb-2"><b>Hari penyewaan:</b> admin melakukan <b>Check Out</b> di Logbook saat motor diserahkan, dan <b>Check In</b> saat motor dikembalikan (foto + level bahan bakar + kondisi).</li>
                            <li><b>Selesai.</b> Transaksi masuk ke report bulanan. Customer dapat mengunduh invoice PDF kapan saja dari halaman detail pesanan.</li>
                        </ol>
                    </div>
                </div>

                <!-- Arti Status -->
                <div class="card shadow mb-4" id="status-arti">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-orange"><i class="fas fa-tags mr-2"></i>Arti Setiap Status</h6>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-striped mb-4">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:180px">Status Booking</th>
                                    <th>Arti</th>
                                    <th style="width:220px">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-warning text-white">Pending</span></td>
                                    <td>Booking baru dibuat, menunggu berkas/pembayaran dan verifikasi admin.</td>
                                    <td>Verifikasi lalu setujui atau batalkan.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">Confirmed</span></td>
                                    <td>Pembayaran terverifikasi / booking disetujui. Motor siap disewakan sesuai tanggal.</td>
                                    <td>Lakukan check-out/check-in di Logbook pada hari H.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-danger">Canceled</span></td>
                                    <td>Booking dibatalkan (oleh customer atau admin).</td>
                                    <td>Tidak ada aksi; motor otomatis tersedia kembali.</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-striped mb-4">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:180px">Status Pembayaran</th>
                                    <th>Arti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-warning text-white">Pending</span></td>
                                    <td>Belum ada bukti bayar / belum diverifikasi.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-success">Completed</span></td>
                                    <td>Bukti transfer valid / akan dibayar COD — pembayaran dianggap lunas.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-danger">Canceled</span></td>
                                    <td>Pembayaran batal mengikuti pembatalan booking.</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:180px">Status Motor</th>
                                    <th>Arti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-success">Available</span></td>
                                    <td>Siap disewakan dan tampil sebagai produk yang bisa dipesan.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">Rented</span></td>
                                    <td>Sedang disewakan.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-secondary">Maintenance</span></td>
                                    <td>Sedang servis/perbaikan, tidak bisa dipesan.</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-danger">Unavailable</span></td>
                                    <td>Tidak tersedia (dipakai saat pertama menambah motor).</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Panduan Penggunaan Modul -->
                <div class="card shadow mb-4" id="panduan-modul">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-orange"><i class="fas fa-question-circle mr-2"></i>Cara Penggunaan Setiap Modul</h6>
                    </div>
                    <div class="card-body">
                        <div id="accordionDokumentasi">

                            <!-- Dashboard -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headDashboard">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseDashboard" aria-expanded="false" aria-controls="collapseDashboard">
                                        <i class="fas fa-tachometer-alt text-orange mr-2"></i>Dashboard
                                    </button>
                                </div>
                                <div id="collapseDashboard" class="collapse" aria-labelledby="headDashboard" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        Menampilkan ringkasan bisnis secara real-time: jumlah permintaan pending, total motor,
                                        total penyewa, pendapatan bulan ini, grafik booking 6 bulan terakhir, motor terpopuler,
                                        dan persentase status booking. Gunakan halaman ini sebagai layar pemantauan harian.
                                    </div>
                                </div>
                            </div>

                            <!-- Booking -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headBooking">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseBooking" aria-expanded="false" aria-controls="collapseBooking">
                                        <i class="fas fa-calculator text-orange mr-2"></i>Booking / Transaksi
                                    </button>
                                </div>
                                <div id="collapseBooking" class="collapse" aria-labelledby="headBooking" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        <ul class="mb-0 pl-3">
                                            <li><b>Verifikasi:</b> klik <b>Detail</b> pada booking untuk melihat identitas &amp; bukti transfer, lalu ubah status pembayaran (completed/canceled) melalui tombol aksi.</li>
                                            <li><b>Tambah manual:</b> jika customer datang langsung (walk-in), gunakan tombol tambah booking. Bisa sekalian membuat akun user baru dari form yang sama.</li>
                                            <li><b>Hapus:</b> gunakan hanya untuk data salah input, karena tidak bisa dikembalikan.</li>
                                            <li>Setiap perubahan status otomatis mengirim email notifikasi ke customer.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Users -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headUsers">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                                        <i class="fas fa-user-alt text-orange mr-2"></i>Penyewa (Users)
                                    </button>
                                </div>
                                <div id="collapseUsers" class="collapse" aria-labelledby="headUsers" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        Kelola akun customer dan staf. Tambah user baru, edit data (nama, email, telepon, role),
                                        hapus akun, dan <b>reset password</b> jika customer lupa password. Role menentukan hak akses:
                                        <code>admin</code> mengelola seluruh dashboard, <code>user</code> hanya bisa memesan &amp; melihat pesanannya.
                                    </div>
                                </div>
                            </div>

                            <!-- Inventaris -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headInventaris">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseInventaris" aria-expanded="false" aria-controls="collapseInventaris">
                                        <i class="fas fa-wrench text-orange mr-2"></i>Inventaris (Brand, Tipe, Motor)
                                    </button>
                                </div>
                                <div id="collapseInventaris" class="collapse" aria-labelledby="headInventaris" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        Urutan pengisian master data: <b>Brand</b> (mis. Honda, Yamaha) &rarr; <b>Tipe</b> (mis. Matic, Sport)
                                        &rarr; <b>Motor</b>. Saat menambah motor, lengkapi nama, plat nomor, brand, tipe, harga per hari,
                                        status, deskripsi, dan foto (maks 2 MB). Motor dengan status <i>available</i> otomatis tampil
                                        di halaman Produk frontend. Brand juga tampil sebagai filter kategori di halaman Produk.
                                    </div>
                                </div>
                            </div>

                            <!-- Logbook -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headLogbook">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseLogbook" aria-expanded="false" aria-controls="collapseLogbook">
                                        <i class="fas fa-book text-orange mr-2"></i>Logbook
                                    </button>
                                </div>
                                <div id="collapseLogbook" class="collapse" aria-labelledby="headLogbook" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        Catatan operasional tiap motor:
                                        <ul class="mb-0 pl-3">
                                            <li><b>Check Out</b> — dicatat saat motor diserahkan ke penyewa. Foto kondisi awal, level bahan bakar (full/medium/low), dan catatan kondisi.</li>
                                            <li><b>Check In</b> — dicatat saat motor kembali. Bandingkan dengan catatan check-out untuk menilai kerusakan/konsumsi BBM.</li>
                                            <li>Gunakan kolom pencarian &amp; filter untuk menemukan riwayat per motor. Data lama bisa diedit/dihapus bila salah input.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Report -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headReport">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
                                        <i class="fas fa-folder text-orange mr-2"></i>Report
                                    </button>
                                </div>
                                <div id="collapseReport" class="collapse" aria-labelledby="headReport" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        Tiga jenis laporan: <b>Booking</b>, <b>Motor</b>, dan <b>Users</b>.
                                        Pilih rentang tanggal (dan filter lain yang tersedia), klik <b>Get Data</b> untuk menampilkan
        hasil, lalu klik <b>Export Excel</b> untuk mengunduh berkas rekap. Cocok untuk rekap harian/mingguan/bulanan.
                                    </div>
                                </div>
                            </div>

                            <!-- Settings -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headSettings">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                                        <i class="fas fa-cog text-orange mr-2"></i>Settings
                                    </button>
                                </div>
                                <div id="collapseSettings" class="collapse" aria-labelledby="headSettings" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        <ul class="mb-0 pl-3">
                                            <li><b>Profile</b> — ubah data akun admin dan ganti password.</li>
                                            <li><b>FAQ</b> — kelola daftar tanya-jawab yang tampil di halaman FAQ website publik. Jaga jawaban singkat dan jelas agar menekan pertanyaan berulang via kontak.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Notifikasi -->
                            <div class="card mb-2 border-0 shadow-sm">
                                <div class="card-header bg-white" id="headNotif">
                                    <button class="btn btn-link font-weight-bold text-gray-800 collapsed" data-toggle="collapse"
                                        data-target="#collapseNotif" aria-expanded="false" aria-controls="collapseNotif">
                                        <i class="fas fa-bell text-orange mr-2"></i>Notifikasi
                                    </button>
                                </div>
                                <div id="collapseNotif" class="collapse" aria-labelledby="headNotif" data-parent="#accordionDokumentasi">
                                    <div class="card-body text-gray-700">
                                        Ikon lonceng di kanan atas menampilkan notifikasi real-time (booking baru, pembayaran masuk).
                                        Klik untuk melihat daftar terbaru; notifikasi otomatis ditandai terbaca. Pastikan browser
                                        mengizinkan notifikasi agar alert muncul segera.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card shadow mb-4 border-left-warning">
                    <div class="card-body py-3">
                        <h6 class="font-weight-bold text-gray-800 mb-2"><i class="fas fa-lightbulb text-warning mr-2"></i>Tips Operasional</h6>
                        <ul class="text-gray-700 mb-0 pl-3">
                            <li>Cek menu Dashboard setiap pagi untuk melihat booking pending yang belum diverifikasi.</li>
                            <li>Selalu lakukan check-out/check-in logbook di hari yang sama — jangan menumpuk di akhir hari.</li>
                            <li>Set motor ke status <b>maintenance</b> segera setelah ada keluhan, agar tidak terpesan customer lain.</li>
                            <li>Unduh report Excel setiap akhir bulan sebagai arsip sebelum data banyak.</li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <?= $this->include('dashboard/partials/footer'); ?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
