<!-- App/Views/dashboard/admin.php -->
<h2>Admin Dashboard</h2>
<p>Selamat datang, <?= session()->get('nama_lengkap') ?>!</p>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= $total_courses ?></div>
        <div class="stat-label">Total Courses</div>
    </div>

    <div class="stat-card">
        <div class="stat-number"><?= $total_students ?></div>
        <div class="stat-label">Total Students</div>
    </div>

    <div class="stat-card">
        <div class="stat-number"><?= $total_enrollments ?></div>
        <div class="stat-label">Total Enrollments</div>
    </div>
</div>

<div class="section">
    <h3>Recent Courses</h3>
    <?php if (!empty($recent_courses)): ?>
        <table>
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>SKS</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recent_courses as $course): ?>
                    <?php $courseDetail = json_decode($course['enrolled_courses'], true); ?>
                    <tr>
                        <td><?= esc($course['nim']) ?></td>
                        <td><?= esc($course['nama_lengkap']) ?></td>
                        <td><?= esc($course['jurusan']) ?></td>
                        <td><?= esc($courseDetail['sks'] ?? '-') ?></td>
                        <td><?= esc($course['semester']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Belum ada course yang terdaftar.</p>
    <?php endif; ?>
</div>

<div class="section">
    <h3>Quick Actions</h3>
    <div class="action-buttons">
        <a href="<?= base_url('admin/courses') ?>" class="btn btn-primary">Kelola Courses</a>
        <a href="<?= base_url('admin/students') ?>" class="btn btn-primary">Kelola Students</a>
        <a href="<?= base_url('admin/courses/add') ?>" class="btn btn-success">Tambah Course Baru</a>
    </div>
</div>

<style>
    .section {
        margin: 30px 0;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }
</style>