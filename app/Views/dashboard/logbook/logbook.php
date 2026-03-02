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

                        <div id="empty-record-alert" class="alert alert-info text-center" style="display: <?= empty($logs) ? 'block' : 'none' ?>;">
                            <i class="fas fa-info-circle"></i> Belum ada Record. Silakan tambah record terlebih dahulu.
                        </div>
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

            // Get CSRF token name and hash
            var csrfName = '<?= csrf_token() ?>';
            var csrfHash = '<?= csrf_hash() ?>';

            // Function to refresh CSRF token
            function refreshCsrfToken() {
                csrfHash = $('input[name="' + csrfName + '"]').val();
            }

            // Setup AJAX to always send CSRF token in headers
            var csrfHeaders = {};
            csrfHeaders[csrfName] = csrfHash;
            $.ajaxSetup({
                headers: csrfHeaders
            });

            // Refresh CSRF token before each AJAX request
            $(document).ajaxSend(function(event, xhr, settings) {
                refreshCsrfToken();
                csrfHeaders[csrfName] = csrfHash;
            });

            /* =============================
               LOAD LOGBOOK DATA (AJAX)
            ============================== */
            function loadLogbookData() {
                // Get current filter values
                let type = $('select[name="type"]').val();
                let startDate = $('input[name="start_date"]').val();
                let endDate = $('input[name="end_date"]').val();
                let motorId = $('select[name="motor"]').val();
                var csrf = getCsrfToken();

                $.ajax({
                    url: '<?= base_url('dashboard/logbook/loadData') ?>',
                    type: 'GET',
                    data: {
                        type: type,
                        start_date: startDate,
                        end_date: endDate,
                        motor: motorId,
                        [csrf.name]: csrf.hash
                    },
                    success: function(response) {
                        if (response.success) {
                            // Rebuild table with new data
                            let tbody = $('#checkInTable tbody');
                            tbody.empty();

                            if (response.data.length === 0) {
                                tbody.html(`
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-info mb-0">
                                                <i class="fas fa-info-circle"></i> Belum ada Record. Silakan tambah record terlebih dahulu.
                                            </div>
                                        </td>
                                    </tr>
                                `);
                                $('#empty-record-alert').show();
                            } else {
                                $('#empty-record-alert').hide();
                                response.data.forEach(function(log, index) {
                                    let rowNum = index + 1;
                                    let badgeClass = log.type === 'check-in' ? 'success' : 'warning';
                                    let typeLabel = log.type === 'check-in' ? 'Check In' : 'Check Out';
                                    let formattedDate = new Date(log.created_at).toLocaleString('id-ID');

                                    let row = `
                                        <tr>
                                            <td>${rowNum}</td>
                                            <td>${log.kode}</td>
                                            <td>${log.motor} <br> ${log.number_plate}</td>
                                            <td>${log.penyewa || '-'}</td>
                                            <td><span class="badge badge-${badgeClass}">${typeLabel}</span></td>
                                            <td>${formattedDate}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary m-1 btn-detail-logbook" data-id="${log.id}" data-toggle="modal" data-target="#detailLogbookModal"><i class="fas fa-search"></i> Detail</button>
                                                <button class="btn btn-sm btn-warning m-1 btn-edit-logbook" data-id="${log.id}" data-toggle="modal" data-target="#editLogbookModal"><i class="fas fa-edit"></i> Edit</button>
                                                <button class="btn btn-sm btn-danger m-1 btn-delete-logbook" data-id="${log.id}" data-toggle="modal" data-target="#deleteLogbookModal"><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                    `;
                                    tbody.append(row);
                                });
                            }

                            // Re-attach event handlers to new buttons
                            attachButtonHandlers();
                        }
                    },
                    error: function() {
                        showToast('error', 'Gagal memuat data logbook.');
                    }
                });
            }

            // Function to attach button handlers (for dynamically loaded content)
            function attachButtonHandlers() {
                // Detail button
                $('.btn-detail-logbook').off('click').on('click', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    var csrf = getCsrfToken();

                    $.ajax({
                        url: '<?= base_url('dashboard/logbook/show/') ?>' + '/' + id,
                        type: 'GET',
                        data: csrf,
                        success: function(response) {
                            if (response.success) {
                                let data = response.data;
                                let photoUrl = data.photo ? '<?= base_url('uploads/logbook/') ?>/' + data.photo : '';

                                function getFuelLevelDisplay(fuel) {
                                    const fuelMap = {
                                        'full': 'Full (Penuh)',
                                        'medium': 'Medium (Sedang)',
                                        'low': 'Low (Rendah)'
                                    };
                                    return fuelMap[fuel] || fuel;
                                }

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
                                            <td><span class="badge badge-${data.type === 'check-in' ? 'success' : 'warning'}">${data.type === 'check-in' ? 'Check In' : 'Check Out'}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Fuel Level</th>
                                            <td>${getFuelLevelDisplay(data.fuel_level)}</td>
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

                // Edit button
                $('.btn-edit-logbook').off('click').on('click', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    var csrf = getCsrfToken();

                    $.ajax({
                        url: '<?= base_url('dashboard/logbook/show/') ?>' + '/' + id,
                        type: 'GET',
                        data: csrf,
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

                // Delete button
                $('.btn-delete-logbook').off('click').on('click', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let row = this;
                    $('#delete-logbook-id').val(id);
                    $('#deleteLogbookModal').data('row', row);
                });
            }

            // Toast notification function
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
                placeholder: "Ketik untuk mencari motor...",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Motor tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            $('#select-booking').select2({
                dropdownParent: $('#logbookModal'),
                theme: 'bootstrap4',
                placeholder: "Ketik untuk mencari booking...",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Booking tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            $('#motor-filter').select2({
                theme: 'bootstrap4',
                placeholder: "Ketik untuk mencari motor...",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Motor tidak ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
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

            /* =============================
               RESET MODAL ON CLOSE
            ============================== */
            // Reset Check In/Check Out modal
            $('#logbookModal').on('hidden.bs.modal', function() {
                $('#logbookForm')[0].reset();
                $('#motor-modal').val(null).trigger('change').prop('disabled', false);
                $('#select-booking').val(null).trigger('change');
                $('#motor_id_hidden').val('');
                $('#logType').val('');
                $('.photo-preview').hide().attr('src', '#');
                $('.modal-title').text('Logbook Motor');
            });

            // Reset Edit modal
            $('#editLogbookModal').on('hidden.bs.modal', function() {
                $('#editLogbookForm')[0].reset();
                $('#edit-logbook-id').val('');
                $('#edit-motor').val(null).trigger('change');
                $('#edit-type').val('');
                $('#edit-fuel').val('');
                $('#edit-notes').val('');
                $('#edit-photo-preview').hide().attr('src', '#');
            });

            // Reset Delete modal
            $('#deleteLogbookModal').on('hidden.bs.modal', function() {
                $('#delete-logbook-id').val('');
                $('#deleteLogbookModal').removeData('row');
            });

            // Reset Detail modal
            $('#detailLogbookModal').on('hidden.bs.modal', function() {
                $('#detail-logbook-content').html('<p>Loading...</p>');
            });

            // Get CSRF token name and hash from the hidden input in the form
            function getCsrfToken() {
                var csrfInput = $('input[name="<?= csrf_token() ?>"]');
                return {
                    name: csrfInput.attr('name') || '<?= csrf_token() ?>',
                    hash: csrfInput.val()
                };
            }

            // AJAX form submission for Check In/Check Out
            $('#logbookForm').on('submit', function(e) {
                e.preventDefault();

                // Get fresh CSRF token from the form's hidden input
                var csrf = getCsrfToken();

                // Debug: Check what data is being sent
                let formData = new FormData(this);

                // Ensure type is set
                let typeValue = $('#logType').val();
                if (!typeValue) {
                    showToast('error', 'Jenis (Check In/Check Out) belum dipilih.');
                    return;
                }

                // Ensure motor is selected
                let motorValue = $('#motor-modal').val();
                if (!motorValue) {
                    showToast('error', 'Motor belum dipilih.');
                    return;
                }

                // Ensure fuel is selected
                let fuelValue = $('#fuel').val();
                if (!fuelValue) {
                    showToast('error', 'Fuel Level belum dipilih.');
                    return;
                }

                // Add fresh CSRF token to form data
                formData.append(csrf.name, csrf.hash);

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

                            // Reset form
                            $('#logbookForm')[0].reset();
                            $('#motor-modal').val(null).trigger('change');
                            $('#select-booking').val(null).trigger('change');
                            $('#motor_id_hidden').val('');
                            $('#logType').val('');
                            $('.photo-preview').hide().attr('src', '#');

                            // Reload table data via AJAX instead of page reload
                            loadLogbookData();
                        } else {
                            showToast('error', response.message || 'Gagal menyimpan data.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error response:', xhr.responseText);

                        // Check if response is HTML (CSRF error or other server error)
                        if (xhr.getResponseHeader('content-type') && xhr.getResponseHeader('content-type').indexOf('application/json') === -1) {
                            // It's HTML, likely a CSRF error
                            showToast('error', 'Token keamanan expired. Halaman akan dimuat ulang.');
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                            return;
                        }

                        try {
                            let response = JSON.parse(xhr.responseText);
                            // Tampilkan pesan error dari server
                            if (response.errors) {
                                // Jika ada validasi errors
                                var errorMessages = [];
                                for (var key in response.errors) {
                                    errorMessages.push(response.errors[key]);
                                }
                                showToast('error', errorMessages.join(', '));
                            } else if (response.message) {
                                showToast('error', response.message);
                            } else {
                                showToast('error', 'Terjadi kesalahan: ' + error);
                            }
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
                var csrf = getCsrfToken();

                $.ajax({
                    url: '<?= base_url('dashboard/logbook/show/') ?>' + '/' + id,
                    type: 'GET',
                    data: csrf,
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

                var csrf = getCsrfToken();
                let formData = new FormData(this);
                formData.append(csrf.name, csrf.hash);

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

                            // Reload table data via AJAX
                            loadLogbookData();
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
                var csrf = getCsrfToken();

                $.ajax({
                    url: '<?= base_url('dashboard/logbook/show/') ?>' + '/' + id,
                    type: 'GET',
                    data: csrf,
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            let photoUrl = data.photo ? '<?= base_url('uploads/logbook/') ?>/' + data.photo : '';

                            // Function to get formatted fuel level
                            function getFuelLevelDisplay(fuel) {
                                const fuelMap = {
                                    'full': 'Full (Penuh)',
                                    'medium': 'Medium (Sedang)',
                                    'low': 'Low (Rendah)'
                                };
                                return fuelMap[fuel] || fuel;
                            }

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
                                        <td>${getFuelLevelDisplay(data.fuel_level)}</td>
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
                var csrf = getCsrfToken();

                var postData = {};
                postData[csrf.name] = csrf.hash;
                postData.id = id;

                $.ajax({
                    url: '<?= base_url('dashboard/logbook/delete') ?>',
                    type: 'POST',
                    data: postData,
                    success: function(response) {
                        if (response.success) {
                            $('#deleteLogbookModal').modal('hide');
                            showToast('success', response.message || 'Logbook berhasil dihapus.');

                            // Remove row from table without reload
                            if (row) {
                                $(row).closest('tr').fadeOut('slow', function() {
                                    $(this).remove();

                                    // Check if there are remaining rows
                                    setTimeout(function() {
                                        let remainingRows = $('#checkInTable tbody tr').length;
                                        if (remainingRows === 0) {
                                            $('#empty-record-alert').show();
                                        }
                                    }, 500);
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