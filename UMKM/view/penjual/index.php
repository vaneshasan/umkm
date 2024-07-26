<?php
session_start();
include('../../config/koneksi.php'); // Koneksi ke database
if (!isset($_SESSION['username'])) {
  header("Location: ../../login.php");
  exit();
}

// Pastikan pengguna sudah login dan id_user tersimpan dalam sesi
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Siapkan pernyataan SQL
    $sql = "SELECT * FROM produk WHERE id_user = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        // Bind parameter
        mysqli_stmt_bind_param($stmt, "i", $id_user);

        // Jalankan pernyataan
        mysqli_stmt_execute($stmt);

        // Ambil hasil
        $result = mysqli_stmt_get_result($stmt);

        // Mulai HTML
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Product Catalog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <style>
    .container {
        margin-top: 50px;
    }

    .card-deck {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .card {
        margin: 10px;
        width: 18rem;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard - Product Catalog</h1>
            <div>
                <a href="../../control/produk/tambah-produk.php"><button class="btn btn-primary btn-add">Add
                        Product</button></a>
                <a href="../../control/auth/logout.php" class="btn btn-danger">Log Out</a>
            </div>
        </div>
        <div class="card-deck" id="productCardDeck">
            <?php
            // Loop hasil dan tampilkan dalam format HTML
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="card">
                        <img src="../../aset/images/' . htmlspecialchars($row['gambar']) . '" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($row['nama_produk']) . '</h5>
                            <p class="card-text">$' . htmlspecialchars($row['harga']) . '</p>
                            <a href="../../control/produk/edit-produk.php?produk=' . urlencode($row['id_produk']) . '" class="btn btn-warning">Edit</a>
                            <a href="../../control/produk/hapus-produk.php?produk=' . urlencode($row['id_produk']) . '" class="btn btn-danger" onclick="return confirm(\'Anda yakin ingin menghapus produk ini?\')">Delete</a>
                        </div>
                    </div>';
                }
            } else {
                echo "Tidak ada produk yang ditemukan.";
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    // Script to populate Edit Product Modal with product data
    $('.btn-edit').on('click', function() {
        const productId = $(this).data('id');
        const productName = $(this).closest('.card').find('.card-title').text();
        const productPrice = $(this).closest('.card').find('.card-text').text().replace('$', '');
        $('#editProductId').val(productId);
        $('#editProductName').val(productName);
        $('#editProductPrice').val(productPrice);
    });
    </script>
</body>

</html>

<?php
        // Tutup pernyataan
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan pernyataan.";
    }
} else {
    echo "Pengguna belum login.";
}

// Tutup koneksi
mysqli_close($koneksi);
?>