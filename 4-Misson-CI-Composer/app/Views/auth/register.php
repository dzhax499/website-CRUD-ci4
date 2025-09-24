<!-- App/Views/auth/register.php -->
<div class="register-container">
    <div class="register-form">
        <h3>Register Student Baru</h3>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= form_open('auth/store') ?>
        <div class="form-row">
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" name="nim" id="nim" value="<?= old('nim') ?>" required
                    placeholder="contoh: 2021001">
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?= old('username') ?>" required
                    placeholder="Username untuk login">
            </div>
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= old('nama_lengkap') ?>" required
                placeholder="Masukkan nama lengkap">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="jurusan">Jurusan:</label>
                <select name="jurusan" id="jurusan" required>
                    <option value="">Pilih Jurusan</option>
                    <option value="Teknik Informatika" <?= old('jurusan') == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                    <option value="Sistem Informasi" <?= old('jurusan') == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                    <option value="Teknik Komputer" <?= old('jurusan') == 'Teknik Komputer' ? 'selected' : '' ?>>Teknik Komputer</option>
                    <option value="Manajemen Informatika" <?= old('jurusan') == 'Manajemen Informatika' ? 'selected' : '' ?>>Manajemen Informatika</option>
                </select>
            </div>

            <div class="form-group">
                <label for="semester">Semester:</label>
                <select name="semester" id="semester" required>
                    <option value="">Pilih Semester</option>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i ?>" <?= old('semester') == $i ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= old('email') ?>" required
                placeholder="email@example.com">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required
                    placeholder="Minimal 6 karakter">
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    placeholder="Ulangi password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Daftar</button>
        <?= form_close() ?>

        <p class="login-link">
            Sudah punya akun? <a href="<?= base_url('auth/login') ?>">Login di sini</a>
        </p>
    </div>
</div>

<style>
    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 500px;
    }

    .register-form {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        min-width: 500px;
        max-width: 600px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .form-group select {
        background: white;
    }

    .btn {
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
    }

    .btn:hover {
        background: #0056b3;
    }

    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .login-link {
        text-align: center;
        margin-top: 15px;
    }

    @media (max-width: 600px) {
        .register-form {
            min-width: 90vw;
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>