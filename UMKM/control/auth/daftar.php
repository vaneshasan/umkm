<?php
include '../../config/koneksi.php';
if (isset($_POST['simpan'])) {
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = password_hash($koneksi->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
    $email = $koneksi->real_escape_string($_POST['email']);

    // Insert into tbl_user
    $sql_user = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";
    if ($koneksi->query($sql_user) === TRUE) {
        // Get the last inserted id
        $id_user = $koneksi->insert_id;
        header("Location: ../../index.php");
        exit();
    } else {
        echo "Gagal Input Data: " . $koneksi->error;
        echo "<br><a href='signin.php'>Kembali</a>";
    }
}
?> 