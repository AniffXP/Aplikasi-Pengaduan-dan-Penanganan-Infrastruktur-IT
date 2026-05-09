<?php session_start(); include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$qu = "SELECT * FROM login WHERE user_login = '$username'"; $ru = mysqli_query($koneksi, $qu); $user = mysqli_fetch_assoc($ru);
$id = intval($_GET['id']);
$q = "SELECT laporan.*, login.nama AS nama_user, login.level AS user_level FROM laporan LEFT JOIN login ON laporan.id_user = login.id WHERE laporan.id = $id";
$r = mysqli_query($koneksi, $q);
$data = mysqli_fetch_assoc($r);

// Proses validasi
if (isset($_POST['validasi_selesai'])) {
    $tgl_selesai = date('Y-m-d H:i:s');
    mysqli_query($koneksi, "UPDATE laporan SET status='Selesai', tgl_selesai='$tgl_selesai' WHERE id=$id");
    header("location:detail.php?id=$id"); exit;
}
if (isset($_POST['kembali_proses'])) {
    mysqli_query($koneksi, "UPDATE laporan SET status='Proses' WHERE id=$id");
    header("location:detail.php?id=$id"); exit;
}
?>
<!DOCTYPE html><html lang="id"><head><title>Detail Pengaduan</title>
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


<div class="card shadow-sm" id="content">
<div class="card shadow-sm">
<div class="card-header text-white text-center py-2" style="background:linear-gradient(135deg,#00bcd4,#00acc1);"><h5 class="mb-0" style="font-weight:600;">Detail Pengaduan</h5></div>
<div class="card-body p-4">
<div class="row">
<div class="col-md-6">
<p><strong>ID:</strong> <?= $data['id'] ?></p>
<p><strong>Kategori:</strong> <?= htmlspecialchars($data['kategori']) ?></p>
<p><strong>Prioritas:</strong> <?= htmlspecialchars($data['prioritas']) ?></p>
<p><strong>Tanggal Pengaduan:</strong> <?= $data['tgl_pengaduan'] ?></p>
</div>
<div class="col-md-6">
<p><strong>Nama Pengadu:</strong> <?= htmlspecialchars($data['nama_user']) ?> (<?= $data['user_level'] ?>)</p>
<p><strong>Status:</strong> <?= htmlspecialchars($data['status']) ?></p>
<p><strong>Waktu Pengerjaan:</strong> <?= htmlspecialchars($data['waktu_pengerjaan']) ?></p>
<p><strong>Tanggal Selesai:</strong> <?= $data['tgl_selesai'] ?: '-' ?></p>
</div>
</div>
<hr>
<p><strong>Deskripsi:</strong><br><?= htmlspecialchars($data['deskripsi']) ?></p>
<p><strong>Bukti:</strong><br><?php if(!empty($data['bukti'])){ echo "<a href='../uploads/".$data['bukti']."' target='_blank'>".$data['bukti']."</a>"; } else { echo "<em>Tidak ada</em>"; } ?></p>
</div>

<?php if ($data['status'] == 'Validasi') { ?>
<div class="card-footer">
<div class="text-center p-2 mb-2" style="background:#e3f2fd;border-radius:6px;">
<p class="mb-0 small"><strong>Apakah pengaduan sudah sesuai dan masalah telah teratasi?</strong></p></div>
<form method="POST" class="d-flex justify-content-center gap-2">
<button type="submit" name="validasi_selesai" class="btn btn-success btn-sm">Validasi dan Tandai Selesai</button>
<button type="submit" name="kembali_proses" class="btn btn-warning btn-sm">Tidak, Kembalikan ke Proses</button>
</form>
<?php } ?>

<div class="card-footer text-center"><a href="index.php" class="btn btn-secondary btn-sm">Kembali</a></div>
</div></div>
</div><!-- end main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script></body></html>
