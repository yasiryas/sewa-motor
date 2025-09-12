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
                    <h1 class="h3 mb-0 text-gray-800">List Brand</h1>
                    <button href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary btn-add-brand shadow-sm" data-target="#addBrandModal" data-toggle="modal"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Tambah Brand</button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <?php
                        if (empty($brands)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada brand. Silakan tambah brand terlebih dahulu.
                            </div>
                        <?php endif;
                        ?>
                        <table class="table table-bordered datatable" id="brandTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Brand</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($brands as $brand): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($brand['brand']); ?></td>
                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm btn-edit-brand-modal" data-id-update="<?= $brand['id']; ?>" data-brand-update="<?= $brand['brand']; ?>" data-toggle="modal"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete-brand-modal" data-id-delete="<?= $brand['id']; ?>" data-brand-delete="<?= $brand['brand']; ?>" data-target="#deleteBrandModal" data-toggle="modal"><i class="fas fa-trash"></i> Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal Add Brand -->
                <div class="modal fade" id="addBrandModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="brandFormAdd" action="<?= base_url('dashboard/inventaris/brand/store'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Brand</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="brand_id" name="id">
                                    <div class="form-group">
                                        <label for="name">Nama Brand</label>
                                        <input type="text" name="name" id="brand_name_add" class="form-control" value="<?= old('name') ?? ''; ?>" required>
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

                <!-- Modal Delete Brand -->
                <div class="modal fade" id="deleteBrandModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="brandFormDelete" action="<?= base_url('dashboard/inventaris/brand/delete'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Brand</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="brand_id_delete" name="id">
                                    <div class="form-group">
                                        <label for="name">Apakah anda yakin mau menghapus brand <strong id="brand_name_delete"></strong>?</label>
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

                <!-- Modal Edit Brand -->
                <div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="brandFormUpdate" action="<?= base_url('dashboard/inventaris/brand/update'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Brand</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Nama Brand</label>
                                        <input type="text" name="name" id="update_brand_name" class="form-control" value="<?= old('name') ?? ''; ?>" required>
                                        <input type="hidden" id="update_brand_id" name="id" value="<?= old('id') ?? ''; ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->



        <?= $this->include('dashboard/partials/footer'); ?>