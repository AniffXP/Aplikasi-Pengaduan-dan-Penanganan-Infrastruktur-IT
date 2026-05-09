<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
background: url('../gambar/bg.png') no-repeat center center fixed;
background-size: cover;
height: 100vh;
overflow: hidden;
margin: 0;
}
.card {
background-color: rgba(255, 255, 255);
border-radius: 10px;
max-width: 500px;
}
.logo-container {
display: flex;
justify-content: center;
align-items: center;
gap: 35px;
margin-bottom: 25px;
}
.logo-container img {
max-width: 100px;
max-height: 100px;
object-fit: contain;
}
</style>
</head>
<body>
<div class="container mt-5 d-flex justify-content-center align-items-center" style="height: 100vh;">
<form method="POST" action="../proses/login_proses.php" id="loginForm">
<div class="card p-5 mx-auto">
<div class="logo-container">
<img src="../gambar/logoakhlak.png" alt="Logo Akhlak">
<img src="../gambar/pupuk.png" alt="Logo Pusri">
<img src="../gambar/bumn.png" alt="Logo BUMN">
</div>
<h2 class="text-center mb-4">Login</h2>
<div class="mb-3">
<label for="username" class="form-label">Username</label>
<input type="text" class="form-control" id="username" name="username" required>
</div>
<div class="mb-3">
<label for="password" class="form-label">Password</label>
<input type="password" class="form-control" id="password" name="password" required>
</div>
<div class="text-center">
<button type="submit" class="btn btn-primary w-100" name="login">Login</button>
</div>
<br>
</div>
</form>
</div>
<script>
const urlParams = new URLSearchParams(window.location.search);
const loginStatus = urlParams.get('status');
if (loginStatus === 'success') { alert('Berhasil masuk!'); }
else if (loginStatus === 'fail') { alert('Login gagal! Periksa username dan password Anda.'); }
</script>
</body>
</html>
