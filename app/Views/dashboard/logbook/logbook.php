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
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
                    <div class="align-item-end">
                        <button class="btn btn-sm btn-primary mr-1"
                            data-toggle="modal"
                            data-target="#logbookModal"
                            data-type="check-in">
                            <i class="fas fa-sign-in-alt"></i> Check In
                        </button>

                        <button class="btn btn-sm btn-warning"
                            data-toggle="modal"
                            data-target="#logbookModal"
                            data-type="check-out">
                            <i class="fas fa-sign-out-alt"></i> Check Out
                        </button>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Filter -->
                        <form method="get" class="mb-3">
                            <div class="row align-items-end">
                                <div class="col-md-2 mb-2">
                                    <label>Jenis</label>
                                    <select name="type" class="form-control">
                                        <option value="">Semua</option>
                                        <option value="check-in" <?= request()->getGet('type') == 'check-in' ? 'selected' : '' ?>>Check In</option>
                                        <option value="check-out" <?= request()->getGet('type') == 'check-out' ? 'selected' : '' ?>>Check Out</option>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label>Dari</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="<?= request()->getGet('start_date') ?>">
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label>Sampai</label>
                                    <input type="date" name="end_date" class="form-control"
                                        value="<?= request()->getGet('end_date') ?>">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Motor</label>
                                    <select name="motor" id="motor-filter" class="form-control motor-select">
                                        <option value="">Semua Motor</option>
                                        <?php foreach ($motors as $motor): ?>
                                            <option value="<?= $motor['id'] ?>" <?= request()->getGet('motor') == $motor['id'] ? 'selected' : '' ?>>
                                                <?= esc($motor['name']) ?> - <?= esc($motor['number_plate']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <button class="btn btn-primary w-100">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                </div>
                            </div>

                        </form>
                        <hr>

                        <?php
                        if (empty($logs)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada Record. Silakan tambah record terlebih dahulu.
                            </div>
                        <?php endif;
                        ?>
                        <table class="table table-bordered datatable" id="checkInTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Motor</th>
                                    <th>Petugas Input</th>
                                    <th>Jenis</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($log['kode']); ?></td>
                                        <td><?= esc($log['motor']); ?> <br> <?= esc($log['number_plate']); ?></td>
                                        <td><?= esc($log['penyewa']); ?></td>
                                        <td> <span class="badge badge-<?= $log['type'] == 'check-in' ? 'success' : 'warning'; ?>">
                                                <?= esc($log['type']); ?>
                                            </span>
                                        </td>
                                        <td><?= esc(date("d M Y H:i", strtotime($log['waktu']))); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary m-1"><i class="fas fa-search"></i> Detail</a>
                                            <a href="#" class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- modal -->
                <?= $this->include('dashboard/logbook/modal-logbook'); ?>
            </div>
            <!-- Content Row -->
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (typeof $ === 'undefined') {
                console.error('jQuery belum termuat');
                return;
            }

            /* =============================
               INIT SELECT2 (SATU KALI)
            ============================== */

            $('#motor-modal').select2({
                dropdownParent: $('#logbookModal'),
                theme: 'bootstrap4',
                placeholder: "Pilih Motor",
                allowClear: true,
                width: '100%'
            });

            $('#select-booking').select2({
                dropdownParent: $('#logbookModal'),
                theme: 'bootstrap4',
                placeholder: "Pilih Booking",
                allowClear: true,
                width: '100%'
            });

            $('#motor-filter').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Motor",
                allowClear: true,
                width: '100%'
            });

            /* =============================
               MODAL SHOW EVENT
            ============================== */
            $('#logbookModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let type = button.data('type');

                $('#logType').val(type);

                $('.modal-title').text(
                    type === 'check-in' ?
                    'Check In Motor' :
                    'Check Out Motor'
                );
            });

            $('#select-booking').on('change', function() {
                let motorId = $(this).find(':selected').data('motor');

                if (motorId) {
                    $('#motor-modal')
                        .val(motorId)
                        .trigger('change')
                        .prop('disabled', true);
                } else {
                    $('#motor-modal')
                        .val(null)
                        .trigger('change')
                        .prop('disabled', false);
                }
            });

        });
    </script>




    <?= $this->include('dashboard/partials/footer'); ?>