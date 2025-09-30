<!DOCTYPE html>
<html lang="id">

<head>
    <!-- jQuery harus di-load SEBELUM script students -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= esc($title ?? 'Dashboard') ?></title>

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
        }

        .main-content {
            min-height: calc(100vh - 56px);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        /* Loading Spinner */
        #page-loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .spinner-border-custom {
            width: 3rem;
            height: 3rem;
        }

        /* Smooth transitions */
        #page-content {
            transition: opacity 0.3s ease-in-out;
        }

        #page-content.loading {
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-mortarboard"></i> Sistem Akademik
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (session()->get('role') == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link ajax-link" href="#" data-page="dashboard" data-title="Dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-book"></i> Courses
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item ajax-link" href="#" data-page="courses" data-title="Kelola Courses">Kelola Courses</a></li>
                                <li><a class="dropdown-item ajax-link" href="#" data-page="courses/add" data-title="Tambah Course">Tambah Course</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ajax-link" href="#" data-page="students" data-title="Kelola Students">
                                <i class="bi bi-people"></i> Students
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link ajax-link" href="#" data-page="dashboard" data-title="Dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ajax-link" href="#" data-page="courses" data-title="Browse Courses">
                                <i class="bi bi-search"></i> Browse Courses
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ajax-link" href="#" data-page="enrollments" data-title="My Courses">
                                <i class="bi bi-journal-check"></i> My Courses
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <?= session()->get('username') ?>
                            <span class="badge bg-primary"><?= ucfirst(session()->get('role')) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item ajax-link" href="#" data-page="profile" data-title="Profile">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main class="col-12 main-content">
                <div class="container-fluid py-4">
                    <!-- Page Title -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <h2 id="page-title"><?= esc($pageTitle ?? 'Dashboard') ?></h2>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="page-loader" style="display: none;">
                        <div class="text-center">
                            <div class="spinner-border spinner-border-custom text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3">Memuat halaman...</p>
                        </div>
                    </div>

                    <!-- Alert Container (untuk pesan dinamis) -->
                    <div id="alert-container"></div>

                    <!-- Alert Messages (Flash) -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Dynamic Page Content -->
                    <div id="page-content">
                        <?= $content ?? '' ?>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX Navigation Script -->
    <script>
        $(document).ready(function() {
            // AJAX Setup for CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#page-loader').show();
                    $('#page-content').addClass('loading');
                },
                complete: function() {
                    $('#page-loader').hide();
                    $('#page-content').removeClass('loading');
                }
            });

            // Handle AJAX Navigation
            $(document).on('click', '.ajax-link', function(e) {
                e.preventDefault();

                const page = $(this).data('page');
                const pageTitle = $(this).data('title');

                // Update active menu
                $('.nav-link').removeClass('active');
                $(this).addClass('active');

                // Load page content
                loadPage(page, pageTitle);
            });

            // Function to load page content via AJAX
            function loadPage(page, title) {
                $('#page-title').text(title);

                $.ajax({
                    url: '<?= base_url('admin/loadPage/') ?>' + page,
                    type: 'GET',
                    success: function(response) {
                        $('#page-content').html(response).hide().fadeIn('fast');

                        // Update browser history
                        const newUrl = '<?= base_url('admin/') ?>' + page;
                        history.pushState({
                            page: page,
                            title: title
                        }, title, newUrl);

                        // Re-initialize scripts for the loaded content
                        initializePageScripts(page);

                        // Scroll to top
                        window.scrollTo(0, 0);
                    },
                    error: function(xhr, status, error) {
                        showAlert('danger', 'Gagal memuat halaman. Silakan coba lagi atau refresh browser.');
                        console.error('AJAX Error:', error);
                    }
                });
            }

            // Initialize page-specific scripts after AJAX load
            function initializePageScripts(page) {
                // Re-initialize tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Page-specific initializations
                if (page === 'students' || page.includes('students')) {
                    console.log('Students page loaded');
                    // Initialize students page scripts here
                } else if (page === 'courses' || page.includes('courses')) {
                    console.log('Courses page loaded');
                    // Initialize courses page scripts here
                } else if (page === 'dashboard') {
                    console.log('Dashboard page loaded');
                    // Initialize dashboard scripts here
                }
            }

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.page) {
                    loadPage(e.state.page, e.state.title);

                    // Update active menu based on current page
                    $('.nav-link').removeClass('active');
                    $(`.ajax-link[data-page="${e.state.page}"]`).addClass('active');
                }
            });

            // Helper function to show alerts dynamically
            window.showAlert = function(type, message) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                $('#alert-container').html(alertHtml);

                // Auto hide after 5 seconds
                setTimeout(function() {
                    $('#alert-container .alert').alert('close');
                }, 5000);
            };

            // Initial page state
            const currentPage = '<?= $currentPage ?? 'dashboard' ?>';
            const currentTitle = $('#page-title').text();
            history.replaceState({
                page: currentPage,
                title: currentTitle
            }, currentTitle, window.location.href);

            // Auto hide flash alerts after 5 seconds
            setTimeout(function() {
                $('.alert:not(#alert-container .alert)').alert('close');
            }, 5000);
        });
    </script>

    <!-- Custom JavaScript (opsional) -->
    <script src="<?= base_url('js/app.js') ?>"></script>
</body>

</html>