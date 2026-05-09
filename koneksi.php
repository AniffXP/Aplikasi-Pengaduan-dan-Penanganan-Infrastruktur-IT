<?php
$host = "localhost";
$user = "root";
$pass = "";
$nama_db = "layanan_pengaduan";
$koneksi = mysqli_connect($host, $user, $pass, $nama_db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
