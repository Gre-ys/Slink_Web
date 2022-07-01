<?php
// Import Function
require "function.php";

// Redirect Ke Halaman Login
if (isset($_SESSION["login"])) {
    header("Location: home.php");
    exit();
}

// Trigger Request Recovery Password
if (isset($_POST['submit_reqRecovery'])) {
    $reqRecovery = sendRecovery($_POST['email']);
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
    <title>Slink | Request Recovery Password</title>
</head>

<body>
    <main class="container shadow p-3 mb-5 bg-body rounded m-auto mt-5 w-75">
        <h4 class="text-center mb-5">Request Recovery Password</h4>
        <div class="w-50 m-auto">
            <p class="alert alert-info"><strong>Silahkan Masukan Email Akun Anda!</strong> Link untuk Recovery atau Ganti Password Akan Dikirim ke Email</p>
            <!-- Info Hasil Proses -->
            <?php if (isset($reqRecovery["error_emailVal"])) {
                echo $reqRecovery["error_emailVal"];
                echo "  <script>
                        Swal.fire({
                        icon: 'error',
                        title: 'Email Tidak Valid!',
                        text: 'Silahkan Gunakan Email yang Benar/Valid',
                        confirmButtonText: 'Ulangi',
                        confirmButtonColor: 'blue',
                        })
                        </script>";
            } ?>
            <?php if (isset($reqRecovery["error_verified"])) {
                echo $reqRecovery["error_verified"];
                echo "  <script>
                        Swal.fire({
                        icon: 'warning',
                        title: 'Akun Belum Terverifikasi!',
                        html: 'Silahkan Verifikasi Terlebih Dahulu',
                        confirmButtonText: 'Ulangi',
                        confirmButtonColor: 'blue',
                        })
                        </script>";
            } ?>
            <?php if (isset($reqRecovery["error_user"])) {
                echo $reqRecovery["error_user"];
                echo "  <script>
                        Swal.fire({
                        icon: 'error',
                        title: 'Akun Dengan Email Tersebut Tidak Ditemukan!',
                        text: ' Silahkan Gunakan Email yang Terdaftar pada Akun yang Telah Registrasi',
                        confirmButtonText: 'Ulangi',
                        confirmButtonColor: 'blue',
                        })
                        </script>";
            } ?>
            <?php if (isset($reqRecovery["error_send"])) {
                echo $reqRecovery["error_send"];
                echo "  <script>
                        Swal.fire({
                        icon: 'error',
                        title: 'Email Gagal Dikirim!',
                        text: ' Pastikan Koneksi Stabil dan Silahkan Coba Lagi Setelah Beberapa Saat',
                        confirmButtonText: 'Ulangi',
                        confirmButtonColor: 'blue',
                        })
                        </script>";
            } ?>
            <?php if (isset($reqRecovery["success"])) {
                echo $reqRecovery["success"];
                echo "  <script>
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'Email Recovery Berhasil Dikirim!',
                                    html: ' Silahkan Akses Link untuk Recovery Password yang Sudah Dikirimkan Ke Email',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
            } ?>


            <form action="" method="POST">
                <div class="form-floating mb-1">
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    <label for="email">Email</label>
                </div>
                <div class="col-2 m-auto">
                    <button type="submit" id="submit_reqRecovery" name="submit_reqRecovery" class="btn btn-primary mt-3 m-auto">Request</button>
                </div>
            </form>
        </div>
        <h6 class="my-4 text-center">Ayo <a href="login.php" class="text-decoration-none">Login!</a></h3>
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