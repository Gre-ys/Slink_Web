<?php
// Import Function
require "function.php";

// Mengajukan Registrasi
if (isset($_POST["register"])) {

    // Eksekusi Fungsi registrasi
    $register = register($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Slink | Register</title>
</head>

<body>

    <main class="vh-100" style="background-color: #A2D2D4;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11 mt-5">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Register</p>
                                    <?php if (isset($register["error_send"])) {
                                        echo $register["error_send"];
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
                                    <?php if (isset($register["error_space"])) {
                                        echo $register["error_space"];
                                        echo "  <script>
                                        Swal.fire({
                                        icon: 'error',
                                        title: 'Isi Field Dengan Benar!',
                                        text: ' Jangan Isi Field dengan whitespace/spasi Saja!',
                                        confirmButtonText: 'Ulangi',
                                        confirmButtonColor: 'blue',
                                        })
                                        </script>";
                                    } ?>
                                    <?php if (isset($register["success"])) {
                                        echo $register['success'];
                                        echo "  <script>
                                        Swal.fire({
                                        icon: 'success',
                                        title: 'Registrasi Berhasil!',
                                        html: 'Silahkan verifikasi Akun Menggunakan <strong>Email</strong> ini, dan Kode <strong>OTP</strong> yang Sudah Dikirim ke Email',
                                        confirmButtonText: 'OK',
                                        confirmButtonColor: 'blue',
                                        })
                                        </script>";
                                    } ?>


                                    <form class="mx-1 mx-md-4" action="" method="post">

                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0 form-group">
                                                <input type="text" name="nama" id="nama" class="form-control" required />
                                                <label for="nama">Nama</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0 form-group">
                                                <input type="text" name="username" id="username" class="form-control" required />
                                                <label for="username">Username</label>
                                                <?php if (isset($register["error_space2"])) {
                                                    echo $register["error_space2"];
                                                    echo "  <script>
                                                    Swal.fire({
                                                    icon: 'error',
                                                    title: 'Username Dilarang Menggunakan Space!',
                                                    text: ' Jangan Isi Field Username dengan Space',
                                                    confirmButtonText: 'Ulangi',
                                                    confirmButtonColor: 'blue',
                                                    })
                                                    </script>";
                                                } ?>
                                                <?php if (isset($register["error_username"])) {
                                                    echo $register["error_username"];
                                                    echo "  <script>
                                                    Swal.fire({
                                                    icon: 'error',
                                                    title: 'Username Sudah Digunakan!',
                                                    text: ' Silahkan Gunakan Username Lain',
                                                    confirmButtonText: 'Ulangi',
                                                    confirmButtonColor: 'blue',
                                                    })
                                                    </script>";
                                                } ?>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" name="email" id="email" class="form-control" require />
                                                <label class="form-label" for="email">Email</label>
                                                <?php if (isset($register["error_emailVal"])) {
                                                    echo $register["error_emailVal"];
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
                                                <?php if (isset($register["error_emailUni"])) {
                                                    echo $register["error_emailUni"];
                                                    echo "  <script>
                                                    Swal.fire({
                                                    icon: 'error',
                                                    title: 'Email Sudah Digunakan!',
                                                    text: 'Silahkan Gunakan Email Lain',
                                                    confirmButtonText: 'Ulangi',
                                                    confirmButtonColor: 'blue',
                                                    })
                                                    </script>";
                                                } ?>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="password" id="password" class="form-control" require />
                                                <label class="form-label" for="password">Password(Min 8 Karakter)</label>
                                                <?php if (isset($register["error_password"])) {
                                                    echo $register["error_password"];
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

                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" name="passwordCon" id="passwordCon" class="form-control" require />
                                                <label class="form-label" for="passwordCon">Konfirmasi Password</label>
                                                <?php if (isset($register["error_passwordCon"])) echo $register["error_passwordCon"] ?>
                                                <?php if (isset($register["error_passwordCon"])) {
                                                    echo $register["error_passwordCon"];
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
                                            </div>
                                        </div>
                                        <br>
                                        <div class="d-flex justify-content-center mt-1">
                                            <p>Sudah Punya Akun? <a href="./login.php" class="text-decoration-none">Login</a></p>
                                        </div>

                                        <div class="d-flex justify-content-center mb-2">
                                            <p>Belum Verifikasi Akun? <a href="./verifikasi.php" class="text-decoration-none">Verifikasi</a></p>
                                        </div>
                                        <br>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4 ">
                                            <button type="submit" name="register" class="btn btn-primary btn-lg border-light " style="background-color: #7EC384;">Register</button>
                                        </div>

                                    </form>
                                    <footer>
                                        <div class="row">
                                            <div class="col-lg-12 text-center mt-5">
                                                <p><small>Copyright &copy; Slink 2022</small></p>
                                            </div>
                                            <!-- /.col-lg-12 -->
                                        </div>
                                        <!-- /.row -->
                                    </footer>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2 md-5">

                                    <img src="../Foto/regis.png" class="img-fluid" alt="https://pngtree.com/so/Cartoon">

                                </div>
                            </div>
                        </div>
                    </div>
                    <footer>
                        <div class="row">
                            <div class="col-lg-12 text-center mt-3 md-2">
                                <p><small>Copyright &copy; Slink 2022</small></p>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                        <!-- /.row -->
                    </footer>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>