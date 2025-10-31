<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>
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
<section id="pesanan" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg">
                <div class="card shadow-sm rounded-4 border-0">
                    <div class="card-body">
                        <?php if (!empty($bookings)): ?>
                            <table id="tableUserBookings" class="table table-hover align-middle">
                                <thead class="">
                                    <tr>
                                        <th>Motor</th>
                                        <th>Tanggal Sewa</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td><b><?= $booking['brand_name']; ?> <?= $booking['motor_name']; ?></b></td>
                                            <td><?php echo date('d F Y', strtotime($booking['rental_start_date'])); ?></td>
                                            <td><?php echo date('d F Y', strtotime($booking['rental_end_date'])); ?></td>
                                            <td>
                                                <?php if ($booking['status'] == 'pending'): ?>
                                                    <span class="badge bg-warning badge-pill text-white">Pending</span>
                                                <?php elseif ($booking['status'] == 'confirmed'): ?>
                                                    <span class="badge bg-primary badge-pill text-white">Confirmed</span>
                                                <?php elseif ($booking['status'] == 'canceled'): ?>
                                                    <span class="badge bg-danger badge-pill text-white">Canceled</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('pesanan/detail/' . $booking['id']); ?>" class="btn btn-sm btn-warning">Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="text-center text-orange">Upss, Belum ada pesanan.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>