<div class="card-header">
    <h3 class="card-title">Daftar Mahasiswa</h3>
</div>
<div class="card-body">
    <?php if (!empty($students) && is_array($students)) : ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Jurusan</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?= esc($student['nim']) ?></td>
                        <td><?= esc($student['nama_lengkap']) ?></td>
                        <td><?= esc($student['jurusan']) ?></td>
                        <td><?= esc($student['email']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/viewStudent/' . esc($student['nim'])) ?>" class="btn btn-info btn-sm">Lihat</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Tidak ada data mahasiswa ditemukan.</p>
    <?php endif; ?>
</div>