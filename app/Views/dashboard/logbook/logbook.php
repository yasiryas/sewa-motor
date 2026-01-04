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
                    <h1 class="h3 mb-0 text-gray-800"><?= $title . ' ' . $submenu_title; ?></h1>
                    <button href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary btn-add-faq shadow-sm" data-target="#addFaqModal" data-toggle="modal"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Check In</button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <?php
                        if (empty($checkIn)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada Record. Silakan tambah record terlebih dahulu.
                            </div>
                        <?php endif;
                        ?>
                        <table class="table table-bordered datatable" id="checkInTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($checkIn as $ci): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($ci['question']); ?></td>
                                        <td><?= esc($ci['answer']); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm btn-edit-faq-modal m-1"
                                                data-update-id-faq="<?= $ci['id']; ?>"
                                                data-update-question-faq="<?= esc($ci['question']); ?>"
                                                data-update-answer-faq="<?= esc($ci['answer']); ?>"><i class="fas fa-edit"></i> Edit</a>
                                            <ca href="#" class="btn btn-danger btn-sm btn-delete-faq-modal m-1" data-delete-id-faq="<?= $ci['id']; ?>" data-delete-question-faq="<?= $ci['question']; ?>" data-target="#deleteFaqModal" data-toggle="modal"><i class="fas fa-trash"></i> Hapus</ca>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- modal section -->
                <!-- Modal Add faq -->
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