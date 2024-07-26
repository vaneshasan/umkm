<?php
session_start(); // Pastikan session dimulai di awal
include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <!-- Tampilkan pesan error jika ada -->
    <?php
    if (isset($_SESSION['login_error'])) {
        echo "<div id='error-message' class='alert alert-danger'>" . $_SESSION['login_error'] . "</div>";
        unset($_SESSION['login_error']); // Hapus pesan error setelah ditampilkan
    }
    ?>
    <div class="d-flex justify-content-center">
        <h1>Login Sebagai Penjual</h1>
    </div>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="aset/images/umkm2.png"
                        class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form id="login-form" action="control/auth/index.php" method="post">
                        <!-- Username input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="form1Example13" name="username" class="form-control form-control-lg"
                                required />
                            <label class="form-label" for="form1Example13">Username</label>
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="password" id="form1Example23" name="password"
                                class="form-control form-control-lg" required />
                            <label class="form-label" for="form1Example23">Password</label>
                        </div>

                        <div class="d-flex justify-content-around align-items-center mb-4">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                                <label class="form-check-label" for="form1Example3"> Remember me </label>
                            </div>
                            <a href="#!">Forgot password?</a>
                        </div>

                        <!-- Submit button -->
                        <button name="submit" type="submit" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-primary btn-lg btn-block">Sign in</button>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0 text-muted"><span>Belum punya akun? <a
                                        href="daftar.php"> Daftar</a></span></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Jika ada pesan error, sembunyikan setelah 2 detik dan bersihkan form
        window.onload = function() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                    document.getElementById('login-form').reset();
                }, 800); // 2000 milidetik = 2 detik
            }
        };
    </script>
</body>

</html>
