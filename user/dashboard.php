<?php session_start(); include '../koneksi.php';
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$query_user = "SELECT * FROM login WHERE user_login = ?";
$stmt = mysqli_prepare($koneksi, $query_user);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result_user = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result_user);
if (!$user) { echo "<script>alert('Data pengguna tidak ditemukan.'); window.location='../login/login.php';</script>"; exit; }
if (!isset($_SESSION['id_user'])) { $_SESSION['id_user'] = $user['id']; }
$filter_condition = "";
if ($user['level'] === 'user' || $user['level'] === 'User') {
    $id_user = intval($_SESSION['id_user']);
    $filter_condition = "WHERE id_user = $id_user";
}
$total_masalah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM masalah"))['total'];
$total_pengaduan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM laporan $filter_condition"))['total'];

$wh = ($filter_condition != "") ? "$filter_condition AND" : "WHERE";
$pengaduan_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM laporan $wh status = 'Baru'"))['total'];
$pengaduan_proses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM laporan $wh status = 'Proses'"))['total'];
$pengaduan_validasi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM laporan $wh status = 'Validasi'"))['total'];
$pengaduan_selesai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM laporan $wh status = 'Selesai'"))['total'];
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
<link rel="stylesheet" href="../aset/style.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar bg-gradient-primary" id="sidebar"><div class="w-100">
<div class="sidebar-header p-3"><img class="sidebar-header" src="../gambar/pupuk.png" alt="Logo Pusri"></div><hr class="bg-light">
<ul class="nav flex-column w-100 px-3">
<li class="nav-item"><a class="nav-link text-white active" href="dashboard.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
<li class="nav-item"><a class="nav-link text-white" href="index.php"><i class="fas fa-comments me-2"></i>Data Pengaduan</a></li>
<li class="nav-item"><a class="nav-link text-white" href="masalah.php"><i class="fas fa-exclamation-circle me-2"></i>Data Masalah</a><hr class="bg-light"></li>
</ul>
</div></div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
<div class="container-fluid position-relative">
<div class="navbar-title">Aplikasi Pengaduan dan Penanganan Infrastruktur IT</div>
<div class="ms-auto d-flex align-items-center" style="position:relative;z-index:10;">
<a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
<img class="img-profile rounded-circle me-1" src="../gambar/profile.svg">
<span class="small" style="font-size:0.75rem;"><?= htmlspecialchars($user["nama"]) ?></span></a>
<div class="dropdown-menu dropdown-menu-end shadow animated--grow-in">
<a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt text-danger"></i> Logout</a></div>
</div></div></nav>

<!-- LOGOUT MODAL -->
<div class="modal fade" id="logoutModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
<div class="modal-header"><h5 class="modal-title">Konfirmasi Logout</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">Apakah Anda yakin ingin logout?</div>
<div class="modal-footer"><button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button><a class="btn btn-primary btn-sm" href="../login/logout.php">Logout</a></div>
</div></div></div>

<!-- CONTENT -->
<div class="card shadow-sm" id="content">
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Dashboard</h5>
<div class="row">
<div class="col-lg-4 mb-3"><div class="card bg-dark text-white"><div class="card-body"><h6 class="card-title">Total Data Masalah</h6><p class="card-text"><?= $total_masalah ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-danger text-white"><div class="card-body"><h6 class="card-title">Total Pengaduan</h6><p class="card-text"><?= $total_pengaduan ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-secondary text-white"><div class="card-body"><h6 class="card-title">Pengaduan Baru</h6><p class="card-text"><?= $pengaduan_baru ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-warning text-white"><div class="card-body"><h6 class="card-title">Pengaduan Dalam Proses</h6><p class="card-text"><?= $pengaduan_proses ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-info text-white"><div class="card-body"><h6 class="card-title">Pengaduan Dalam Validasi</h6><p class="card-text"><?= $pengaduan_validasi ?></p></div></div></div>
<div class="col-lg-4 mb-3"><div class="card bg-success text-white"><div class="card-body"><h6 class="card-title">Pengaduan Selesai</h6><p class="card-text"><?= $pengaduan_selesai ?></p></div></div></div>
</div>
</div>

</div><!-- end main-wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
</body></html>
