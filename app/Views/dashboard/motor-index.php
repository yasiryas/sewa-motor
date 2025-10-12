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
                    <h1 class="h3 mb-0 text-gray-800">List Motor</h1>
                    <button href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary btn-add-motor shadow-sm" data-target="#addMotorModal" data-toggle="modal"><i
                            class="fas fa-plus fa-sm text-white-50"></i> Tambah Motor</button>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <?php
                        if (empty($motors)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada motor. Silakan tambah motor terlebih dahulu.
                            </div>
                        <?php endif;
                        ?>
                        <table class="table table-bordered datatable" id="motorTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Nama motor</th>
                                    <th>No Plat</th>
                                    <th>Tipe</th>
                                    <th>Price Per Day</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($motors as $motor): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><img class="img-fulid" style="max-width: 100px; height: auto" src="<?= base_url('uploads/motors/' . $motor->photo); ?>" alt=""></td>
                                        <td><?= $motor->brand . ' ' . $motor->name; ?></td>
                                        <td><?= $motor->number_plate; ?></td>
                                        <td><?= $motor->type; ?></td>
                                        <td><?= 'Rp. ' . number_format($motor->price_per_day, 0, ',', '.'); ?></td>
                                        <td><?= $motor->availability_status; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-warning btn-sm btn-edit-motor-modal mb-2"
                                                data-id-update-motor="<?= $motor->id; ?>"
                                                data-update-name-motor="<?= $motor->name; ?>"
                                                data-update-plate-motor="<?= $motor->number_plate; ?>"
                                                data-update-id-brand-motor="<?= $motor->id_brand; ?>"
                                                data-update-id-type-motor="<?= $motor->id_type; ?>"
                                                data-update-price-motor="<?= $motor->price_per_day; ?>"
                                                data-update-status-motor="<?= $motor->availability_status; ?>"
                                                data-update-photo-motor="<?= $motor->photo; ?>"
                                                data-toggle="modal">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <a href="#" class="btn btn-danger btn-sm btn-delete-motor-modal mb-2"
                                                data-id-delete-motor="<?= $motor->id; ?>"
                                                data-motor-delete="<?= $motor->brand . ' ' . $motor->name; ?>"
                                                data-target="#deleteMotorModal"
                                                data-toggle="modal">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- modal section -->
                <!-- Modal Add motor -->
                <div class="modal fade" id="addMotorModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="motorFormAdd" action="<?= base_url('dashboard/inventaris/motor/store'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Motor</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger">
                                            <?= session()->getFlashdata('error'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- <input type="hidden" id="motor_id" name="id"> -->
                                    <!-- Nama motor -->
                                    <div class="form-group">
                                        <label for="motor_name_add">Nama Motor</label>
                                        <input type="text" name="name" id="motor_name_add" class="form-control" value="<?= old('name') ?? ''; ?>" required>
                                    </div>
                                    <!-- No Plat -->
                                    <div class="form-group">
                                        <label for="number_plate">No Plat</label>
                                        <input type="text" name="number_plate" id="number_plate" class="form-control" value="<?= old('number_plate') ?? ''; ?>" required>
                                    </div>
                                    <!-- Brand -->
                                    <div class="form-group">
                                        <label for="id_brand">Brand</label>
                                        <select name="id_brand" id="id_brand" class="form-control" required>
                                            <option value="">-- Pilih Brand --</option>
                                            <?php foreach ($brands as $b): ?>
                                                <option value="<?= $b->id; ?>" <?= old('id_brand') == $b->id ? 'selected' : ''; ?>>
                                                    <?= $b->brand; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Type -->
                                    <div class="form-group">
                                        <label for="id_type">Type</label>
                                        <select name="id_type" id="id_type" class="form-control" required>
                                            <option value="">-- Pilih Type --</option>
                                            <?php foreach ($types as $t): ?>
                                                <option value="<?= $t->id; ?>" <?= old('id_type') == $t->id ? 'selected' : ''; ?>>
                                                    <?= esc($t->type); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Harga per hari -->
                                    <div class="form-group">
                                        <label for="price_per_day">Harga per Hari</label>
                                        <input type="number" name="price_per_day" id="price_per_day" class="form-control format-number" value="<?= old('price_per_day') ?? ''; ?>" required>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="availability_status">Status</label>
                                        <select name="availability_status" id="availability_status" class="form-control">
                                            <option value="available" <?= old('availability_status') == 'available' ? 'selected' : ''; ?>>Tersedia</option>
                                            <option value="unavailable" <?= old('availability_status') == 'unavailable' ? 'selected' : ''; ?>>Tidak Tersedia</option>
                                            <option value="maintenance" <?= old('availability_status') == 'maintenance' ? 'selected' : ''; ?>>Dalam Perawatan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Foto</label>
                                        <input type="file" class="photo-input form-control-file" accept="image/*" name="photo">
                                        <img src="#" alt="Preview Gambar" class="photo-preview img-fluid mt-2" style="max-width:200px; display:none;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-warning">Simpan</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Delete motor -->
                <div class="modal fade" id="deleteMotorModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="motorFormDelete" action="<?= base_url('dashboard/inventaris/motor/delete'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus motor</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="motor_id_delete" name="id">
                                    <div class="form-group">
                                        <label for="name">Apakah anda yakin mau menghapus motor <strong id="motor_name_delete"></strong>?</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button motor="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    <button motor="button" class="btn btn-sm btn-outline-danger" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Update Motor -->
                <div class="modal fade" id="editMotorModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <form id="motorFormUpdate" action="<?= base_url('dashboard/inventaris/motor/update'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update Motor</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger">
                                            <?= session()->getFlashdata('error'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <input type="hidden" id="update_id_motor" name="update_id_motor" value="<?= old('update_id_motor') ?? ''; ?>">
                                    <!-- Nama motor -->
                                    <div class="form-group">
                                        <label for="motor_name_update">Nama Motor</label>
                                        <input type="text" name="update_name_motor" id="update_name_motor" class="form-control" value="<?= old('update_name_motor') ?? ''; ?>" required>
                                    </div>
                                    <!-- No Plat -->
                                    <div class="form-group">
                                        <label for="number_plate_update">No Plat</label>
                                        <input type="text" name="update_plate_motor" id="update_plate_motor" class="form-control" value="<?= old('update_plate_motor') ?? ''; ?>" required>
                                    </div>
                                    <!-- Brand -->
                                    <div class="form-group">
                                        <label for="id_brand_update">Brand</label>
                                        <select name="update_id_brand" id="update_brand_motor" class="form-control" required>
                                            <option value="">-- Pilih Brand --</option>
                                            <?php foreach ($brands as $b): ?>
                                                <option value="<?= $b->id; ?>" <?= old('update_id_brand') == $b->id  ? 'selected' : ''; ?>>
                                                    <?= $b->brand; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Type -->
                                    <div class="form-group">
                                        <label for="id_type">Type</label>
                                        <select name="id_type_update" id="update_type_motor" class="form-control" required>
                                            <option value="">-- Pilih Type --</option>
                                            <?php foreach ($types as $t): ?>
                                                <option value="<?= $t->id; ?>" <?= old('id_type_update') == $t->id ? 'selected' : ''; ?>>
                                                    <?= esc($t->type); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Harga per hari -->
                                    <div class="form-group">
                                        <label for="price_per_day">Harga per Hari</label>
                                        <input type="number" name="price_per_day_update" id="update_price_motor" class="form-control" value="<?= old('price_per_day_update') ?? ''; ?>" required>
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group">
                                        <label for="availability_status">Status</label>
                                        <select name="availability_status_update" id="update_status_motor" class="form-control">
                                            <option value="available" <?= old('availability_status_update') == 'available' ? 'selected' : ''; ?>>Tersedia</option>
                                            <option value="rented" <?= old('availability_status_update') == 'rented' ? 'selected' : ''; ?>>Disewa</option>
                                            <option value="maintenance" <?= old('availability_status_update') == 'maintenance' ? 'selected' : ''; ?>>Dalam Perawatan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Foto</label>
                                        <input type="file" class="photo-input form-control-file" accept="image/*" name="photo_update">
                                        <img src="#" alt="Preview Gambar" class="photo-preview img-fluid mt-2" style="max-width:200px; display:none;">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-warning">Simpan</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Batal</button>
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