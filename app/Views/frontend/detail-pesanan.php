<?= $this->include('frontend/partials/header'); ?>
<?= $this->include('frontend/partials/navbar'); ?>

<section id="produk" class="py-5" style="height: 40vh;
    background:linear-gradient(0deg, rgba(255,255,255,0.85), rgba(255,255,255,0.85)),
    url('<?= base_url('img/asset/bg-kontak.jpg'); ?>') center/cover no-repeat;
    display:flex;justify-content:center;align-items:center;text-align:center;">
    <div class="container">
        <h2 class="text-center m-5 font-weight-bold text-dark"><?= $title; ?></h2>
    </div>
</section>

<section id="detailPesanan">
    <div class="container py-5">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card shadow-lg border-0 rounded-4 p-4 bg-light">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-dark mb-1">Nota Pembayaran</h3>
                <small class="text-muted">ID Pesanan: <strong>#<?= $booking['id']; ?></strong></small>
            </div>

            <div class="row g-4">
                <!-- Gambar Motor -->
                <div class="col-lg-4 text-center">
                    <img src="<?= base_url('uploads/motors/' . $booking['photo']); ?>"
                        alt="Foto Motor"
                        class="img-fluid rounded-3 mb-3"
                        style="max-height: 250px; object-fit: cover;">
                    <h5 class="fw-bold mt-2"><?= esc($booking['brand_name']); ?> <?= esc($booking['motor_name']); ?></h5>
                    <p class="text-muted mb-0"><i class="bi bi-geo-alt"></i> <?= esc($booking['number_plate']); ?></p>
                </div>

                <!-- Detail Nota -->
                <div class="col-lg-8">
                    <div class="bg-white rounded-4 shadow-sm p-4">
                        <h5 class="fw-bold text-dark mb-3">Detail Transaksi</h5>
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td><strong>Tanggal Pemesanan</strong></td>
                                <td class="text-end"><?= date('d F Y H:i', strtotime($booking['created_at'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Sewa</strong></td>
                                <td class="text-end"><?= date('d F Y', strtotime($booking['rental_start_date'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Kembali</strong></td>
                                <td class="text-end"><?= date('d F Y', strtotime($booking['rental_end_date'])); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Harga per Hari</strong></td>
                                <td class="text-end">Rp <?= number_format($booking['price_per_day'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr class="border-top">
                                <td><strong>Total Pembayaran</strong></td>
                                <td class="text-end fw-bold text-success fs-5">
                                    Rp <?= number_format($booking['total_price'], 0, ',', '.'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td class="text-end">
                                    <?php if ($booking['status'] == 'pending'): ?>
                                        <span class="badge bg-warning text-white">Pending</span>
                                    <?php elseif ($booking['status'] == 'confirmed'): ?>
                                        <span class="badge bg-primary text-white">Confirmed</span>
                                    <?php elseif ($booking['status'] == 'waiting_confirmation'): ?>
                                        <span class="badge bg-info text-white">Menunggu Konfirmasi</span>
                                    <?php elseif ($booking['status'] == 'canceled'): ?>
                                        <span class="badge bg-danger text-white">Canceled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <form action="<?= base_url('booking/update-from-detail-user') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id_booking" id="id_booking" value="<?= $booking['id']; ?>">
                        <input type="hidden" name="id_payment" id="id_payment" value="<?= $booking['payment_id']; ?>">
                        <!-- Metode Pembayaran -->
                        <div class="bg-white rounded-4 shadow-sm p-4 mt-4">
                            <h5 class="fw-bold text-dark mb-3">Pilih Metode Pembayaran</h5>
                            <?php
                            $selectedMethod = old('payment_method', $booking['payment_method']);
                            ?>

                            <div class="d-flex flex-column flex-md-row gap-3">
                                <button type="button" id="btnTransfer"
                                    class="method-btn w-100 p-3 rounded-3 border <?= $selectedMethod == 'transfer' ? 'bg-primary text-white active' : ''; ?>">
                                    <i class="bi bi-bank fs-4 mb-2 d-block"></i>
                                    <strong>Transfer Bank</strong><br>
                                    <small>BCA / Mandiri / BRI</small>
                                </button>

                                <button type="button" id="btnCOD"
                                    class="method-btn w-100 p-3 rounded-3 border <?= $selectedMethod == 'cash' ? 'bg-primary text-white active' : ''; ?>">
                                    <i class="bi bi-cash-stack fs-4 mb-2 d-block"></i>
                                    <strong>Bayar di Tempat</strong><br>
                                    <small>(COD)</small>
                                </button>

                                <input type="hidden" name="payment_method" id="payment_method" value="">
                            </div>

                            <!-- Rekening Bank -->
                            <div id="rekeningSection" class="mt-4 bg-light p-3 rounded-3 <?= $selectedMethod == 'transfer' ? '' : 'd-none'; ?>">
                                <p class="fw-bold mb-1">Nomor Rekening:</p>
                                <p class="mb-0">BCA - 1234567890 a.n. <strong>Rental Motor Indonesia</strong></p>
                                <p class="small text-muted mb-0">Kirim sesuai total pembayaran dan upload bukti di bawah ini.</p>
                            </div>

                            <!-- COD Section -->
                            <div id="CODSection" class="mt-4 bg-light p-3 rounded-3 <?= $selectedMethod == 'cash' ? '' : 'd-none'; ?>">
                                <p class="fw-bold mb-1">Pembayaran dilakukan di tempat (COD)</p>
                                <p class="mb-0">Rental Motor Jogja <strong>Jl. Karangwaru No. 12</strong></p>
                                <p class="small text-muted mb-0">Pesanan kamu akan disimpan dan dibayar saat pengambilan motor.</p>
                            </div>
                        </div>

                        <!-- Form Keterangan -->
                        <div class="bg-white rounded-4 shadow-sm p-4 mt-4">
                            <h5 class="fw-bold text-dark mb-3">Catatan Pembeli</h5>
                            <p class="text-muted mb-3">Silakan tambahkan catatan tambahan di bawah ini:</p>
                            <textarea class="form-control" rows="3" placeholder="Catatan tambahan..." name="notes"><?= old('notes', $booking['notes']); ?></textarea>
                        </div>

                        <!-- Upload kartu identitas   -->
                        <div class="bg-white rounded-4 shadow-sm p-4 mt-4">
                            <h5 class="fw-bold text-dark mb-3">Unggah Kartu Identitas (KTP/SIM)</h5>
                            <?php if (empty($booking['identity_photo'])): ?>
                                <p class="text-muted mb-3">Kamu belum mengunggah kartu identitas. Silakan unggah di bawah ini:</p>
                                <div class="mb-3">
                                    <input type="file" name="identity_photo" id="identity_photo" class="photo-input form-control-file" accept="image/*" required>
                                    <img src="#" alt="Preview Gambar" class="photo-preview img-fluid mt-2" style="max-width:300px; display:none;">
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-2">Kartu identitas kamu:</p>
                                <img src="<?= base_url('uploads/identitas/' . $booking['identity_photo']); ?>"
                                    alt="Kartu Identitas" class="img-fluid rounded shadow-sm mb-3" style="max-width: 400px;">
                            <?php endif; ?>
                        </div>

                        <!-- Bukti Pembayaran -->
                        <div class="bg-white rounded-4 shadow-sm p-4 mt-4">
                            <h5 class="fw-bold text-dark mb-3">Bukti Pembayaran</h5>
                            <?php if (empty($booking['payment_proof'])): ?>
                                <p class="text-muted mb-3">Kamu belum mengunggah bukti pembayaran. Silakan unggah di bawah ini:</p>
                                <div class="mb-3">
                                    <input type="file" name="payment_proof" id="payment_proof" class="photo-input form-control-file" accept="image/*" required>
                                    <img src="#" alt="Preview Gambar" class="photo-preview img-fluid mt-2" style="max-width:300px; display:none;">
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-2">Bukti pembayaran kamu:</p>
                                <img src="<?= base_url('uploads/payments/' . $booking['payment_proof']); ?>"
                                    alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm mb-3" style="max-width: 400px;">
                            <?php endif; ?>
                        </div>
                        <div class="mt-4 d-flex justify-content-center align-items-center gap-2">
                            <a href="<?= base_url('booking/cancel-user/' . $booking['id']); ?>" class="btn btn-danger w-100 m-2">
                                <i class="fa fa-times"></i> Batalkan Pesanan
                            </a>
                            <a href="<?= base_url('booking/invoice/' . $booking['id']); ?>" class="btn btn-success w-100 m-2">
                                <i class="fa fa-download"></i> Download Invoice
                            </a>
                            <button type="submit" class="btn btn-primary w-100 m-2">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Konfirmasi COD -->
<div class="modal fade" id="confirmCODModal" tabindex="-1" aria-labelledby="confirmCODModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmCODModalLabel">Konfirmasi Pembayaran COD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin ingin memilih metode <strong>Bayar di Tempat (COD)</strong>?
                Pesanan kamu akan disimpan dan dibayar saat pengambilan motor.
            </div>
            <div class="modal-footer">
                <form action="<?= base_url('booking/update-metode/' . $booking['id']); ?>" method="post">
                    <input type="hidden" name="payment_method" value="cod">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Ya, Saya Yakin</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->include('frontend/partials/footer'); ?>