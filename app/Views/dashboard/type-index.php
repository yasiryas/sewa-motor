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
                    <h1 class="h3 mb-0 text-gray-800">List Type</h1>
                    <button href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary btn-add-type shadow-sm" data-target="#addTypeModal" data-toggle="modal"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Tambah Type</button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <?php
                        if (empty($types)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada type. Silakan tambah type terlebih dahulu.
                            </div>
                        <?php endif;
                        ?>
                        <table class="table table-bordered datatable" id="typeTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama type</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($types as $type): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($type['type']); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm btn-edit-type-modal" data-id-update="<?= $type['id']; ?>" data-type-update="<?= $type['type']; ?>" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete-type-modal" data-id-delete="<?= $type['id']; ?>" data-type-delete="<?= $type['type']; ?>" data-target="#deleteTypeModal" data-toggle="modal"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- modal section -->
                <!-- Modal Add type -->
                <div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="typeFormAdd" action="<?= base_url('dashboard/inventaris/type/store'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Type</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="type_id" name="id">
                                    <div class="form-group">
                                        <label for="name">Nama Type</label>
                                        <input type="text" name="name" id="type_name_add" class="form-control" value="<?= old('name') ?? ''; ?>" required>
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

                <!-- Modal Delete type -->
                <div class="modal fade" id="deleteTypeModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="typeFormDelete" action="<?= base_url('dashboard/inventaris/type/delete'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus type</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="type_id_delete" name="id">
                                    <div class="form-group">
                                        <label for="name">Apakah anda yakin mau menghapus type <strong id="type_name_delete"></strong>?</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit type -->
                <div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="typeFormUpdate" action="<?= base_url('dashboard/inventaris/type/update'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit type</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Nama type</label>
                                        <input type="text" name="name" id="update_type_name" class="form-control" value="<?= old('name') ?? ''; ?>" required>
                                        <input type="hidden" id="update_type_id" name="id" value="<?= old('id') ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" data-dismiss="modal">Batal</button>
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