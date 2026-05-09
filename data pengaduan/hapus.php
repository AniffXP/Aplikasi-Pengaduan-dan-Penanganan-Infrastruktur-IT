<?php
session_start(); include "../koneksi.php";
if (!isset($_SESSION["username"])) { header("location:../login/login.php"); exit; }
$id = intval($_GET["id"]);
mysqli_query($koneksi, "DELETE FROM laporan WHERE id = $id");
header("location:pengaduan.php"); exit;
?>
