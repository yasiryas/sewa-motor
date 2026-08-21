# Sewa Skuter Jogja — Aplikasi Rental Motor Online

Aplikasi web rental motor/skuter berbasis **CodeIgniter 4** dengan dua sisi:
**website publik** untuk pelanggan (katalog, booking, pembayaran) dan **dashboard admin**
untuk mengelola transaksi, inventaris motor, logbook operasional, hingga laporan Excel.

---

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi](#teknologi)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Akun Default](#akun-default)
- [Alur Kerja Bisnis](#alur-kerja-bisnis)
- [Menu Dashboard](#menu-dashboard)
- [Konfigurasi Tambahan](#konfigurasi-tambahan)
- [Struktur Direktori Penting](#struktur-direktori-penting)
- [Rute Utama](#rute-utama)
- [Lisensi](#lisensi)

---

## Fitur

### Website Publik (Customer)

| Fitur | Keterangan |
|---|---|
| Katalog produk | Daftar motor dengan foto, harga per hari, filter per brand, dan pencarian real-time (AJAX) |
| Detail motor | Halaman detail lengkap dengan form pilih tanggal sewa |
| Booking online | Perhitungan total harga otomatis (harga/hari × jumlah hari), wajib login |
| Pesanan saya | Daftar booking milik user beserta statusnya |
| Pembayaran | Pilih metode transfer bank / COD, unggah kartu identitas (KTP/SIM) dan bukti transfer |
| Invoice PDF | Unduh invoice booking dalam format PDF (Dompdf) |
| Halaman informasi | Beranda, Tentang Kami, FAQ (dinamis dari dashboard), Kontak (form email) |

### Dashboard Admin

| Modul | Fungsi |
|---|---|
| Dashboard | Statistik ringkas: booking pending, total motor, total penyewa, pendapatan bulan ini, grafik 6 bulan terakhir, motor terpopuler |
| Booking/Transaksi | Verifikasi identitas & bukti bayar, ubah status (setujui/batalkan), tambah booking walk-in, hapus data |
| Penyewa (Users) | Kelola akun customer: tambah, edit, hapus, reset password |
| Inventaris | Master data **Brand → Tipe → Motor** (foto, plat nomor, harga per hari, status ketersediaan) |
| Logbook | Check-out/check-in motor: foto kondisi, level bahan bakar (full/medium/low), catatan kondisi |
| Report | Laporan Booking / Motor / Users dengan filter periode + ekspor Excel (PhpSpreadsheet) |
| Settings | Profil & password admin, kelola FAQ website |
| Notifikasi | Notifikasi real-time di topbar (database + Firebase Cloud Messaging) dan email otomatis |
| Dokumentasi | Panduan alur kerja bisnis & cara penggunaan tiap modul langsung di dalam aplikasi |

---

## Teknologi

- **Framework**: [CodeIgniter 4](https://codeigniter.com/user_guide/) (^4.0)
- **Bahasa**: PHP ^8.1, JavaScript (jQuery), HTML/CSS (Bootstrap 4 - SB Admin 2)
- **Database**: MySQL/MariaDB
- **Library utama**:
  - `dompdf/dompdf` — generate invoice PDF
  - `phpoffice/phpspreadsheet` — ekspor laporan Excel
  - `pusher/pusher-php-server` — (opsional) realtime
- **Lainnya**: DataTables, Select2, Summernote, Chart.js, Bootstrap Datepicker, Firebase JS SDK (notifikasi FCM)

## Persyaratan Sistem

- PHP **8.1+** dengan ekstensi: `intl`, `mbstring`, `json`, `mysqlnd`, `gd` (untuk gambar), `curl`
- Composer
- MySQL 5.7+ / MariaDB 10.3+
- Web server: Laragon/XAMPP (lokal) atau Nginx/Apache (produksi, arahkan document root ke `public/`)

---

## Instalasi

### 1. Clone & install dependensi

```bash
git clone https://github.com/yasiryas/sewa-motor.git
cd sewa-motor
composer install
```

### 2. Setup environment

Salin file `env` menjadi `.env`, lalu sesuaikan:

```bash
cp env .env   # Windows: copy env .env
```

```ini
CI_ENVIRONMENT = development        # ganti 'production' saat deploy

app.baseURL = 'http://sewa-motor.test/'   # sesuaikan domain lokal Anda

database.default.hostname = localhost
database.default.database = sewa_motor
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

> Buat database `sewa_motor` (atau nama lain sesuai konfigurasi) terlebih dahulu.

### 3. Migrasi database & seed data awal

```bash
php spark migrate
php spark db:seed UserSeeder
php spark db:seed BrandSeeder
php spark db:seed TypeSeeder
php spark db:seed MotorSeeder
```

### 4. Izin folder (Linux/macOS)

Pastikan folder `writable/` dan `public/uploads/` dapat ditulis web server:

```bash
chmod -R 775 writable public/uploads
```

### 5. Jalankan

```bash
php spark serve
```

Buka `http://localhost:8080`. Jika memakai Laragon, otomatis tersedia di
`http://sewa-motor.test` (virtual host ke folder `public/`).

---

## Akun Default

Dibuat oleh `UserSeeder` — **wajib diganti setelah instalasi produksi**:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@mail.com` | `admin123` |
| User (penyewa) | `user@mail.com` | `user123` |

---

## Alur Kerja Bisnis

Ringkasan alur (panduan lengkap tersedia di menu **Dashboard → Dokumentasi**):

1. **Pemesanan** — customer memilih motor, menentukan tanggal sewa & kembali, membuat booking (status `pending`).
2. **Berkas & pembayaran** — customer mengunggah identitas + bukti transfer (atau pilih COD) lewat halaman *Pesanan Saya*.
3. **Verifikasi admin** — admin mengecek berkas di menu Booking/Transaksi, lalu menyetujui (`confirmed`) atau membatalkan (`canceled`). Email notifikasi terkirim otomatis.
4. **Operasional** — motor di-*check out* saat diserahkan dan di-*check in* saat kembali, lengkap dengan foto kondisi & level bahan bakar.
5. **Pelaporan** — rekap transaksi/motor/users diekspor ke Excel per periode.

Status yang dipakai:

- **Booking**: `pending` → `confirmed` / `canceled`
- **Pembayaran**: `pending` → `completed` / `canceled`
- **Motor**: `available` / `rented` / `maintenance` / `unavailable`

---

## Menu Dashboard

Setelah login sebagai admin (`/dashboard/index`):

```
Dashboard          → statistik & grafik
Booking/Transaksi  → verifikasi & kelola booking
Penyewa (Users)    → manajemen akun customer
Logbook            → check-in / check-out motor
Inventaris         → Brand, Tipe, Motor
Report             → Booking, Motor, Users (+ ekspor Excel)
Settings           → Profile, FAQ
Dokumentasi        → panduan penggunaan internal
```

---

## Konfigurasi Tambahan

### Email (SMTP)

Konfigurasi email dibaca dari `app/Config/Email.php` / `.env` (prefix `email.`).
Digunakan untuk notifikasi booking, konfirmasi pembayaran, dan form kontak website
(`POST /send-email`). Pastikan SMTP aktif agar fitur notifikasi berfungsi.

### Firebase Cloud Messaging (opsional)

Notifikasi push browser menggunakan Firebase:

1. Buat proyek di [Firebase Console](https://console.firebase.google.com).
2. Isi konfigurasi di `public/dashboard/js/firebase.js`.
3. Service worker tersedia di `public/dashboard/firebase-messaging-sw.js`.

Tanpa Firebase, aplikasi tetap berjalan — notifikasi tetap masuk via database & email.

---

## Struktur Direktori Penting

```
sewa-motor/
├── app/
│   ├── Config/Routes.php      # semua rute aplikasi
│   ├── Controllers/           # FrontController (publik), BookingController, dst.
│   ├── Models/                # BookingModel, MotorModel, PaymentModel, dst.
│   ├── Views/
│   │   ├── frontend/          # halaman publik + partials (header/navbar/footer)
│   │   ├── dashboard/         # halaman admin + partials (sidebar/topbar/footer)
│   │   ├── auth/              # login & register
│   │   └── emails/            # template email HTML
│   ├── Database/
│   │   ├── Migrations/        # skema tabel (users, motors, bookings, payments, dst.)
│   │   └── Seeds/             # data awal (user, brand, type, motor)
│   └── Helpers/email_helper.php
├── public/
│   ├── uploads/               # file upload (motors, brands, payments, identitas, logbook)
│   ├── front/                 # aset frontend (css/js)
│   └── dashboard/             # aset SB Admin 2 + vendor
└── writable/                  # cache, logs, session
```

## Rute Utama

| Rute | Keterangan |
|---|---|
| `/` | Beranda |
| `/produk`, `/produk/(:id)` | Katalog & detail motor |
| `/tentang-kami`, `/faq`, `/kontak` | Halaman informasi |
| `/login`, `/register` | Autentikasi |
| `/booking/pesanan` | Daftar pesanan user (auth) |
| `/dashboard/index` | Dashboard admin (auth + role admin) |
| `/dashboard/documentation` | Panduan penggunaan di dalam aplikasi |
| `POST /send-email` | Form kontak |

Daftar lengkap: `php spark routes`.

---

## Lisensi

Proyek ini dirilis under [MIT License](LICENSE).
