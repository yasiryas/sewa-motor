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
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
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
                                        <th>Tanggal Dibuat</th>
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
                                            <td><?= esc($user['created_at']); ?></td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="#" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- DataTables -->

                <!-- Content Row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <?= $this->include('dashboard/partials/footer'); ?>