<div class="card-header">
    <h3 class="card-title">Daftar Mata Kuliah</h3>
    <div class="card-tools">
        <a href="<?= base_url('admin/courses/add/') ?>" class="btn btn-primary btn-sm">Tambah Mata Kuliah</a>
    </div>
</div>
<div class="card-body">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (!empty($courses) && is_array($courses)) : ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Semester</th>
                    <th>SKS</th>
                    <th>Kuota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course) : ?>
                    <?php
                    // Decode course details dari JSON
                    $courseDetail = json_decode($course['enrolled_courses'], true);
                    ?>
                    <tr>
                        <td><?= esc($course['nim']) ?></td>
                        <td><?= esc($course['nama_lengkap']) ?></td>
                        <td><?= esc($course['jurusan']) ?></td>
                        <td><?= esc($course['semester']) ?></td>
                        <td><?= isset($courseDetail['sks']) ? esc($courseDetail['sks']) : '-' ?></td>
                        <td><?= isset($courseDetail['kuota']) ? esc($courseDetail['kuota']) : '-' ?></td>
                        <td>
                            <a href="<?= base_url('admin/courses/edit/' . esc($course['nim'])) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('admin/courses/delete/' . esc($course['nim'])) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Tidak ada mata kuliah ditemukan.</p>
    <?php endif; ?>
</div>