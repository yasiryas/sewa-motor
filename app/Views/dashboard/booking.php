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
                    <h1 class="h3 mb-0 text-gray-800">Booking</h1>
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-target="#addBookingModal" data-toggle="modal">
                        <i class="fas fa-plus fa-sm text-white-50"> </i> Booking Baru</a>
                </div>
                <div class="card shadow mb-4">

                    <div class="card-body">

                        <?php if (empty($bookings)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i> Belum ada data booking.
                                Silakan lakukan booking motor terlebih dahulu.
                            </div>
                        <?php else: ?>

                            <div class="table-responsive">
                                <table class="table table-bordered datatable" id="bookingTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama User</th>
                                            <th>Motor</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Total Harga</th>
                                            <th>Status</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($bookings as $booking): ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= esc($booking['username']); ?></td>
                                                <td><?= esc($booking['motor_name']); ?></td>
                                                <td><?= esc($booking['rental_start_date']); ?></td>
                                                <td><?= esc($booking['rental_end_date']); ?></td>
                                                <td>Rp <?= number_format($booking['total_price']); ?></td>
                                                <td>
                                                    <?php if ($booking['status'] == 'pending'): ?>
                                                        <span class="badge badge-warning">Pending</span>
                                                    <?php elseif ($booking['status'] == 'approved'): ?>
                                                        <span class="badge badge-success">Approved</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Canceled</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('dashboard/booking/view/' . $booking['id']); ?>" class="btn btn-sm
                                                       btn-info m-1" title="Lihat Detail"><i class="fas fa-folder-open"></i></a>
                                                    <a href="#" class="btn btn-sm btn-danger m-1"
                                                        data-delete-id-booking="<?= $booking['id']; ?>"
                                                        data-delete-user-booking="<?= esc($booking['username']); ?>"
                                                        data-delete-motor-booking="<?= esc($booking['motor_name']); ?>"
                                                        data-delete-start-date="<?= esc($booking['rental_start_date']); ?>"
                                                        data-delete-end-date="<?= esc($booking['rental_end_date']); ?>"
                                                        data-delete-total-price="<?= 'Rp ' . number_format($booking['total_price']); ?>"
                                                        data-delete-status="<?= esc(ucfirst($booking['status'])); ?>"
                                                        data-delete-toggle="modal" data-target="#deleteBookingAdminModal" title="Hapus Booking"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
            <!-- Modal area  -->
            <!-- Modal new booking -->
            <div class="modal fade" id="addBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Booking Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('dashboard/booking/adminStore'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <!-- <input type="hidden" name="id_user_booking" id="id_user_booking"> -->
                                <div class="form-group position-relative">
                                    <label for="search_user">Cari User</label>
                                    <div class="form-row">
                                        <div class="col w-100">
                                            <input type="text" name="search_user" id="search_user" class="form-control w-100 align-left" placeholder="Ketik username atau email..." value="<?= old('search_user') ?? ''; ?>">
                                            <!-- hidden untuk simpan id user -->
                                            <input type="hidden" id="user_id" name="user_id" value="<?= old('user_id') ?? ''; ?>">
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn btn-primary w-100" id="add_user" href="#" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-user-plus"></i> Add user</a>
                                        </div>
                                    </div>
                                    <!-- container hasil pencarian -->
                                    <div id="user_results" class="list-group position-absolute w-100 background-shadow"
                                        style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;">
                                    </div>
                                </div>
                                <!-- <div class="form-group"> -->
                                <!-- Slider Motor -->
                                <label>Pilih Motor</label>
                                <input type="hidden" name="motor_id" id="motor_id" value="<?= old('motor_id') ?? ''; ?>">
                                <div class="swiper mySwiper p-3">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($motors as $motor): ?>
                                            <div class="swiper-slide">
                                                <div class="select-motor card motor-card h-100 flex-column d-flex justify-content-between"
                                                    data-id-motor="<?= $motor['id']; ?>"
                                                    data-name="<?= esc($motor['name']); ?>"
                                                    data-price="<?= $motor['price_per_day']; ?>">
                                                    <img src="<?= base_url('uploads/motors/' . $motor['photo']); ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= esc($motor['name']); ?>">
                                                    <div class="card-body text-center mt-auto">
                                                        <h6 class="card-title"><b><?= esc($motor['name']); ?></b></h6>
                                                        <p class="">Rp. <?= number_format($motor['price_per_day'], 0, ',', '.'); ?><br>/hari</p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- Navigasi -->
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                                <!-- </div> -->
                                <div class="form-group">
                                    <label for="edit_rental_start_date">Tanggal Mulai</label>
                                    <input type="date" class="form-control date" id="rental_start_date" name="rental_start_date" required value="<?= old('rental_start_date') ?? ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="edit_rental_end_date">Tanggal Selesai</label>
                                    <input type="date" class="form-control date" id="rental_end_date" name="rental_end_date" required value="<?= old('rental_end_date') ?? ''; ?>">
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
            <!-- end modal ne booking  -->
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
                            <form action="<?= base_url('dashboard/booking/storeUser'); ?>" method="post">
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

            <!-- Modal Delete Booking -->
            <div class="modal fade" id="deleteBookingAdminModal" tabindex="-1" role="dialog" aria-labelledby="deleteBookingModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteBookingModalLabel">Apakah Anda yakin ingin menghapus booking ini?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= base_url('dashboard/booking/deleteAdmin'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="delete_booking_id">
                                <table>
                                    <tr>
                                        <td><strong>Nama User</strong></td>
                                        <td class="px-2">:</td>
                                        <td id="delete_booking_user"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Motor</strong></td>
                                        <td class="px-2">:</td>
                                        <td id="delete_booking_motor"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Mulai</strong></td>
                                        <td class="px-2">:</td>
                                        <td id="delete_booking_start_date"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Selesai</strong></td>
                                        <td class="px-2">:</td>
                                        <td id="delete_booking_end_date"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Harga</strong></td>
                                        <td class="px-2">:</td>
                                        <td id="delete_booking_total_price"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td class="px-2">:</td>
                                        <td id="delete_booking_status"></td>
                                    </tr>
                                </table>
                                <p>Note: Data booking yang dihapus tidak dapat dikembalikan.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- end modal delete booking -->
            <!-- Modal area end -->
        </div>
        <!-- End of Main Content -->

        <?= $this->include('dashboard/partials/footer'); ?>