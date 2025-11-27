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
                    <table id="motorReportTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>id</th>
                                <th>Photo</th>
                                <th>Nama Motor</th>
                                <th>No Plat</th>
                                <th>Tipe</th>
                                <th>Price Per Day</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>

                    <div class="col-md align-items-center p-3 d-flex justify-content-center">
                        <!-- Download Excel -->
                        <form id="exportForm" method="post" action="<?= base_url('dashboard/report/motor/export') ?>" target="_blank">
                            <?= csrf_field() ?>
                            <input type="hidden" name="search_value" id="search_value">
                            <button class="btn btn-success mb-3"><i class="fas fa-file-excel"></i> Download Excel</button>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?= $this->include('dashboard/partials/footer'); ?>