<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Data Mahasiswa</h3>
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

        <form action="<?= base_url('admin/updateStudent/' . esc($student['nim'])) ?>" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text"
                            class="form-control"
                            id="nim"
                            value="<?= esc($student['nim']) ?>"
                            disabled>
                        <small class="form-text text-muted">NIM tidak dapat diubah</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control <?= session('errors.nama_lengkap') ? 'is-invalid' : '' ?>"
                            id="nama_lengkap"
                            name="nama_lengkap"
                            value="<?= old('nama_lengkap', $student['nama_lengkap']) ?>"
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
                            value="<?= old('username', $student['username']) ?>"
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
                            value="<?= old('email', $student['email']) ?>"
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
                        <label for="password">Password Baru</label>
                        <input type="password"
                            class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                            id="password"
                            name="password"
                            placeholder="Kosongkan jika tidak ingin mengubah password">
                        <small class="form-text text-muted">Minimal 6 karakter</small>
                        <?php if (session('errors.password')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password Baru</label>
                        <input type="password"
                            class="form-control <?= session('errors.confirm_password') ? 'is-invalid' : '' ?>"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="Ulangi password baru">
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
                            <?php
                            $jurusanList = [
                                'Teknik Informatika',
                                'Sistem Informasi',
                                'Teknik Elektro',
                                'Teknik Mesin',
                                'Teknik Sipil',
                                'Manajemen',
                                'Akuntansi'
                            ];
                            $selectedJurusan = old('jurusan', $student['jurusan']);
                            foreach ($jurusanList as $jur): ?>
                                <option value="<?= $jur ?>" <?= $selectedJurusan == $jur ? 'selected' : '' ?>>
                                    <?= $jur ?>
                                </option>
                            <?php endforeach; ?>
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
                            value="<?= old('semester', $student['semester']) ?>"
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
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="<?= base_url('admin/students') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>