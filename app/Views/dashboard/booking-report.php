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
                <div class="card p-3">
                    <h2 class="text-center p-3"><?= $submenu_title; ?></h2>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label>Start Date</label>
                            <input type="date" id="start_date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>End Date</label>
                            <input type="date" id="end_date" class="form-control">
                        </div>

                    </div>
                    <table id="bookingTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Motor</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    </table>

                    <div class="col-md align-items-center p-3 d-flex justify-content-center">
                        <!-- Download Excel -->
                        <form method="post" action="<?= base_url('dashboard/report/booking/export') ?>" target="_blank">
                            <?= csrf_field() ?>
                            <input type="hidden" name="start_date" id="start_date_hidden">
                            <input type="hidden" name="end_date" id="end_date_hidden">
                            <button class="btn btn-success mb-3"><i class="fas fa-file-excel"></i> Download Excel</button>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?= $this->include('dashboard/partials/footer'); ?>