<h3>Daftar Berita</h3>

<ul>
    <?php foreach ($berita as $row): ?>
        <li>
            <strong><?= esc($row['nim']) ?></strong><br>
            <h1>NAMA : <?= esc($row['nama_lengkap']) ?><br></h1>
            <h2>UMUR : <?= esc($row['umur']) ?></h2>
        </li>
    <?php endforeach; ?>
</ul>
