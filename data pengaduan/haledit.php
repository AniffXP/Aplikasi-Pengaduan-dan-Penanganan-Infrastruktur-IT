<?php session_start(); include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$qu = "SELECT * FROM login WHERE user_login = '$username'"; $ru = mysqli_query($koneksi, $qu); $user = mysqli_fetch_assoc($ru);
$id = intval($_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM laporan WHERE id=$id"));
$masalah = mysqli_query($koneksi, "SELECT * FROM masalah ORDER BY tracker ASC");

if (isset($_POST['submit'])) {
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);
    $prioritas = mysqli_real_escape_string($koneksi, $_POST['prioritas']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $waktu = mysqli_real_escape_string($koneksi, $_POST['waktu_pengerjaan']);
    $tgl_selesai = ($status == 'Selesai') ? ", tgl_selesai='".date('Y-m-d H:i:s')."'" : "";
    $bukti_sql = "";
    if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
        $bukti_name = time() . '_' . $_FILES['bukti']['name'];
        move_uploaded_file($_FILES['bukti']['tmp_name'], '../uploads/' . $bukti_name);
        $bukti_sql = ", bukti='$bukti_name'";
    }
    $q = "UPDATE laporan SET kategori='$kategori', status='$status', prioritas='$prioritas', deskripsi='$deskripsi', waktu_pengerjaan='$waktu' $tgl_selesai $bukti_sql WHERE id=$id";
    if (mysqli_query($koneksi, $q)) { header("location:pengaduan.php"); exit; }
}
?>
<!DOCTYPE html><html lang="id"><head><title>Edit Pengaduan</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../aset/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head><body>
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
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Edit Pengaduan</h5>
<form method="POST" enctype="multipart/form-data">
<div class="mb-3"><label class="form-label">Tanggal Pengaduan</label><input type="text" class="form-control" value="<?= $data['tgl_pengaduan'] ?>" disabled style="background:#333;color:#fff;"></div>
<div class="mb-3"><label class="form-label">Kategori Masalah</label><select name="kategori" class="form-select" required>
<?php while($m=mysqli_fetch_assoc($masalah)){ $sel=$m['tracker']==$data['kategori']?'selected':''; echo "<option value='{$m['tracker']}' $sel>{$m['tracker']}</option>"; } ?></select></div>
<div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select">
<option value="Baru" <?= $data['status']=='Baru'?'selected':'' ?>>Baru</option>
<option value="Proses" <?= $data['status']=='Proses'?'selected':'' ?>>Proses</option>
<option value="Validasi" <?= $data['status']=='Validasi'?'selected':'' ?>>Validasi</option>
<option value="Selesai" <?= $data['status']=='Selesai'?'selected':'' ?>>Selesai</option></select></div>
<div class="mb-3"><label class="form-label">Prioritas</label><select name="prioritas" class="form-select">
<option value="Tinggi" <?= $data['prioritas']=='Tinggi'?'selected':'' ?>>Tinggi</option>
<option value="Sedang" <?= $data['prioritas']=='Sedang'?'selected':'' ?>>Sedang</option>
<option value="Rendah" <?= $data['prioritas']=='Rendah'?'selected':'' ?>>Rendah</option></select></div>
<div class="mb-3"><label class="form-label">Waktu Pengerjaan</label><select name="waktu_pengerjaan" class="form-select">
<option value="1-2 hari" <?= $data['waktu_pengerjaan']=='1-2 hari'?'selected':'' ?>>1-2 hari</option>
<option value="3-5 hari" <?= $data['waktu_pengerjaan']=='3-5 hari'?'selected':'' ?>>3-5 hari</option>
<option value="6-7 hari" <?= $data['waktu_pengerjaan']=='6-7 hari'?'selected':'' ?>>6-7 hari</option></select></div>
<div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($data['deskripsi']) ?></textarea></div>
<div class="mb-3"><label class="form-label">Bukti (upload ulang jika ingin ganti)</label><input type="file" name="bukti" class="form-control">
<?php if(!empty($data['bukti'])){ echo "<small>File saat ini: {$data['bukti']}</small>"; } ?></div>
<button type="submit" name="submit" class="btn btn-warning">Update</button>
<a href="pengaduan.php" class="btn btn-secondary">Kembali</a>
</form></div>
</div><!-- end main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script></body></html>
