<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard"><i class="bi bi-mortarboard-fill"></i> ASPA</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (session()->get('role') == 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="/admin/courses"><i class="bi bi-book"></i> Manage Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/students"><i class="bi bi-people"></i> Manage Students</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/student/courses"><i class="bi bi-check2-square"></i> Enroll Courses</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><span class="navbar-text text-white me-3"><i class="bi bi-person-circle"></i> <?= session()->get('nama') ?></span></li>
                <li class="nav-item"><a class="nav-link" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>