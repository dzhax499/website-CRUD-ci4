<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Mahasiswa Baru</h3>
    </div>
    <div class="card-body">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/storeStudent') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nim">NIM <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= session('errors.nim') ? 'is-invalid' : '' ?>" 
                               id="nim" 
                               name="nim" 
                               value="<?= old('nim') ?>" 
                               placeholder="Contoh: 2101234567">
                        <?php if (session('errors.nim')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.nim') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= session('errors.nama_lengkap') ? 'is-invalid' : '' ?>" 
                               id="nama_lengkap" 
                               name="nama_lengkap" 
                               value="<?= old('nama_lengkap') ?>" 
                               placeholder="Masukkan nama lengkap">
                        <?php if (session('errors.nama_lengkap')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.nama_lengkap') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                               id="username" 
                               name="username" 
                               value="<?= old('username') ?>" 
                               placeholder="Username untuk login">
                        <?php if (session('errors.username')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.username') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                               id="email" 
                               name="email" 
                               value="<?= old('email') ?>" 
                               placeholder="email@example.com">
                        <?php if (session('errors.email')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                               id="password" 
                               name="password" 
                               placeholder="Minimal 6 karakter">
                        <?php if (session('errors.password')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>" 
                               id="confirm_password" 
                               name="confirm_password" 
                               placeholder="Ulangi password">
                        <?php if (session('errors.confirm_password')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.confirm_password') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                        <select class="form-control <?= session('errors.jurusan') ? 'is-invalid' : '' ?>" 
                                id="jurusan" 
                                name="jurusan">
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="Teknik Informatika" <?= old('jurusan') == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                            <option value="Sistem Informasi" <?= old('jurusan') == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                            <option value="Teknik Elektro" <?= old('jurusan') == 'Teknik Elektro' ? 'selected' : '' ?>>Teknik Elektro</option>
                            <option value="Teknik Mesin" <?= old('jurusan') == 'Teknik Mesin' ? 'selected' : '' ?>>Teknik Mesin</option>
                            <option value="Teknik Sipil" <?= old('jurusan') == 'Teknik Sipil' ? 'selected' : '' ?>>Teknik Sipil</option>
                            <option value="Manajemen" <?= old('jurusan') == 'Manajemen' ? 'selected' : '' ?>>Manajemen</option>
                            <option value="Akuntansi" <?= old('jurusan') == 'Akuntansi' ? 'selected' : '' ?>>Akuntansi</option>
                        </select>
                        <?php if (session('errors.jurusan')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.jurusan') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="semester">Semester <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control <?= session('errors.semester') ? 'is-invalid' : '' ?>" 
                               id="semester" 
                               name="semester" 
                               value="<?= old('semester') ?>" 
                               min="1" 
                               max="14" 
                               placeholder="1-14">
                        <?php if (session('errors.semester')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.semester') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="<?= base_url('admin/students') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>