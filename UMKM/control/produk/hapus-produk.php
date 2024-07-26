<?php
session_start();

// Include file koneksi, untuk menghubungkan ke database
include '../../config/koneksi.php';

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek apakah ada parameter produk yang dikirim melalui URL
if (isset($_GET["produk"])) {
    $id_produk = input($_GET["produk"]);

    // Ambil data produk untuk mendapatkan nama gambar
    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $data = mysqli_fetch_array($query);

    // Jika data ditemukan
    if ($data) {
        // Ambil nama gambar
        $gambar = $data['gambar'];
        
        // Hapus data produk dari database
        $delete_query = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$id_produk'");

        // Cek apakah query berhasil dijalankan
        if ($delete_query) {
            // Jika gambar bukan gambar default, hapus gambar dari server
            if ($gambar != 'gambar_default.png') {
                $upload_dir = '../../aset/images/';
                unlink($upload_dir . $gambar);
            }

            // Redirect ke halaman yang sesuai dengan pesan berhasil
            header("Location: ../../view/penjual/index.php?delete=berhasil");
        } else {
            // Redirect ke halaman yang sesuai dengan pesan gagal
            header("Location: ../../view/penjual/index.php?delete=gagal");
        }
    } else {
        // Redirect ke halaman yang sesuai jika produk tidak ditemukan
        header("Location: ../../view/penjual/index.php?delete=notfound");
    }
} else {
    // Redirect ke halaman yang sesuai jika tidak ada parameter produk
    header("Location: ../../view/penjual/index.php?delete=noproduct");
}
?>

