<?= $this->include('layout/header') ?>
<?= $this->include('layout/navbar') ?>

<div class="container">
    <?= $this->renderSection('content') ?>
</div>

<?= $this->include('layout/footer') ?>