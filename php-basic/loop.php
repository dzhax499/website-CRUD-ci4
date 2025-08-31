<!-- 3 Program PHP : Instruksi Pengulangan	 -->

<?php 
echo "LIST DATA MAHASISWA <br>";

for ($i = 0;$i < 10;$i++){
    echo "NOMOR KE $i <br>";
}

$warna = array("merah", "hijau", "biru", "kuning");

foreach ($warna as $x) {
  echo "<br> Ada Warna  $x <br>";
}

echo "";
$i = 1;

do {
  echo "$i<br>";
  $i++;
} while ($i < 6);
?>