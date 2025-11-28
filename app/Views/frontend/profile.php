<?= $this->include('frontend/partials/header'); ?>
<!-- Navbar -->
<?= $this->include('frontend/partials/navbar'); ?>
<section id="produk" class="py-5" style="height: 40vh;
        background:linear-gradient(0deg, rgba(255, 255, 255, 0.85),
        rgba(255, 255, 255, 0.85)),
        url('<?= base_url('img/asset/bg-faq.jpg'); ?>')
        center/cover no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;">
    <div class="container">
        <h2 class="text-center m-5 font-weight-bold text-dark"><?= $title; ?></h2>
    </div>
</section>
<section id="profile" class="py-5">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Personal Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('profile/update'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= esc($user['username']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= esc($user['full_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone">Nomor Telepon</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= esc($user['phone']); ?>" required>
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
                        <form action="<?= base_url('profile/change-password'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="password">Password Lama</label>
                                <input type="password" class="form-control" id="password" name="current_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_password">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password">
                            </div>
                            <button type="submit" class="btn btn-warning text-white">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 pt-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Last Activity</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($activities as $activity) : ?>
                                        <tr>
                                            <td><?= date('d F Y', strtotime($activity['created_at'])); ?> </td>
                                            <td>Booking Motor <?= $activity['brand_name']; ?> <?= $activity['motor_name'] ?> (<?= $activity['number_plate']; ?>) Selama <?= date('d F Y', strtotime($activity['rental_start_date'])); ?> - <?= date('d F Y', strtotime($activity['rental_end_date'])); ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?= $this->include('frontend/partials/footer'); ?>