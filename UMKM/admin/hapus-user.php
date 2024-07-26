<?php
// include database
include '../config/koneksi.php';

// Periksa apakah ID pengguna ada di URL
if (isset($_GET['user'])) {
    $user_id = mysqli_real_escape_string($koneksi, $_GET['user']);

    // Query untuk menghapus data pengguna berdasarkan ID
    $delete_query = "DELETE FROM penguna WHERE id_user = '$user_id'";
    if (mysqli_query($koneksi, $delete_query)) {
        echo "Data deleted successfully.";
        // Redirect setelah penghapusan berhasil
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting data: " . mysqli_error($koneksi);
    }
} else {
    die("No user ID specified.");
}
?>
