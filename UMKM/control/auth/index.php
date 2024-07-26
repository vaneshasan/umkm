<?php
include '../../config/koneksi.php';
session_start();

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Cek kredensial
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($koneksi, $sql);

    if (!$result) {
        die("Error executing query: " . mysqli_error($koneksi));
    }

    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
        // Login berhasil, cek role
        $_SESSION['username'] = $row['username'];
        $_SESSION['id_user'] = $row['id_user'];

        if ($row['role'] == 'super admin') {
            header("Location: ../../admin/index.php");
        } else if ($row['role'] == 'admin') {
            header("Location: ../../view/penjual/index.php");
        }
        exit();
    } else {
        // Username atau password salah
        $_SESSION['login_error'] = "Username atau password Anda salah. Silakan coba lagi!";
        header("Location: ../../login.php");
        exit();
    }
}
?>
