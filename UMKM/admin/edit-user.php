<?php
// include database
include '../config/koneksi.php';

// Periksa apakah ID pengguna ada di URL
if (isset($_GET['user'])) {
    $user_id = mysqli_real_escape_string($koneksi, $_GET['user']);

    // Ambil data pengguna berdasarkan ID
    $query = "SELECT * FROM user WHERE id_user = '$user_id'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_array($result);
    } else {
        die("User not found.");
    }
} else {
    die("No user ID specified.");
}

// Proses form pengeditan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $update_query = "UPDATE user SET username='$username', email='$email' WHERE id_user='$user_id'";
    if (mysqli_query($koneksi, $update_query)) {
        echo "Data updated successfully.";
        // Redirect setelah update berhasil
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating data: " . mysqli_error($koneksi);
    }
}

// Ambil daftar pengguna
$sql = "SELECT * FROM user ORDER BY id_user DESC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit User</h2>

        <!-- Form untuk mengedit data pengguna -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?user=' . urlencode($user_id); ?>" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        <h3 class="mt-4">User List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) :
                    $no++;
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo htmlspecialchars($data['username']); ?></td>
                        <td><?php echo htmlspecialchars($data['email']); ?></td>
                        <td>
                        <a href="edit-user.php?user=<?= urlencode($data['id_user']) ?>" class="btn-edit btn btn-warning btn-circle">Edit</a>
                        <a href="hapus-user.php?user=<?= urlencode($data['id_user']) ?>" class="btn-hapus btn btn-danger btn-circle" onclick="return confirm('Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
