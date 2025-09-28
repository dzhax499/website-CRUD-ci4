<h2>Daftar Courses Available</h2>
<p>Pilih mata kuliah yang ingin Anda ambil atau batalkan.</p>

<?php if (!empty($courses)): ?>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    <div id="enroll-container">
        <?= csrf_field() ?>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Kuota</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <?php
                    // Ambil detail dari JSON
                    $courseDetail = json_decode($course['enrolled_courses'], true);
                    $sks = $courseDetail['sks'] ?? 0;

                    // Cek apakah mahasiswa sudah mengambil mata kuliah ini
                    $isEnrolled = in_array($course['nim'], $enrolled_codes);
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox"
                                name="selected_courses[]"
                                value="<?= esc($course['nim']) ?>"
                                class="course-checkbox"
                                data-sks="<?= $sks ?>"
                                data-name="<?= esc($course['nama_lengkap']) ?>"
                                data-enrolled="<?= $isEnrolled ? '1' : '0' ?>">
                        </td>
                        <td><?= esc($course['nim']) ?></td>
                        <td><?= esc($course['nama_lengkap']) ?></td>
                        <td><?= esc($course['jurusan']) ?></td>
                        <td><?= $sks ?></td>
                        <td><?= esc($course['semester']) ?></td>
                        <td><?= esc($courseDetail['kuota'] ?? '-') ?></td>
                        <td>
                            <div class="description">
                                <?= esc($courseDetail['deskripsi'] ?? 'Tidak ada deskripsi') ?>
                            </div>
                        </td>
                        <td>
                            <?php if ($isEnrolled): ?>
                                <span class="badge badge-success">Sudah Diambil</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Belum Diambil</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="summary mt-3 p-3 bg-light rounded">
            <h5>Ringkasan Pilihan</h5>
            <div class="row">
                <div class="col-md-6">
                    <p>Total SKS untuk Enroll: <strong><span id="enroll-sks">0</span></strong></p>
                    <p>Mata Kuliah untuk Enroll: <strong><span id="enroll-courses-count">0</span></strong></p>
                    <div id="enroll-courses-list" class="text-muted small">
                        Belum ada mata kuliah dipilih untuk enroll
                    </div>
                </div>
                <div class="col-md-6">
                    <p>Total SKS untuk Drop: <strong><span id="drop-sks">0</span></strong></p>
                    <p>Mata Kuliah untuk Drop: <strong><span id="drop-courses-count">0</span></strong></p>
                    <div id="drop-courses-list" class="text-muted small">
                        Belum ada mata kuliah dipilih untuk drop
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="button" id="submit-enrollment" class="btn btn-success btn-lg" disabled>
                <i class="fas fa-plus-circle"></i> Enroll Mata Kuliah Terpilih
            </button>
            <button type="button" id="submit-drop" class="btn btn-danger btn-lg ml-2" disabled>
                <i class="fas fa-minus-circle"></i> Drop Mata Kuliah Terpilih
            </button>
            <button type="button" id="reset-selection" class="btn btn-secondary btn-lg ml-2">
                <i class="fas fa-undo"></i> Reset Pilihan
            </button>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <h4>Tidak Ada Course</h4>
        <p>Belum ada mata kuliah yang tersedia untuk saat ini.</p>
    </div>
<?php endif; ?>

<script src="<?= base_url('js/courses.js') ?>"></script>

<style>
</style>