<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-body">
        <h3>Welcome, <?= session()->get('nama') ?></h3>
        <p class="text-muted">Role: <?= session()->get('role') ?></p>

        <div class="mt-4">
            <h5><i class="bi bi-journal-check"></i> My Courses</h5>
            <ul class="list-group">
                <li class="list-group-item">Pemrograman Web (3 SKS)</li>
                <li class="list-group-item">Basis Data (3 SKS)</li>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>