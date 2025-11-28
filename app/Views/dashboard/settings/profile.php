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
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">Personal Information</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('dashboard/settings/profile/update'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" value="<?= old('full_name', esc($user['full_name'])); ?>" required>
                                        <?= isset(session('errors')['full_name']) ? '<span class="text-danger">' . session('errors')['full_name'] . '</span>' : '' ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']); ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone', esc($user['phone'])); ?>" required>
                                        <?= isset(session('errors')['phone']) ? '<span class="text-danger">' . session('errors')['phone'] . '</span>' : '' ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary text-white">Perbarui Profil</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-white">
                                <h4 class="mb-0">Reset Password</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('dashboard/settings/profile/update-password'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="password">Password Lama</label>
                                        <input type="password" class="form-control" id="password" name="current_password">
                                        <?= isset(session('errors')['current_password']) ? '<span class="text-danger">' . session('errors')['current_password'] . '</span>' : '' ?>
                                        <?= session()->getFlashdata('error_current_password') ? '<div class="text-danger">' . session()->getFlashdata('error_current_password') . '</div>' : '' ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="new_password" name="new_password">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#new_password">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <?= isset(session('errors')['new_password']) ? '<span class="text-danger">' . session('errors')['new_password'] . '</span>' : '' ?>
                                        <?= session()->getFlashdata('error_new_password') ? '<div class="text-danger">' . session()->getFlashdata('error_new_password') . '</div>' : '' ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_new_password">Konfirmasi Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#confirm_new_password">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                            <?= isset(session('errors')['confirm_new_password']) ? '<span class="text-danger">' . session('errors')['confirm_new_password'] . '</span>' : '' ?>
                                            <?= session()->getFlashdata('error_confirm_new_password') ? '<div class="text-danger">' . session()->getFlashdata('error_confirm_new_password') . '</div>' : '' ?>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-warning text-white">Reset Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->



        <?= $this->include('dashboard/partials/footer'); ?>