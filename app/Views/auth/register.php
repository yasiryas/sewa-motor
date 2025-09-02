<div class="container mx-auto max-w-lg mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

    <!-- tampilkan error atau success -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('register/process') ?>" method="POST" class="space-y-4">
        <?= csrf_field() ?>

        <div>
            <label for="username" class="block mb-1 font-semibold">Username</label>
            <input type="text" name="username" id="username" value="<?= old('username') ?>"
                class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200" required>
        </div>

        <div>
            <label for="email" class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" id="email" value="<?= old('email') ?>"
                class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200" required>
        </div>

        <div>
            <label for="password" class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" id="password"
                class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200" required>
        </div>

        <div>
            <label for="confirm_password" class="block mb-1 font-semibold">Konfirmasi Password</label>
            <input type="password" name="confirm_password" id="confirm_password"
                class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200" required>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-800 transition">
            Register
        </button>

        <p class="text-center text-sm mt-4">
            Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-indigo-600 hover:underline">Login di sini</a>
        </p>
    </form>
</div>