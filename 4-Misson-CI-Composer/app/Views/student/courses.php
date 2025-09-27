<!-- App/Views/student/courses.php -->
<h2>Daftar Courses Available</h2>
<p>Pilih mata kuliah yang ingin Anda ambil.</p>

<?php if (!empty($courses)): ?>
    <form id="enroll-form" method="post" action="<?= base_url('student/enrollMultiple') ?>">
        <?= csrf_field() ?>

        <table class="table">
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <?php
                    $courseDetail = json_decode($course['enrolled_courses'], true);
                    $sks = $courseDetail['sks'] ?? 0;
                    $isEnrolled = in_array($course['nim'], $enrolled_codes);
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox"
                                name="selected_courses[]"
                                value="<?= esc($course['nim']) ?>"
                                class="course-checkbox"
                                data-sks="<?= $sks ?>"
                                data-name="<?= esc($course['nama_lengkap']) ?>">
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
                                <span class="badge badge-success">Enrolled</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Available</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($isEnrolled): ?>
                                <a href="<?= base_url('student/unenroll/' . $course['nim']) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin drop course ini?')">
                                    Drop
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('student/enroll/' . $course['nim']) ?>"
                                    class="btn btn-primary btn-sm"
                                    onclick="return confirm('Yakin ingin enroll course ini?')">
                                    Enroll
                                </a>
                            <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary mt-3">
            <p>Total SKS Terpilih: <span id="total-sks">0</span></p>
            <p>Mata Kuliah Terpilih: <span id="total-courses">0</span></p>
            <div id="selected-courses-list" class="text-muted small">
                Belum ada mata kuliah dipilih
            </div>
        </div>

        <button type="submit" id="submit-enrollment" class="btn btn-primary mt-3" disabled>
            Konfirmasi Enrollment
        </button>
    </form>
<?php else: ?>
    <div class="no-data">
        <p>Belum ada mata kuliah yang tersedia.</p>
    </div>
<?php endif; ?>

<!-- Load JS eksternal -->
<script src="<?= base_url('js/courses.js') ?>"></script>