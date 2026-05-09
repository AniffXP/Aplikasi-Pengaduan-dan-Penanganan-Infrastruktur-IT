<?php session_start(); include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$qu = "SELECT * FROM login WHERE user_login = '$username'"; $ru = mysqli_query($koneksi, $qu); $user = mysqli_fetch_assoc($ru);
if (!isset($_SESSION['id_user'])) { $_SESSION['id_user'] = $user['id']; }
$masalah = mysqli_query($koneksi, "SELECT * FROM masalah ORDER BY tracker ASC");

if (isset($_POST['submit'])) {
    $id_user = intval($_SESSION['id_user']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $prioritas = mysqli_real_escape_string($koneksi, $_POST['prioritas']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tgl = date('Y-m-d H:i:s');
    $bukti_name = '';
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $bukti_name = time() . '_' . $_FILES['bukti']['name'];
        move_uploaded_file($_FILES['bukti']['tmp_name'], '../uploads/' . $bukti_name);
    }
    $q = "INSERT INTO laporan (id_user, kategori, status, tgl_pengaduan, prioritas, deskripsi, waktu_pengerjaan, bukti) VALUES ($id_user, '$kategori', 'Baru', '$tgl', '$prioritas', '$deskripsi', '', '$bukti_name')";
    if (mysqli_query($koneksi, $q)) { header("location:index.php"); exit; }
}
?>
<!DOCTYPE html><html lang="id"><head><title>Tambah Pengaduan</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../aset/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head><body>
<div class="sidebar bg-gradient-primary" id="sidebar"><div class="w-100">
<div class="sidebar-header p-3"><img class="sidebar-header" src="../gambar/pupuk.png" alt="Logo"></div><hr class="bg-light">
<ul class="nav flex-column w-100 px-3">
<li class="nav-item"><a class="nav-link text-white" href="dashboard.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
<li class="nav-item"><a class="nav-link text-white active" href="index.php"><i class="fas fa-comments me-2"></i>Data Pengaduan</a></li>
<li class="nav-item"><a class="nav-link text-white" href="masalah.php"><i class="fas fa-exclamation-circle me-2"></i>Data Masalah</a><hr class="bg-light"></li>
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
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Tambah Pengaduan</h5>
<form method="POST" enctype="multipart/form-data">
<div class="mb-3"><label class="form-label">Tanggal Pengaduan</label><input type="text" class="form-control" value="<?= date('Y-m-d H:i:s') ?>" disabled style="background:#333;color:#fff;"></div>
<div class="mb-3"><label class="form-label">Kategori Masalah</label><select name="kategori" class="form-select" required>
<option value="">Pilih Kategori Masalah</option><?php while($m=mysqli_fetch_assoc($masalah)){ echo "<option value='{$m['tracker']}'>{$m['tracker']}</option>"; } ?></select></div>
<div class="mb-3"><label class="form-label">Status</label><input type="text" class="form-control" value="Baru" disabled style="background:#eee;"></div>
<div class="mb-3"><label class="form-label">Prioritas</label><select name="prioritas" class="form-select" required>
<option value="">Pilih Prioritas</option><option value="Tinggi">Tinggi</option><option value="Sedang">Sedang</option><option value="Rendah">Rendah</option></select></div>
<div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="4" required></textarea></div>
<div class="mb-3"><label class="form-label">Bukti</label><input type="file" name="bukti" class="form-control"></div>
<button type="submit" name="submit" class="btn btn-success">Simpan Pengaduan</button>
<a href="index.php" class="btn btn-primary">Kembali</a>
</form></div>
</div><!-- end main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script></body></html>
