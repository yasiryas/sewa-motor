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
                                            <button class="btn btn-sm btn-primary m-1 btn-detail-logbook" data-id="<?= $log['id'] ?>" data-toggle="modal" data-target="#detailLogbookModal"><i class="fas fa-search"></i> Detail</button>
                                            <button class="btn btn-sm btn-warning m-1 btn-edit-logbook" data-id="<?= $log['id'] ?>" data-toggle="modal" data-target="#editLogbookModal"><i class="fas fa-edit"></i> Edit</button>
                                            <button class="btn btn-sm btn-danger m-1 btn-delete-logbook" data-id="<?= $log['id'] ?>" data-toggle="modal" data-target="#deleteLogbookModal"><i class="fas fa-trash"></i> Delete</button>
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

            // Toast notification function - creates alert elements dynamically only when called
            function showToast(type, message) {
                // Remove any existing alerts
                $('.alert-dynamic').remove();

                // Create alert element
                let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                let alertHtml = `
                    <div class="alert ${alertClass} alert-dynamic alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                        <strong>${type === 'success' ? 'Sukses!' : 'Gagal!'}</strong> ${message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;

                $('body').append(alertHtml);

                // Auto remove after 3 seconds
                setTimeout(function() {
                    $('.alert-dynamic').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 3000);
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
            function setModalTitle(type) {
                $('.modal-title').text(
                    type === 'check-in' ?
                    'Check In Motor' :
                    'Check Out Motor'
                );

                $('#logType').val(type);
            }

            $('#logbookModal').on('show.bs.modal', function(event) {

                let button = $(event.relatedTarget);
                let typeFromButton = button?.data('type');

                if (typeFromButton) {
                    setModalTitle(typeFromButton);
                    $('#logType').val(typeFromButton);
                } else {
                    let oldType = $('#logType').val();
                    if (oldType) {
                        setModalTitle(oldType);
                    }
                }

                // Init Select2
                $('#motor-modal').select2({
                    dropdownParent: $('#logbookModal'),
                    theme: 'bootstrap4',
                    width: '100%'
                });

                $('#select-booking').select2({
                    dropdownParent: $('#logbookModal'),
                    theme: 'bootstrap4',
                    width: '100%'
                });
            });

            $('#select-booking').on('change', function() {
                let motorId = $(this).find(':selected').data('motor');

                if (motorId) {
                    $('#motor-modal')
                        .val(motorId)
                        .trigger('change')

                    $('#motor_id_hidden').val(motorId);
                    $('#motor-modal').prop('disabled', true);
                } else {
                    $('#motor-modal')
                        .val(null)
                        .trigger('change')
                        .prop('disabled', false);

                    $('#motor_id_hidden').val('');
                }
            });

            // Get CSRF token name and hash
            var csrfName = '<?= csrf_token() ?>';
            var csrfHash = '<?= csrf_hash() ?>';

            // Setup AJAX to always send CSRF token in headers
            $.ajaxSetup({
                headers: {
                    [csrfName]: csrfHash
                }
            });

            // AJAX form submission for Check In/Check Out
            $('#logbookForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#logbookModal').modal('hide');
                            showToast('success', response.message);
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        try {
                            let response = JSON.parse(xhr.responseText);
                            showToast('error', response.message || 'Terjadi kesalahan.');
                        } catch (e) {
                            showToast('error', 'Terjadi kesalahan saat menyimpan data.');
                        }
                    }
                });
            });

            //show modal edit logbook
            $('.btn-edit-logbook').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                $.ajax({
                    url: '<?= base_url('dashboard/logbook/show/') ?>' + '/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            $('#edit-logbook-id').val(data.id);
                            $('#edit-motor').val(data.motor_id).trigger('change');
                            $('#edit-type').val(data.type);
                            $('#edit-fuel').val(data.fuel_level);
                            $('#edit-notes').val(data.condition_note);

                            if (data.photo) {
                                $('#edit-photo-preview').attr('src', '<?= base_url('uploads/logbook/') ?>' + '/' + data.photo).show();
                            } else {
                                $('#edit-photo-preview').hide();
                            }
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function() {
                        showToast('error', 'Terjadi kesalahan saat mengambil data.');
                    }
                });
            });

            // Edit form submit
            $('#editLogbookForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editLogbookModal').modal('hide');
                            showToast('success', response.message || 'Logbook berhasil diperbarui.');
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showToast('error', response.message || 'Gagal memperbarui logbook.');
                        }
                    },
                    error: function() {
                        showToast('error', 'Terjadi kesalahan saat menyimpan data.');
                    }
                });
            });

            // Detail logbook
            $('.btn-detail-logbook').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                $.ajax({
                    url: '<?= base_url('dashboard/logbook/show/') ?>' + '/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            let photoUrl = data.photo ? '<?= base_url('uploads/logbook/') ?>/' + data.photo : '';

                            let html = `
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="35%">Kode</th>
                                        <td>${data.kode}</td>
                                    </tr>
                                    <tr>
                                        <th>Motor</th>
                                        <td>${data.motor_name} (${data.number_plate})</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis</th>
                                        <td><span class="badge badge-${data.type === 'check-in' ? 'success' : 'warning'}">${data.type}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Fuel Level</th>
                                        <td>${data.fuel_level}</td>
                                    </tr>
                                    <tr>
                                        <th>Petugas</th>
                                        <td>${data.petugas}</td>
                                    </tr>
                                    <tr>
                                        <th>Waktu</th>
                                        <td>${new Date(data.created_at).toLocaleString('id-ID')}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>${data.condition_note || '-'}</td>
                                    </tr>
                                    ${data.photo ? `
                                    <tr>
                                        <th>Foto</th>
                                        <td><img src="${photoUrl}" alt="Foto Motor" class="img-fluid" style="max-width: 200px;"></td>
                                    </tr>
                                    ` : ''}
                                </table>
                            `;
                            $('#detail-logbook-content').html(html);
                        } else {
                            $('#detail-logbook-content').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#detail-logbook-content').html('<div class="alert alert-danger">Terjadi kesalahan saat mengambil data.</div>');
                    }
                });
            });

            // Delete logbook
            $('.btn-delete-logbook').on('click', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let row = this;
                $('#delete-logbook-id').val(id);
                $('#deleteLogbookModal').data('row', row);
            });

            // Confirm delete
            $('#confirm-delete-logbook').on('click', function() {
                let id = $('#delete-logbook-id').val();
                let row = $('#deleteLogbookModal').data('row');

                $.ajax({
                    url: '<?= base_url('dashboard/logbook/delete') ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#deleteLogbookModal').modal('hide');
                            showToast('success', response.message || 'Logbook berhasil dihapus.');

                            // Remove row from table without reload
                            if (row) {
                                $(row).closest('tr').fadeOut('slow', function() {
                                    $(this).remove();
                                });
                            }
                        } else {
                            showToast('error', response.message);
                        }
                    },
                    error: function() {
                        showToast('error', 'Terjadi kesalahan saat menghapus data.');
                    }
                });
            });


        });
    </script>




    <?= $this->include('dashboard/partials/footer'); ?>