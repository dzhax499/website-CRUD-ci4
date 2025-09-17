<!-- App/Views/dashboard/admin.php - Menggunakan Bootstrap Components -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Admin Dashboard</h2>
    <div class="text-muted">
        <i class="bi bi-person-check"></i>
        Selamat datang, <?= session()->get('nama_lengkap') ?>!
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="h3 text-white mb-1"><?= $total_courses ?></div>
                        <div class="text-white-50 small">Total Courses</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-book fs-2 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="h3 mb-1"><?= $total_students ?></div>
                        <div class="text-white-75 small">Total Students</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fs-2 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="h3 mb-1"><?= $total_enrollments ?></div>
                        <div class="text-white-75 small">Total Enrollments</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-journal-check fs-2 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="h3 mb-1"><?= date('Y') ?></div>
                        <div class="text-white-75 small">Academic Year</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar3 fs-2 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Courses Table -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-book"></i> Recent Courses
        </h5>
        <a href="<?= base_url('admin/courses/add') ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Course
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($recent_courses)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="bi bi-hash"></i> Kode MK</th>
                            <th><i class="bi bi-book"></i> Nama Mata Kuliah</th>
                            <th><i class="bi bi-person"></i> Dosen</th>
                            <th><i class="bi bi-award"></i> SKS</th>
                            <th><i class="bi bi-calendar"></i> Semester</th>
                            <th><i class="bi bi-people"></i> Kuota</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_courses as $course): ?>
                            <?php $courseDetail = json_decode($course['enrolled_courses'], true); ?>
                            <tr>
                                <td>
                                    <span class="badge bg-primary"><?= esc($course['nim']) ?></span>
                                </td>
                                <td><?= esc($course['nama_lengkap']) ?></td>
                                <td>
                                    <i class="bi bi-person-badge"></i>
                                    <?= esc($course['jurusan']) ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= esc($courseDetail['sks'] ?? '-') ?></span>
                                </td>
                                <td><?= esc($course['semester']) ?></td>
                                <td>
                                    <span class="badge bg-info"><?= esc($courseDetail['kuota'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/courses/edit/' . $course['nim']) ?>"
                                            class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/courses/delete/' . $course['nim']) ?>"
                                            class="btn btn-outline-danger btn-sm" title="Delete"
                                            onclick="return confirm('Yakin hapus course ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="text-muted">Belum ada course yang terdaftar.</p>
                <a href="<?= base_url('admin/courses/add') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Course Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-book"></i> Kelola Courses
                    </a>
                    <a href="<?= base_url('admin/students') ?>" class="btn btn-outline-success">
                        <i class="bi bi-people"></i> Kelola Students
                    </a>
                    <a href="<?= base_url('admin/courses/add') ?>" class="btn btn-outline-warning">
                        <i class="bi bi-plus-lg"></i> Tambah Course Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-graph-up"></i> System Status</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <small>Course Capacity</small>
                        <small class="text-muted">75%</small>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" style="width: 75%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <small>Student Activity</small>
                        <small class="text-muted">90%</small>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-primary" style="width: 90%"></div>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-between">
                        <small>System Health</small>
                        <small class="text-muted">100%</small>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>