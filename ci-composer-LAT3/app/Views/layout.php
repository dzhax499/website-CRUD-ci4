<!DOCTYPE html>
<html>
<head>
    <title><?= esc($title) ?></title>
</head>
<body>
    <div class="header">
        <h2>My Website</h2>
    </div>

    <div class="menu">
        <a href="<?= base_url('home') ?>">Home</a>
        <a href="<?= base_url('berita') ?>">Berita</a>
    </div>

    <div class="content">
        <?= $content ?>
    </div>

    <div class="footer">
        &copy; <?= date('Y') ?> My Website
    </div>
</body>
</html>
