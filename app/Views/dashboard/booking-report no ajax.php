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

                <h3 class="mb-4">Report Booking</h3>

                <form method="get" action="" class="mb-3 row">
                    <div class="col-md-3">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control"
                            value="<?= $_GET['start_date'] ?? '' ?>">
                    </div>

                    <div class="col-md-3">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control"
                            value="<?= $_GET['end_date'] ?? '' ?>">
                    </div>

                    <div class="col-md-2 align-self-end">
                        <button class="btn btn-primary btn-block">Filter</button>
                    </div>
                </form>

                <!-- Download Excel -->
                <form method="post" action="<?= base_url('dashboard/report/booking/export') ?>" target="_blank">
                    <?= csrf_field() ?>
                    <input type="hidden" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>">
                    <input type="hidden" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>">
                    <button class="btn btn-success mb-3"><i class="fas fa-file-excel"></i> Download Excel</button>
                </form>

                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Motor</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $booking['username'] ?></td>
                                        <td><?= $booking['motor_name'] ?></td>
                                        <td><?= $booking['created_at'] ?></td>
                                        <td><?= ucfirst($booking['status']) ?></td>
                                        <td><?= number_format($booking['total_price']) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?= $this->include('dashboard/partials/footer'); ?>