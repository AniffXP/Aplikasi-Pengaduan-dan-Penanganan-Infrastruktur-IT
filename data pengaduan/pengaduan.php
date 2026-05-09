<?php session_start(); include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$query_user = "SELECT * FROM login WHERE user_login = '$username'";
$result_user = mysqli_query($koneksi, $query_user);
$user = mysqli_fetch_assoc($result_user);
$query = "SELECT laporan.*, login.nama AS user FROM laporan LEFT JOIN login ON laporan.id_user = login.id ORDER BY laporan.tgl_pengaduan DESC";
$result = mysqli_query($koneksi, $query);
$pengaduan_data = [];
while ($row = mysqli_fetch_assoc($result)) { $pengaduan_data[] = $row; }
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Data Pengaduan</title>
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
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Data Pengaduan</h5>
<div class="d-flex justify-content-between mb-3">
<div class="d-flex align-items-center flex-grow-1 me-2">
<input type="text" id="searchInput" class="form-control me-2" placeholder="Cari Pengaduan...">
<select id="orderSelect" class="form-select w-auto"><option value="NEWEST" selected>Terbaru</option><option value="OLDEST">Terlama</option><option value="ASC">A-Z</option><option value="DESC">Z-A</option></select></div>
<a class="btn btn-success btn-ms" href="tambah.php"><i class="bi bi-plus-circle"></i> Tambah Pengaduan</a></div>
<div class="table-responsive"><table class="table table-striped table-hover table-bordered align-middle text-center"><thead class="table-primary">
<tr><th>No</th><th>Nama</th><th>Kategori</th><th>Status</th><th>Prioritas</th><th>Waktu Pengerjaan</th><th>Tanggal Pengaduan</th></tr></thead>
<tbody id="tableBody"></tbody></table></div></div>

<script>
const data = <?= json_encode($pengaduan_data); ?>;
const tableBody = document.getElementById('tableBody');
const searchInput = document.getElementById('searchInput');
const orderSelect = document.getElementById('orderSelect');
function renderTable(fd) { tableBody.innerHTML=''; fd.forEach((item,i) => {
const badge = item.status==='Selesai'?'success':item.status==='Proses'?'warning':item.status==='Validasi'?'info':'secondary';
const tgl = item.tgl_pengaduan ? new Date(item.tgl_pengaduan).toLocaleString() : '-';
tableBody.insertAdjacentHTML('beforeend',`<tr class="table-row" onclick="window.location='detail.php?id=${item.id}'" style="cursor:pointer"><td>${i+1}</td><td>${item.user}</td><td>${item.kategori}</td><td><span class="badge bg-${badge}">${item.status}</span></td><td>${item.prioritas}</td><td>${item.waktu_pengerjaan||'-'}</td><td>${tgl}</td></tr>`);})}
function filterAndSort() {
const s=searchInput.value.toLowerCase(); const o=orderSelect.value;
let fd=data.filter(i=>i.kategori.toLowerCase().includes(s)||i.user.toLowerCase().includes(s)||i.status.toLowerCase().includes(s)||i.prioritas.toLowerCase().includes(s));
if(o==='NEWEST') fd.sort((a,b)=>new Date(b.tgl_pengaduan)-new Date(a.tgl_pengaduan));
else if(o==='OLDEST') fd.sort((a,b)=>new Date(a.tgl_pengaduan)-new Date(b.tgl_pengaduan));
else if(o==='ASC') fd.sort((a,b)=>a.kategori.localeCompare(b.kategori));
else fd.sort((a,b)=>b.kategori.localeCompare(a.kategori));
renderTable(fd);}
searchInput.addEventListener('input',filterAndSort);
orderSelect.addEventListener('change',filterAndSort);
filterAndSort();
</script>
</div><!-- end main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script></body></html>
