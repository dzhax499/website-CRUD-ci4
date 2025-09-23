<div class="card-header">
    <h3 class="card-title">Tambah Mata Kuliah Baru</h3>
</div>
<div class="card-body">
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/courses/store/') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="kode_mk">Kode Mata Kuliah</label>
            <input type="text" name="kode_mk" id="kode_mk" class="form-control" value="<?= old('kode_mk') ?>">
        </div>
        <div class="form-group">
            <label for="nama_mk">Nama Mata Kuliah</label>
            <input type="text" name="nama_mk" id="nama_mk" class="form-control" value="<?= old('nama_mk') ?>">
        </div>
        <div class="form-group">
            <label for="dosen">Dosen Pengampu</label>
            <input type="text" name="dosen" id="dosen" class="form-control" value="<?= old('dosen') ?>">
        </div>
        <div class="form-group">
            <label for="semester">Semester</label>
            <input type="number" name="semester" id="semester" class="form-control" value="<?= old('semester') ?>">
        </div>
        <div class="form-group">
            <label for="sks">SKS</label>
            <input type="number" name="sks" id="sks" class="form-control" value="<?= old('sks') ?>">
        </div>
        <div class="form-group">
            <label for="kuota">Kuota</label>
            <input type="number" name="kuota" id="kuota" class="form-control" value="<?= old('kuota') ?>">
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control"><?= old('deskripsi') ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>