<!-- App/Views/auth/login_bootstrap.php - Contoh Login Form dengan Bootstrap -->
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Left Side - Welcome Message -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="text-center text-white">
                <div class="mb-4">
                    <i class="bi bi-mortarboard display-1"></i>
                </div>
                <h2 class="fw-bold mb-3">Sistem Akademik</h2>
                <p class="lead mb-4">Platform terpadu untuk mengelola data akademik mahasiswa dan mata kuliah</p>
                <div class="row text-center">
                    <div class="col-4">
                        <div class="border-end border-white-50 pe-3">
                            <div class="h4 fw-bold">500+</div>
                            <small>Mahasiswa</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end border-white-50 pe-3">
                            <div class="h4 fw-bold">50+</div>
                            <small>Courses</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="h4 fw-bold">1000+</div>
                        <small>Enrollments</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="w-100" style="max-width: 400px;">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-shield-lock text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h3 class="fw-bold text-dark">Selamat Datang</h3>
                            <p class="text-muted">Silakan login untuk mengakses sistem</p>
                        </div>

                        <!-- Alert Messages -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <?= form_open('auth/authenticate', ['id' => 'loginForm']) ?>
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">
                                <i class="bi bi-person me-1"></i>Username
                            </label>
                            <input type="text"
                                class="form-control form-control-lg <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                                id="username"
                                name="username"
                                value="<?= old('username') ?>"
                                placeholder="Masukkan username Anda"
                                required>
                            <?php if (isset($errors['username'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['username'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock me-1"></i>Password
                            </label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control form-control-lg <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password Anda"
                                    required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye" id="passwordIcon"></i>
                                </button>
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback">
                                        <?= $errors['password'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Ingat saya
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3" id="loginBtn">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Masuk
                        </button>
                        <?= form_close() ?>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="text-muted mb-3">Belum punya akun?</p>
                            <a href="<?= base_url('auth/register') ?>" class="btn btn-outline-primary w-100">
                                <i class="bi bi-person-plus me-2"></i>
                                Daftar Sebagai Mahasiswa
                            </a>
                        </div>

                        <div class="mt-4">
                            <div class="card bg-light">
                                <div class="card-body py-3">
                                    <h6 class="card-title mb-2">
                                        <i class="bi bi-info-circle text-info me-1"></i>
                                        Demo Accounts
                                    </h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Admin:</small>
                                            <small><strong>admin / password</strong></small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Student:</small>
                                            <small><strong>student1 / password</strong></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        &copy; <?= date('Y') ?> Sistem Akademik. Dibuat oleh Dzakir Tsabit 241511071.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for this page -->
<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 15px;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-primary {
        border-color: #667eea;
        color: #667eea;
        border-radius: 10px;
    }

    .btn-outline-primary:hover {
        background-color: #667eea;
        border-color: #667eea;
    }

    /* Loading animation */
    .loading {
        pointer-events: none;
    }

    .loading .btn {
        position: relative;
        color: transparent;
    }

    .loading .btn::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('passwordIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                passwordIcon.className = 'bi bi-eye';
            } else {
                passwordIcon.className = 'bi bi-eye-slash';
            }
        });

        // Form submission with loading state
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');

        loginForm.addEventListener('submit', function() {
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
            loginBtn.disabled = true;

            // Re-enable button after 5 seconds (in case of error)
            setTimeout(function() {
                loginBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk';
                loginBtn.disabled = false;
            }, 5000);
        });

        // Demo account quick fill
        document.querySelectorAll('.card-body small strong').forEach(function(element) {
            element.style.cursor = 'pointer';
            element.addEventListener('click', function() {
                const text = this.textContent;
                const [username, password] = text.split(' / ');
                document.getElementById('username').value = username;
                document.getElementById('password').value = password;
            });
        });
    });
</script>