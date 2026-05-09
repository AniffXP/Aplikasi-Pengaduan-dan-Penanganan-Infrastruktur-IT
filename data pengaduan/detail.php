<?php session_start(); include '../koneksi.php';
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$qu = "SELECT * FROM login WHERE user_login = '$username'";
$ru = mysqli_query($koneksi, $qu); $user = mysqli_fetch_assoc($ru);
$id = intval($_GET['id']);
$q = "SELECT laporan.*, login.nama AS nama_user FROM laporan LEFT JOIN login ON laporan.id_user = login.id WHERE laporan.id = $id";
$r = mysqli_query($koneksi, $q);
$data = mysqli_fetch_assoc($r);
?>
<!DOCTYPE html><html lang="id"><head><title>Detail Pengaduan</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../aset/style.css"></head><body>

<div class="sidebar bg-gradient-primary" id="sidebar"><div class="w-100">
<div class="sidebar-header p-3"><img class="sidebar-header" src="../gambar/pupuk.png" alt="Logo"></div><hr class="bg-light">
<ul class="nav flex-column w-100 px-3">
<li class="nav-item"><a class="nav-link text-white" href="../index.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
<li class="nav-item"><a class="nav-link text-white" href="../data departemen/deprt.php"><i class="fas fa-building me-2"></i>Data Departemen</a></li>
<li class="nav-item"><a class="nav-link text-white active" href="pengaduan.php"><i class="fas fa-comments me-2"></i>Data Pengaduan</a></li>
<li class="nav-item"><a class="nav-link text-white" href="../data masalah/masalah.php"><i class="fas fa-exclamation-circle me-2"></i>Data Masalah</a><hr class="bg-light"></li>
</ul></div></div>

<div class="main-wrapper">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm"><div class="container-fluid position-relative">
<div class="navbar-title">Aplikasi Pengaduan dan Penanganan Infrastruktur IT</div>
<div class="ms-auto d-flex align-items-center" style="position:relative;z-index:10;">
<a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
<img class="img-profile rounded-circle me-1" src="../gambar/profile.svg">
<span class="small" style="font-size:0.75rem;"><?= htmlspecialchars($user["nama"]) ?></span></a>
<div class="dropdown-menu dropdown-menu-end shadow animated--grow-in">
<a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt text-danger"></i> Logout</a></div>
</div></div></nav>

<div class="modal fade" id="logoutModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Konfirmasi Logout</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">Apakah Anda yakin ingin logout?</div>
<div class="modal-footer"><button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><a class="btn btn-primary btn-sm" href="../login/logout.php">Logout</a></div>
</div></div></div>

<div class="card p-4 shadow-sm" id="content">
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Detail Pengaduan</h5>
<div class="card p-4">
<p><strong>ID:</strong> <?= $data['id'] ?></p>
<p><strong>Nama Pengadu:</strong> <?= htmlspecialchars($data['nama_user']) ?></p>
<p><strong>Kategori:</strong> <?= htmlspecialchars($data['kategori']) ?></p>
<p><strong>Status:</strong> <?= htmlspecialchars($data['status']) ?></p>
<p><strong>Prioritas:</strong> <?= htmlspecialchars($data['prioritas']) ?></p>
<p><strong>Waktu Pengerjaan:</strong> <?= htmlspecialchars($data['waktu_pengerjaan']) ?></p>
<p><strong>Tanggal Pengaduan:</strong> <?= $data['tgl_pengaduan'] ?></p>
<p><strong>Tanggal Selesai:</strong> <?= $data['tgl_selesai'] ?: '-' ?></p>
<hr>
<p><strong>Deskripsi:</strong><br><?= htmlspecialchars($data['deskripsi']) ?></p>
<p><strong>Bukti:</strong><br><?php if(!empty($data['bukti'])){ echo "<a href='../uploads/".$data['bukti']."' target='_blank'>".$data['bukti']."</a>"; } else { echo "<em>Tidak ada</em>"; } ?></p>
</div>
<div class="mt-3">
<a href="haledit.php?id=<?= $data['id'] ?>" class="btn btn-primary">Edit</a>
<a href="hapus.php?id=<?= $data['id'] ?>" class="btn btn-warning" onclick="return confirm('Yakin hapus?')">Hapus</a>
<a href="pengaduan.php" class="btn btn-secondary">Kembali</a>
</div></div>
</div><!-- end main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script></body></html>
