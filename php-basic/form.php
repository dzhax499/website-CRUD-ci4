<?php
// cek apakah form sudah disubmit
$nama = isset($_GET["nama"]) ? htmlspecialchars($_GET["nama"]) : "";
$nim  = isset($_GET["nim"]) ? htmlspecialchars($_GET["nim"]) : "";
?>

<html>
    <body>
        <form action="" method = "GET">
            Nama : <input type="text" name="nama"><br>
            Nim :  <input type="text" name="nim"><br>
            <input type="submit">
        </form>

        <!-- Saat menekan submit -->
         <h1>Selamat datang <?php echo $_GET["nama"]?><br></h1>
         <h1>Dengan Nim <?php echo $_GET["nim"]?><br></h1>
    </body>
</html>