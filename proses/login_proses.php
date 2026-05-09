<?php
session_start();
include "../koneksi.php";

if (isset($_POST["login"])) {
    $username = mysqli_real_escape_string($koneksi, $_POST["username"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM login WHERE user_login = '$username' AND pass_login = '$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $data["user_login"];
        $_SESSION["nama"] = $data["nama"];
        $_SESSION["level"] = $data["level"];
        $_SESSION["id_user"] = $data["id"];

        if ($data["level"] == "admin" || $data["level"] == "Admin") {
            header("location:../index.php?status=success");
        } else {
            header("location:../user/dashboard.php?status=success");
        }
        exit;
    } else {
        header("location:../login/login.php?status=fail");
        exit;
    }
}
?>
