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
                                    <h1 class="h4 text-gray-900 mb-4">Hello, Welcome Back</h1>
                                </div>
                                <?php if (session()->getFlashdata('error')) : ?>
                                    <!-- <div class="alert alert-danger" role="alert"> -->
                                    <div class="justify-content-center text-center p-2" style="color:red;">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata('success')) : ?>
                                    <div class="justify-content-center text-center p-2" style="color:green;">
                                        <?= session()->getFlashdata('success') ?>
                                    </div>
                                <?php endif; ?>
                                <form class="user" action="<?= base_url('login/process'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Enter Email Address..." name="email">
                                    </div>
                                    <div class="form-group position-relative">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password">
                                        <span class="toggle-password position-absolute"
                                            style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    <!-- <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password">
                                    </div> -->
                                    <!-- <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember
                                                Me</label>
                                        </div>
                                    </div> -->
                                    <button type="submit" class="btn btn-orange fs-4 btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="text-orange" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="text-orange" href="<?= base_url('register'); ?>">Create an Account!</a>
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
    document.addEventListener("DOMContentLoaded", function() {
        const toggle = document.querySelector(".toggle-password");

        toggle.addEventListener("click", function() {
            const input = document.querySelector("#exampleInputPassword");
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    });
</script>

<?= $this->include('auth/partials/footer'); ?>