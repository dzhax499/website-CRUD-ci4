<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h2 class="mb-3"><i class="bi bi-list-check"></i> Daftar Courses</h2>
<form id="enrollForm" class="card p-3 shadow-sm">
    <?php foreach ($courses as $c): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="course[]" value="<?= $c['id'] ?>" data-sks="<?= $c['sks'] ?>">
            <label class="form-check-label"><?= $c['nama'] ?> (<?= $c['sks'] ?> SKS)</label>
        </div>
    <?php endforeach; ?>
    <p class="mt-3">Total SKS: <span id="totalSKS">0</span></p>
    <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Enroll</button>
</form>
<div id="result" class="mt-3"></div>
<?= $this->endSection() ?>