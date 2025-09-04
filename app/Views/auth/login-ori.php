<h2>Login</h2>
<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red;"><?= session()->getFlashdata('error'); ?></p>
<?php endif; ?>
<form action="<?= base_url('login/process'); ?>" method="post">
    <label>Email</label><br>
    <input type="email" name="email"><br>
    <label>Password</label><br>
    <input type="password" name="password"><br><br>
    <button type="submit">Login</button>
</form>
<a href="<?= base_url('register'); ?>">Daftar</a>