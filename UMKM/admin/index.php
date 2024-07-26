<?php
include '../config/koneksi.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .custom-margin {
        margin-left: 20px;
        /* Atau nilai lainnya sesuai keinginan Anda */
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Admin Dashboard</h1>
            <div class="d-flex align-items-center">
                <a href="tambah-user.php">
                    <button class="btn btn-primary">Tambah Akun</button>
                </a>
                <a href="../control/auth/logout.php" class="custom-margin">
                    <!-- Menggunakan kelas custom-margin -->
                    <button class="btn btn-danger d-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-2"></i>Log Out
                    </button>
                </a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // perintah sql untuk menampilkan daftar pengguna yang berelasi dengan tabel kategori pengguna
                $sql = "select * from user order by id_user desc";
                $hasil = mysqli_query($koneksi, $sql);
                $no = 0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)) :
                    $no++;
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data['username']; ?></td>
                    <td><?php echo $data['email']; ?></td>
                    <td>
                        <a href="edit-user.php?user=<?= urlencode($data['id_user']) ?>"
                            class="btn-edit btn btn-warning btn-circle">Edit</a>
                        <a href="hapus-user.php?user=<?= urlencode($data['id_user']) ?>"
                            class="btn-hapus btn btn-danger btn-circle"
                            onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>

                </tr>
                <!-- bagian akhir (penutup) while -->
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>