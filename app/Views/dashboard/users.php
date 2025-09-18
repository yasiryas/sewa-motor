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

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">List Penyewa</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-toggle="modal" data-target="#addUserModal"><i
                            class="fas fa-users fa-sm text-white-50"></i> Tambah User</a>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <?php if (empty($users)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada user dengan role <strong>user</strong>.
                            </div>
                        <?php else: ?>
                            <table class="table table-bordered datatable" id="userTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Bergabung Sejak</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= esc($user['username']); ?></td>
                                            <td><?= esc($user['email']); ?></td>
                                            <td><?= esc(date("d M Y", strtotime($user['created_at']))); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning btn-edit-user-modal"
                                                    data-id-edit-user="<?= $user['id']; ?>">
                                                    <i class="fas fa-edit"></i> Edit</a>
                                                <a href="#" class="btn btn-sm btn-danger btn-delete-user-modal"
                                                    data-delete-id-user="<?= $user['id']; ?>"
                                                    data-delete-name-user="<?= $user['username']; ?>"
                                                    data-toggle="modal" data-target="#deleteUserModal">
                                                    <i class="fas fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Modal Add User -->
                <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger pt-2">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                                <form action="<?= base_url('dashboard/user/store'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required value="<?= old('username') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" required value="<?= old('full_name') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required value="<?= old('email') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">No Telepon</label>
                                        <input type="number" class="form-control" id="phone" name="phone" required value="<?= old('phone') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" required value="<?= old('password') ?? ''; ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="repeat_password">Ulangi Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="repeat_password" name="repeat_password" required value="<?= old('repeat_password') ?? ''; ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#repeat_password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Peran</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="user" <?= old('role') == 'user' ? 'selected' : ''; ?>>User</option>
                                            <option value="admin" <?= old('role') == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            <option value="owner" <?= old('role') == 'owner' ? 'selected' : ''; ?>>Owner</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal Add User -->
                <!-- modal delete user -->
                <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteUserModalLabel">Hapus User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('dashboard/user/delete'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <div class="modal-body">
                                    <input type="hidden" name="user_id_delete" id="user_id_delete" value="<?= old('user_id_delete'); ?>">
                                    <p>Apakah Anda yakin ingin menghapus user <strong id="user_name_delete"></strong>?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End modal delete user -->
                <!-- Modal edit user -->
                <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php if (session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger pt-2">
                                        <?= session()->getFlashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                                <form action="<?= base_url('dashboard/user/store'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required value="<?= old('username') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" required value="<?= old('full_name') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required value="<?= old('email') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">No Telepon</label>
                                        <input type="number" class="form-control" id="phone" name="phone" required value="<?= old('phone') ?? ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" required value="<?= old('password') ?? ''; ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="repeat_password">Ulangi Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="repeat_password" name="repeat_password" required value="<?= old('repeat_password') ?? ''; ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#repeat_password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Peran</label>
                                        <select class="form-control" id="role" name="role" required>
                                            <option value="user" <?= old('role') == 'user' ? 'selected' : ''; ?>>User</option>
                                            <option value="admin" <?= old('role') == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            <option value="owner" <?= old('role') == 'owner' ? 'selected' : ''; ?>>Owner</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End modal edit user -->
                <!-- DataTables -->

                <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <?= $this->include('dashboard/partials/footer'); ?>