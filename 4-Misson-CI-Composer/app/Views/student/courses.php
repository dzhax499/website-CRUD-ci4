<!-- App/Views/student/courses.php -->
<h2>Daftar Courses Available</h2>
<p>Pilih mata kuliah yang ingin Anda ambil.</p>

<?php if (!empty($courses)): ?>
    <table>
        <thead>
            <tr>
                <th>Kode MK</th>
                <th>Nama Mata Kuliah</th>
                <th>Dosen</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Kuota</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <?php
                $courseDetail = json_decode($course['enrolled_courses'], true);
                $isEnrolled = in_array($course['nim'], $enrolled_codes);
                ?>
                <tr>
                    <td><?= esc($course['nim']) ?></td>
                    <td><?= esc($course['nama_lengkap']) ?></td>
                    <td><?= esc($course['jurusan']) ?></td>
                    <td><?= esc($courseDetail['sks'] ?? '-') ?></td>
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
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-data">
        <p>Belum ada mata kuliah yang tersedia.</p>
    </div>
<?php endif; ?>

<div class="back-button">
    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">← Kembali ke Dashboard</a>
</div>

<style>
    .description {
        max-width: 200px;
        max-height: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 12px;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .badge-success {
        background: #28a745;
        color: white;
    }

    .badge-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    .no-data {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .back-button {
        margin-top: 20px;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    table {
        font-size: 14px;
    }

    table th {
        background-color: #343a40;
        color: white;
    }
</style>

<script>
        const courses = <?= json_encode($courses ?? []) ?>;
        console.log("Courses dari PHP:", courses);
</script>