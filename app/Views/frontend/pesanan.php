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
        <div class="row justify-content-center d-flex">
            <div class="col-md">
                <div class="card shadow-sm rounded-4 border-0">
                    <div class="card-body table-responsive justify-content-center">
                        <?php if (!empty($bookings)): ?>
                            <table id="tableUserBookings" class="table table-hover align-middle justify-content-center">
                                <thead class="">
                                    <tr>
                                        <th>Motor</th>
                                        <th>Tanggal Sewa</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td><b><?= $booking['brand_name']; ?> <?= $booking['motor_name']; ?></b></td>
                                            <td><?php echo date('d F Y', strtotime($booking['rental_start_date'])); ?> - <?php echo date('d F Y', strtotime($booking['rental_end_date'])); ?></td>
                                            <td>
                                                <?php if ($booking['status'] == 'pending'): ?>
                                                    <span class="badge bg-warning  text-white">Pending</span>
                                                <?php elseif ($booking['status'] == 'confirmed'): ?>
                                                    <span class="badge bg-primary  text-white">Confirmed</span>
                                                <?php elseif ($booking['status'] == 'canceled'): ?>
                                                    <span class="badge bg-danger  text-white">Canceled</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($booking['status'] == 'pending'): ?>
                                                    <form action="<?= base_url('booking/cancel/' . $booking['id']); ?>" method="POST" class="d-inline">
                                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin membatalkan pesanan ini?')">Batal</button>
                                                    </form>
                                                    <button class="btn btn-sm btn-primary ">Upload Bukti</button> <?php endif; ?>
                                                <!-- <a href="<?php // echo base_url('booking/detail-booking/' . $booking['id']);
                                                                ?>" class="btn btn-sm btn-warning text-white">Detail</a> -->
                                                <button data-toggle="modal" data-target="#detailModal" data-id="<?= $booking['id']; ?>" class="btn btn-sm btn-warning text-white btn-detail-transaction">Detail</button>
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

<!-- modal view transaction -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card mb-3 border-0 shadow-none">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img id="detailPhotoMotor" src="..." class="card-img" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 id="detailNamaMotor" class="card-title">Card title</h5>
                                <p id="detailTanggalSewa" class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                <p id="detailTanggalTransaksi" class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                    <p>Note: Data transaksi yang dihapus tidak dapat dikembalikan.</p>
                    <p id="detailKeterangan" class="card-text"></p>
                    <img id="detailBukti" src="" alt="">
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-sm btn-success" href="<?= base_url('booking/invoice'); ?>">Download Invoice</a>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm">Save changes</button>
            </div>
        </div>
    </div>
</div>


<?= $this->include('frontend/partials/footer'); ?>