<?php
// Import Function
require "function.php";

// Redirect Ke Halaman Login
if (isset($_SESSION["login"])) {
    header("Location: home.php");
    exit();
}

// Trigger Recovery Password
if (isset($_POST['submit_recovery'])) {
    $recovery = recovery($_POST, $_GET['key']);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Slink | Recovery Password</title>
</head>

<body>
    <main class="container shadow p-3 mb-5 bg-body rounded m-auto mt-5 w-75">
        <h4 class="text-center mb-5">Recovery Password</h4>
        <div class="w-50 m-auto">
            <p class="alert alert-info">Silahkan Masukan Username Akun & Password Baru</p>
            <!-- Info Hasil Proses -->
            <?php if (isset($recovery["error_user"])) {
                echo $recovery["error_user"];
                echo "  <script>
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Akun Tidak Ditemukan!',
                                    text: 'Masukan Username Akun yang Benar dan Sesuai Email',
                                    confirmButtonText: 'Ulangi',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
            } ?>
            <?php if (isset($recovery["error_key"])) {
                echo $recovery["error_key"];
                echo "  <script>
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Recovery Tidak Bisa Dilakukan!',
                                    text: 'Gunakan Username Akun yang Tertaut Dengan Email Penerima Link Recovery',
                                    confirmButtonText: 'Ulangi',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
            } ?>
            <?php if (isset($recovery["error_pass"])) {
                echo $recovery["error_pass"];
                echo "  <script>
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Password Tidak Boleh Kurang Dari 8 Karakter!',
                                    text: '  Silahkan Tambah Karakter untuk Password',
                                    confirmButtonText: 'Ulangi',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
            } ?>
            <?php if (isset($recovery["error_passCon"])) {
                echo $recovery["error_passCon"];
                echo "  <script>
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Konfirmasi Password Salah!',
                                    text: ' Silahkan Masukan Password yang Sudah diisi Di Field Sebelumnya',
                                    confirmButtonText: 'Ulangi',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
            } ?>
            <?php if (isset($recovery["error_space"])) {
                echo $recovery["error_space"];
                echo "  <script>
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Isi Field Dengan Benar!',
                                    text: ' Jangan Isi Field dengan whitespace/spasi Saja',
                                    confirmButtonText: 'Ulangi',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
            } ?>
            <?php if (isset($recovery["success"])) {
                echo $recovery["success"];
                echo "  <script>
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'Password Berhasil Diperbaharui!',
                                    html: 'Silahkan Login dan Kembali Aktif Menggunakan Slink',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
            } ?>

            <form action="" method="POST">
                <div class="form-floating mb-1">
                    <input type="text" class="form-control" id="username" name="username" placeholder="name@example.com" required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-1">
                    <input type="password" class="form-control" id="password" name="password" placeholder="name@example.com" required>
                    <label for="password">Password Baru</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="passwordCon" name="passwordCon" placeholder="passwordCon">
                    <label for="passwordCon">Konfirmasi Password</label>
                </div>
                <div class="col-2 m-auto">
                    <button type="submit" id="submit_recovery" name="submit_recovery" class="btn btn-primary mt-3 m-auto">Konfirmasi</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <div class="row">
            <div class="col-lg-12 text-center mt-5">
                <p><small>Copyright &copy; Slink 2022</small></p>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>