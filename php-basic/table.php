<!-- 4 Menampilkan Tabel dengan HTML & PHP	 -->

<?php
// Menampilkan tabel HTML dengan looping
$mahasiswa = [
    ["id"=>1, "nama"=>"Andi", "nim"=>"123", "jurusan"=>"TI"],
    ["id"=>2, "nama"=>"Budi", "nim"=>"124", "jurusan"=>"TI"],
    ["id"=>3, "nama"=>"Citra", "nim"=>"125", "jurusan"=>"TI"]
];
?>
<table border="1" cellpadding="4">
    <tr><th>ID</th><th>Nama</th><th>NIM</th><th>Jurusan</th></tr>
    <?php foreach ($mahasiswa as $m): ?>
        <tr>
            <td><?= $m["id"] ?></td>
            <td><?= $m["nama"] ?></td>
            <td><?= $m["nim"] ?></td>
            <td><?= $m["jurusan"] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
