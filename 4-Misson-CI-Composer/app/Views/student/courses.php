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
                            <!-- Status badge yang akan ter-update secara real-time -->
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
                    <div class="p-3 bg-success text-white rounded">
                        <h6>ENROLL (Ambil Mata Kuliah)</h6>
                        <p class="mb-1">Total SKS: <strong><span id="enroll-sks">0</span></strong></p>
                        <p class="mb-2">Jumlah MK: <strong><span id="enroll-courses-count">0</span></strong></p>
                        <div id="enroll-courses-list" class="small">
                            Belum ada mata kuliah dipilih untuk enroll
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-danger text-white rounded">
                        <h6>DROP (Batalkan Mata Kuliah)</h6>
                        <p class="mb-1">Total SKS: <strong><span id="drop-sks">0</span></strong></p>
                        <p class="mb-2">Jumlah MK: <strong><span id="drop-courses-count">0</span></strong></p>
                        <div id="drop-courses-list" class="small">
                            Belum ada mata kuliah dipilih untuk drop
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="button" id="submit-enrollment" class="btn btn-success btn-lg" disabled>
                <i class="fas fa-plus-circle"></i> Enroll Mata Kuliah Terpilih
            </button>
            <button type="button" id="submit-drop" class="btn btn-danger btn-lg ml-2" disabled>
                <i class="fas fa-minus-circle"></i>Drop Mata Kuliah Terpilih
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
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.8em;
    }

    .badge-success {
        background-color: #28a745;
        color: white;
    }

    .badge-secondary {
        background-color: #6c757d;
        color: white;
    }

    .badge-primary {
        background-color: #007bff;
        color: white;
    }

    .badge-danger {
        background-color: #dc3545;
        color: white;
    }

    /* Styling untuk summary cards */
    .summary .bg-success,
    .summary .bg-danger {
        border-radius: 8px;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .summary h6 {
        margin-bottom: 10px;
        font-weight: bold;
    }

    /* Table styling */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .course-checkbox:checked+td {
        background-color: #e3f2fd;
    }

    /* Button styling */
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        border-radius: 6px;
    }

    .description {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .col-md-6 {
            margin-bottom: 1rem;
        }

        .btn-lg {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>