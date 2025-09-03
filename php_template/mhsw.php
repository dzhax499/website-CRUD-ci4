<?php
// koneksi database
$host = "localhost";
$user = "root";   // ganti sesuai user DB
$pass = "";       // ganti sesuai password DB
$db   = "akademik_db"; // nama database

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// query ambil data mahasiswa
$sql = "SELECT * FROM mahasiswa ORDER BY nim ASC";
$result = $conn->query($sql);
?>

<table>
    <tr>
        <th>Nim</th>
        <th>Nama</th>
        <th>Umur</th>
        <th>Aksi</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nim']); ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['umur']); ?></td>
                <td><a href="template_02.php?page=detail&nim=<?= $row['nim']; ?>">Detail</a></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">Data tidak ditemukan</td>
        </tr>
    <?php endif; ?>
</table>

<?php $conn->close(); ?>
