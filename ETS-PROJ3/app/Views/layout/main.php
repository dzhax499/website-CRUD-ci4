<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 text-primary"></i>
                <h5 class="mt-2">Manage Students</h5>
                <a href="#" class="btn btn-sm btn-primary">Go</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-book display-4 text-success"></i>
                <h5 class="mt-2">Manage Courses</h5>
                <a href="#" class="btn btn-sm btn-success">Go</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>