<?php session_start(); include '../koneksi.php';
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$query_user = "SELECT * FROM login WHERE user_login = '$username'";
$result_user = mysqli_query($koneksi, $query_user);
$user = mysqli_fetch_assoc($result_user);
if (isset($_POST['submit'])) {
    $tracker = mysqli_real_escape_string($koneksi, $_POST['tracker']);
    mysqli_query($koneksi, "INSERT INTO masalah (tracker) VALUES ('$tracker')");
    header("location:masalah.php"); exit;
}
?>
<!DOCTYPE html><html lang="id"><head><title>Tambah Masalah</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../aset/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head><body>
<div class="sidebar bg-gradient-primary" id="sidebar"><div class="w-100">
<div class="sidebar-header p-3"><img class="sidebar-header" src="../gambar/pupuk.png" alt="Logo"></div><hr class="bg-light">
<ul class="nav flex-column w-100 px-3">
<li class="nav-item"><a class="nav-link text-white" href="../index.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
<li class="nav-item"><a class="nav-link text-white" href="../data departemen/deprt.php"><i class="fas fa-building me-2"></i>Data Departemen</a></li>
<li class="nav-item"><a class="nav-link text-white" href="../data pengaduan/pengaduan.php"><i class="fas fa-comments me-2"></i>Data Pengaduan</a></li>
<li class="nav-item"><a class="nav-link text-white active" href="masalah.php"><i class="fas fa-exclamation-circle me-2"></i>Data Masalah</a><hr class="bg-light"></li>
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
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Tambah Tracker</h5>
<form method="POST">
<div class="mb-3"><label class="form-label">Nama Tracker</label><input type="text" name="tracker" class="form-control" required></div>
<button type="submit" name="submit" class="btn btn-success">Tambah</button>
<a href="masalah.php" class="btn btn-secondary">Kembali</a>
</form></div>
</div><!-- end main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script></body></html>
