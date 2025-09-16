<!-- App/Views/auth/login.php -->
<div class="login-container">
    <div class="login-form">
        <h3>Login Sistem Akademik</h3>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/authenticate') ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?= old('username') ?>" required>
                <?php if (isset($errors['username'])): ?>
                    <span class="error"><?= $errors['username'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <?php if (isset($errors['password'])): ?>
                    <span class="error"><?= $errors['password'] ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form> 

        <p class="register-link">
            Belum punya akun? <a href="<?= base_url('auth/register') ?>">Daftar di sini</a>
        </p>
    </div>
</div>

<style>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
    }

    .login-form {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        min-width: 350px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .btn {
        background: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
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

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .error {
        color: #dc3545;
        font-size: 12px;
    }

    .register-link {
        text-align: center;
        margin-top: 15px;
    }
</style>