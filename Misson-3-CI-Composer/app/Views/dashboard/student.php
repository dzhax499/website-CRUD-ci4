<!-- App/Views/dashboard/student.php -->
<h2>Student Dashboard</h2>

<?php if ($student): ?>
    <div class="student-info">
        <h3>Selamat datang, <?= esc($student['nama_lengkap']) ?>!</h3>
        <div class="info-grid">
            <div class="info-item">
                <strong>NIM:</strong> <?= esc($student['nim']) ?>
            </div>
            <div class="info-item">
                <strong>Jurusan:</strong> <?= esc($student['jurusan']) ?>
            </div>
            <div class="info-item">
                <strong>Semester:</strong> <?= esc($student['semester']) ?>
            </div>
            <div class="info-item">
                <strong>Email:</strong> <?= esc($student['email']) ?>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number"><?= count($available_courses) ?></div>
            <div class="stat-label">Available Courses</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?= count($enrolled_courses) ?></div>
            <div class="stat-label">My Courses</div>
        </div>

        <div class="stat-card">
            <?php
            $totalSKS = 0;
            foreach ($enrolled_courses as $course) {
                $courseDetail = json_decode($course['enrolled_courses'], true);
                $totalSKS += $courseDetail['sks'] ?? 0;
            }
            ?>
            <div class="stat-number"><?= $totalSKS ?></div>
            <div class="stat-label">Total SKS</div>
        </div>
    </div>

    <div class="section">
        <h3>My Enrolled Courses</h3>
        <?php if (!empty($enrolled_courses)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrolled_courses as $course): ?>
                        <?php $courseDetail = json_decode($course['enrolled_courses'], true); ?>
                        <tr>
                            <td><?= esc($course['nim']) ?></td>
                            <td><?= esc($course['nama_lengkap']) ?></td>
                            <td><?= esc($course['jurusan']) ?></td>
                            <td><?= esc($courseDetail['sks'] ?? '-') ?></td>
                            <td><?= esc($course['semester']) ?></td>
                            <td>
                                <a href="<?= base_url('student/unenroll/' . $course['nim']) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin membatalkan enrollment?')">
                                    Drop
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Anda belum mengambil mata kuliah apapun.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h3>Quick Actions</h3>
        <div class="action-buttons">
            <a href="<?= base_url('student/courses') ?>" class="btn btn-primary">Browse Courses</a>
            <a href="<?= base_url('student/enrollments') ?>" class="btn btn-primary">My Enrollments</a>
        </div>
    </div>

<?php else: ?>
    <div class="error-message">
        <p>Data mahasiswa tidak ditemukan. Silakan hubungi administrator.</p>
    </div>
<?php endif; ?>

<style>
    .student-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .info-item {
        background: white;
        padding: 10px;
        border-radius: 4px;
        border-left: 4px solid #007bff;
    }

    .section {
        margin: 30px 0;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid #f5c6cb;
    }
</style>