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
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
                            class="fas fa-plus fa-sm text-white-50"> </i> Booking Baru</a>
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

        </div>
        <!-- End of Main Content -->
        <!-- DataTables JS -->
        <script src="<?= base_url('vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>

        <?= $this->include('dashboard/partials/footer'); ?>