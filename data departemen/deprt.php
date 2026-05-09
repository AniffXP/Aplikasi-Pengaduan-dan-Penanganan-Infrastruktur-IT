<?php session_start(); include '../koneksi.php';
if (!isset($_SESSION['username'])) { header("location:../login/login.php"); exit; }
$username = $_SESSION['username'];
$query_user = "SELECT * FROM login WHERE user_login = '$username'";
$result_user = mysqli_query($koneksi, $query_user);
$user = mysqli_fetch_assoc($result_user);
$query = "SELECT * FROM login ORDER BY nama ASC";
$result = mysqli_query($koneksi, $query);
$login_data = [];
while ($row = mysqli_fetch_assoc($result)) { $login_data[] = $row; }
?>
<!DOCTYPE html><html lang="id"><head><title>Data Departemen</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="../aset/style.css"></head><body>

<div class="sidebar bg-gradient-primary" id="sidebar"><div class="w-100">
<div class="sidebar-header p-3"><img class="sidebar-header" src="../gambar/pupuk.png" alt="Logo Pusri"></div><hr class="bg-light">
<ul class="nav flex-column w-100 px-3">
<li class="nav-item"><a class="nav-link text-white" href="../index.php"><i class="fas fa-home me-2"></i>Dashboard</a></li>
<li class="nav-item"><a class="nav-link text-white active" href="deprt.php"><i class="fas fa-building me-2"></i>Data Departemen</a></li>
<li class="nav-item"><a class="nav-link text-white" href="../data pengaduan/pengaduan.php"><i class="fas fa-comments me-2"></i>Data Pengaduan</a></li>
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
<h5 class="text-center text-primary mb-3" style="font-weight: 600;">Data Departemen</h5>
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
<div class="d-flex align-items-center flex-grow-1 me-2">
<input type="text" id="searchInput" class="form-control me-2" placeholder="Cari Departemen...">
<select id="orderSelect" class="form-select w-auto"><option value="ASC" selected>A-Z</option><option value="DESC">Z-A</option></select></div>
<a class="btn btn-success ms-2" href="tambah.php"><i class="bi bi-plus-circle"></i> Tambah Departemen</a></div>
<div class="table-responsive"><table class="table table-striped table-hover text-center"><thead class="table-primary">
<tr><th>No</th><th>Nama</th><th>Username</th><th>Level</th><th>Aksi</th></tr></thead>
<tbody id="tableBody"></tbody></table></div></div>

<script>
const data = <?= json_encode($login_data); ?>;
const searchInput = document.getElementById('searchInput');
const orderSelect = document.getElementById('orderSelect');
const tableBody = document.getElementById('tableBody');
function renderTable(filteredData) {
tableBody.innerHTML = '';
filteredData.forEach((item, index) => {
const row = `<tr><td>${index+1}</td><td>${item.nama}</td><td>${item.user_login}</td><td>${item.level}</td>
<td><a class="btn btn-warning btn-sm" href="haledit.php?id=${item.id}"><i class="bi bi-pencil-square"></i></a>
<a class="btn btn-danger btn-sm" href="hapus.php?id=${item.id}" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></a></td></tr>`;
tableBody.insertAdjacentHTML('beforeend', row);
});}
function filterAndSort() {
const searchValue = searchInput.value.toLowerCase();
const orderValue = orderSelect.value;
let filteredData = data.filter(item => item.nama.toLowerCase().includes(searchValue) || item.user_login.toLowerCase().includes(searchValue));
filteredData.sort((a, b) => orderValue === 'ASC' ? a.nama.localeCompare(b.nama) : b.nama.localeCompare(a.nama));
renderTable(filteredData);}
searchInput.addEventListener('input', filterAndSort);
orderSelect.addEventListener('change', filterAndSort);
filterAndSort();
</script>
</div><!-- end main-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script></body></html>
