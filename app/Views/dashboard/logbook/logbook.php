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
                        <button href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary btn-check-in shadow-sm" data-target="#addFaqModal" data-toggle="modal"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Check In</button>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-warning btn-check-out shadow-sm" data-target="#addFaqModal" data-toggle="modal"><i
                                class="fas fa-plus fa-sm text-white-50"></i>
                            Check Out
                        </button>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <!-- Filter -->
                        <form method="get" class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="type" class="form-control">
                                        <option value="">Semua Jenis</option>
                                        <option value="check-in" <?= request('type') == 'check-in' ? 'selected' : '' ?>>
                                            Check In
                                        </option>
                                        <option value="check-out" <?= request('type') == 'check-out' ? 'selected' : '' ?>>
                                            Check Out
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="date" name="start_date" class="form-control"
                                        value="<?= request()->getGet('start_date') ?>">
                                </div>

                                <div class="col-md-3">
                                    <input type="date" name="end_date" class="form-control"
                                        value="<?= request()->getGet('end_date') ?>">
                                </div>

                                <div class="col-md-3">
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
                                        <td><?= esc($log['motor']); ?></td>
                                        <td><?= esc($log['penyewa']); ?></td>
                                        <td> <span class="badge badge-<?= $log['type'] == 'check-in' ? 'success' : 'warning'; ?>">
                                                <?= esc($log['type']); ?>
                                            </span>
                                        </td>
                                        <td><?= esc(date("d M Y H:i", strtotime($log['created_at']))); ?></td>
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

                <!-- Modal Check In -->
                <div class="modal fade" id="addFaqModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="faqFormAdd" action="<?= base_url('dashboard/settings/faq/store'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah FAQ</h5>
                                    <button faq="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger">
                                            <?= session()->getFlashdata('error'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" id="faq_id" name="id">
                                    <div class="form-group">
                                        <label for="question">Pertanyaan</label>
                                        <input type="text" name="question" id="faq_question_add" class="form-control" value="<?= old('question') ?? ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="answer">Jawaban</label>
                                        <textarea name="answer" id="faq_answer_add" style="height: 100px;" class="form-control" required><?= old('answer') ?? ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-warning">Simpan</button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Delete faq -->
                <div class="modal fade" id="deleteFaqModal" tabindex="-1" role="dialog" aria-labelledby="deleteFaqModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="faqFormDelete" action="<?= base_url('dashboard/settings/faq/delete'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteFaqModalLabel">Hapus FAQ</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="faq_id_delete" name="id">
                                    <p>Apakah Anda yakin ingin menghapus FAQ <strong id="faq_delete"></strong> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit faq -->
                <div class="modal fade" id="editFaqModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="faqFormUpdate" action="<?= base_url('dashboard/settings/faq/update'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit FAQ</h5>
                                    <button faq="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger">
                                            <?= session()->getFlashdata('error'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" id="update_faq_id" name="id" value="<?= old('id') ?? ''; ?>">
                                    <div class="form-group">
                                        <label for="name">Pertanyaan</label>
                                        <input type="text" name="question" id="update_faq_question" class="form-control" value="<?= old('name') ?? ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Jawaban</label>
                                        <textarea type="text" style="height: 100px;" name="answer" id="update_faq_answer" class="form-control" required><?= old('answer') ?? ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button faq="submit" class="btn btn-sm btn-warning">Update</button>
                                    <button faq="button" class="btn btn-sm btn-outline-warning" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end modal -->
                </div>
                <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->



        <?= $this->include('dashboard/partials/footer'); ?>