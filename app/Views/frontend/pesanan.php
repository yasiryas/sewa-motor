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
            <div class="col-md-8">
                <?php if (!empty($bookings)): ?>
                    <table id="tableUserBookings" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Motor</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><b><?php esc($booking['brand_name']); ?> <?php esc($booking['motor_name']); ?></b></td>
                                    <td><?php echo date('d F Y', strtotime($booking['rental_start_date'])); ?></td>
                                    <td><?php echo date('d F Y', strtotime($booking['rental_end_date'])); ?></td>
                                    <td><?php esc($booking['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php //foreach ($bookings as $booking):
                    ?>





                    <!-- versi card -->
                    <!-- <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <b><?php // esc($booking['brand_name']);
                                        ?> <?php // esc($booking['motor_name']);
                                            ?></b>
                                </h4>
                                <p><strong>Tanggal Sewa:</strong> <?php // date('d F Y', strtotime($booking['rental_start_date']));
                                                                    ?></p>
                                <p><strong>Tanggal Kembali:</strong> <?php // date('d F Y', strtotime($booking['rental_end_date']));
                                                                        ?></p>
                                <p><strong>Status:</strong> <?php // esc($booking['status']);
                                                            ?></p>
                            </div>
                        </div> -->
                    <?php //endforeach;
                    ?>
                <?php else: ?>
                    <div class="alert alert-info text-center">Belum ada pesanan.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>