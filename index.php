<?php session_start(); include 'koneksi.php';
if (!isset($_SESSION['username'])) { header("location:login/login.php"); exit; }
$username = $_SESSION['username'];
$query_user = "SELECT * FROM login WHERE user_login = '$username'";
$result_user = mysqli_query($koneksi, $query_user);
$user = mysqli_fetch_assoc($result_user);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="aset/style.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar bg-gradient-primary" id="sidebar">
<div class="w-100">
<div class="sidebar-header p-3"><img class="sidebar-header" src="gambar/pupuk.png" alt="Logo Pusri"></div>
<hr class="bg-light">
<ul class="nav flex-column w-100 px-3">
<li class="nav-item"><a class="nav-link text-white active" href="index.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
<li class="nav-item"><a class="nav-link text-white" href="data departemen/deprt.php"><i class="fas fa-building me-2"></i>Data Departemen</a></li>
<li class="nav-item"><a class="nav-link text-white" href="data pengaduan/pengaduan.php"><i class="fas fa-comments me-2"></i>Data Pengaduan</a></li>
<li class="nav-item"><a class="nav-link text-white" href="data masalah/masalah.php"><i class="fas fa-exclamation-circle me-2"></i>Data Masalah</a><hr class="bg-light"></li>
</ul>
</div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
<div class="container-fluid position-relative">
<div class="navbar-title" id="navbarTitle">Aplikasi Pengaduan dan Penanganan Infrastruktur IT</div>
<div class="ms-auto d-flex align-items-center" style="position:relative;z-index:10;">
<a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
<img class="img-profile rounded-circle me-1" src="gambar/profile.svg" alt="Profile">
<span class="small" style="font-size:0.75rem;white-space:nowrap;"><?= htmlspecialchars($user["nama"]) ?></span></a>
<div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
<a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt fa-fw text-danger"></i> Logout</a>
</div>
</div>
</div>
</nav>


<!-- LOGOUT MODAL -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
<div class="modal-body">Apakah Anda yakin ingin logout dari akun ini?</div>
<div class="modal-footer"><button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><a class="btn btn-primary btn-sm" href="login/logout.php">Logout</a></div>
</div></div></div>

<!-- CONTENT -->
<div class="card shadow-sm" id="content">
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Dashboard</h5>
<div class="row">
<div class="col-lg-4 mb-3"><div class="card bg-primary text-white"><div class="card-body"><h6 class="card-title">Total Departemen</h6><p class="card-text"><?php $r=mysqli_query($koneksi,"SELECT COUNT(*) AS t FROM login WHERE level='user'"); $d=mysqli_fetch_assoc($r); echo $d['t']; ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-dark text-white"><div class="card-body"><h6 class="card-title">Total Data Masalah</h6><p class="card-text"><?php $r=mysqli_query($koneksi,"SELECT COUNT(*) AS t FROM masalah"); $d=mysqli_fetch_assoc($r); echo $d['t']; ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-danger text-white"><div class="card-body"><h6 class="card-title">Total Pengaduan</h6><p class="card-text"><?php $r=mysqli_query($koneksi,"SELECT COUNT(*) AS t FROM laporan"); $d=mysqli_fetch_assoc($r); echo $d['t']; ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-secondary text-white"><div class="card-body"><h6 class="card-title">Pengaduan Masuk</h6><p class="card-text"><?php $r=mysqli_query($koneksi,"SELECT COUNT(*) AS t FROM laporan WHERE status='Baru'"); $d=mysqli_fetch_assoc($r); echo $d['t']; ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-warning text-white"><div class="card-body"><h6 class="card-title">Pengaduan Dalam Proses</h6><p class="card-text"><?php $r=mysqli_query($koneksi,"SELECT COUNT(*) AS t FROM laporan WHERE status='Proses'"); $d=mysqli_fetch_assoc($r); echo $d['t']; ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-info text-white"><div class="card-body"><h6 class="card-title">Pengaduan Dalam Validasi</h6><p class="card-text"><?php $r=mysqli_query($koneksi,"SELECT COUNT(*) AS t FROM laporan WHERE status='Validasi'"); $d=mysqli_fetch_assoc($r); echo $d['t']; ?></p></div></div></div>
</div>
<div class="text-center mb-3 w-100"><div class="card bg-success text-white"><div class="card-body"><h6 class="card-title">Pengaduan Selesai</h6><p class="card-text"><?php $r=mysqli_query($koneksi,"SELECT COUNT(*) AS t FROM laporan WHERE status='Selesai'"); $d=mysqli_fetch_assoc($r); echo $d['t']; ?></p></div></div></div>
</div>

</div><!-- end main-wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body></html>
