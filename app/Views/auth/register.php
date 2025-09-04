<?= $this->include('auth/partials/header'); ?>
<div class="container">

    <!-- Outer Row -->
    <div class=" row justify-content-center align-item-center pt-5">

        <div class=" col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background-image: url('<?= base_url(); ?>dashboard/img/bg-login.jpg');"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Daftar & Dapatkan Akses</h1>
                                </div>
                                <?php if (session()->getFlashdata('error')): ?>
                                    <p style="color:red;"><?= session()->getFlashdata('error'); ?></p>
                                <?php endif; ?>
                                <form class="user" action="<?= base_url('register/process') ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user"
                                            id="username" aria-describedby="username"
                                            placeholder="Enter username" name="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address..." name="email">
                                    </div>
                                    <div class="form-group position-relative">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password">

                                        <!-- Tombol toggle password -->
                                        <span onclick="togglePassword('exampleInputPassword','toggleIcon1')"
                                            class="position-absolute"
                                            style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;">
                                            <i class="fas fa-eye" id="toggleIcon1"></i>
                                        </span>
                                    </div>

                                    <div class="form-group position-relative">
                                        <input type="password" class="form-control form-control-user"
                                            id="confirm_password" placeholder="Confirm Password" name="confirm_password">

                                        <!-- Tombol toggle confirm password -->
                                        <span onclick="togglePassword('confirm_password','toggleIcon2')"
                                            class="position-absolute"
                                            style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;">
                                            <i class="fas fa-eye" id="toggleIcon2"></i>
                                        </span>
                                    </div>
                                    <!-- <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password" id="password">

                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="confirm_password" placeholder="Confirm Password" name="confirm_password">
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div> -->
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Sign Up
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('login'); ?>">Already have an account? Login!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('forgot-password'); ?>">Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>

<?= $this->include('auth/partials/footer'); ?>