<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
</head>
<body>
    <h1>DATA MAHASISWA</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Umur</th>
        </tr>
        <?php if (!empty($mahasiswa)): ?>
            <?php foreach ($mahasiswa as $mhs): ?>
                <tr>
                    <td><?= esc($mhs['nim']) ?></td>
                    <td><?= esc($mhs['nama_lengkap']) ?></td>
                    <td><?= esc($mhs['umur']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Belum ada data mahasiswa</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
