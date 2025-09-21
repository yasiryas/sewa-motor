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

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Booking</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-target="#addBookingModal" data-toggle="modal">
                        <i class="fas fa-plus fa-sm text-white-50"> </i> Booking Baru</a>
                </div>
                <div class="card shadow mb-4">

                    <div class="card-body">

                        <?php if (empty($bookings)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada data booking.
                                Silakan lakukan booking motor terlebih dahulu.
                            </div>
                        <?php else: ?>

                            <div class="table-responsive">
                                <table class="table table-bordered datatable" id="bookingTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama User</th>
                                            <th>Motor</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= esc($booking['username']); ?></td>
                                                <td><?= esc($booking['motor_name']); ?></td>
                                                <td><?= esc($booking['rental_start_date']); ?></td>
                                                <td><?= esc($booking['rental_end_date']); ?></td>
                                                <td>Rp <?= number_format($booking['total_price']); ?></td>
                                                <td>
                                                    <?php if ($booking['status'] == 'pending'): ?>
                                                        <span class="badge badge-warning">Pending</span>
                                                    <?php elseif ($booking['status'] == 'approved'): ?>
                                                        <span class="badge badge-success">Approved</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Canceled</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
            <!-- Modal area  -->
            <!-- Modal new booking -->
            <div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Booking Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('dashboard/booking/update'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <input type="hidden" name="id_user_booking" id="id_user_booking">
                                <div class="form-group position-relative">
                                    <label for="search_user">Cari User</label>
                                    <div class="form-row">
                                        <div class="col w-100">
                                            <input type="text" id="search_user" class="form-control w-100 align-left" placeholder="Ketik username atau email...">
                                            <!-- hidden untuk simpan id user -->
                                            <input type="hidden" id="user_id" name="user_id">
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-primary w-100" id="add_user" href="#" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-user-plus"></i> Add user</a>
                                        </div>
                                    </div>
                                    <!-- container hasil pencarian -->
                                    <div id="user_results" class="list-group position-absolute w-100"
                                        style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="edit_motor_id">Motor</label>
                                    <select class="form-control" id="edit_motor_id" name="motor_id" required>
                                        <option value="">-- Pilih Motor --</option>
                                        <?php foreach ($motors as $motor): ?>
                                            <option value="<?= $motor['id']; ?>"><?= esc($motor['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="edit_rental_start_date">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="edit_rental_start_date" name="rental_start_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_rental_end_date">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="edit_rental_end_date" name="rental_end_date" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal area end -->
        </div>
        <!-- End of Main Content -->

        <?= $this->include('dashboard/partials/footer'); ?>