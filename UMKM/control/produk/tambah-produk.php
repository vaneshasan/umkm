<?php
session_start();

if (isset($_POST['publish'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include '../../config/koneksi.php';

        $nama_produk = mysqli_real_escape_string($koneksi, $_POST["nama_produk"]);
        $harga = mysqli_real_escape_string($koneksi, $_POST["harga"]);
        $id_user = $_SESSION["id_user"];
        
        // Proses upload gambar
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
            $gambar = $_FILES['gambar']['name'];
            $x = explode('.', $gambar);
            $ekstensi = strtolower(end($x));
            $file_tmp = $_FILES['gambar']['tmp_name'];

            $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'gif');
            if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
                $upload_dir = '../../aset/images/';
                $upload_file = $upload_dir . basename($gambar);

                if (move_uploaded_file($file_tmp, $upload_file)) {
                    $sql = "INSERT INTO produk (id_user, nama_produk, harga, gambar) VALUES (?, ?, ?, ?)";
                    $stmt = $koneksi->prepare($sql);
                    $stmt->bind_param("ssis", $id_user, $nama_produk, $harga, $gambar);

                    if ($stmt->execute()) {
                        header("Location: ../../view/penjual/index.php?add=berhasil");
                    } else {
                        header("Location: ../../view/penjual/index.php?add=gagal");
                    }
                    
                    $stmt->close();
                } else {
                    echo "Gagal mengunggah gambar.";
                }
            } else {
                echo "Ekstensi file tidak diperbolehkan. Harap unggah file dengan ekstensi png, jpg, jpeg, atau gif.";
            }
        } else {
            echo "Tidak ada file yang diupload atau terjadi kesalahan saat mengunggah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Tambah Produk</title>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Produk</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga :</label>
                <input type="text" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="gambar">Pilih Gambar:</label>
                <input type="file" class="form-control-file" id="gambar" name="gambar" accept=".png, .jpg, .jpeg, .gif" required>
            </div>
            <button type="submit" name="publish" class="btn btn-primary">Upload Produk</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
