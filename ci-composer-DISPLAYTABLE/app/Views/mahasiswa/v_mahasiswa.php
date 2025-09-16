<h3>Daftar Mahasiswa</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
    </tr>
    <?php foreach ($mhs as $row): ?>
        <tr>
            <td><?= esc($row['nim']) ?></td>
            <td><?= esc($row['nama_lengkap']) ?></td>
            <td><?= esc($row['jurusan']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>