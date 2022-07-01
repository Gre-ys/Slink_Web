<?php
// Import Function
require "function.php";

if (isset($_POST['submit_transfer'])) {
    $transfer = transferData($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Slink | Transfer Data Account</title>
</head>

<body>
    <main class="container shadow p-3 mb-5 bg-body rounded m-auto mt-5 w-75">
        <h4 class="text-center mb-5">Transfer Data Akun</h4>
        <p class="alert alert-warning"><strong>Yakin untuk Melakukan Transfer Data?</strong> Setelah Data Pindah Ke Akun Lain, Data Tidak Dapat Kembali dan Akun Ini Akan Dihapus Oleh Sistem</p>
        <p class="alert alert-info"><strong>Akun Ini</strong> Maksudnya Adalah Akun Saat ini Dimana Datanya Ingin Dipindahkan/DItransfer ke <strong>Akun Target(Pastikan Akun Target Belum Terverifikasi!)</strong></p>
        <!-- Info Hasil Proses -->
        <?php if (isset($transfer["error_sql"])) {
            echo $transfer["error_sql"];
            echo "  <script>
                Swal.fire({
                icon: 'error',
                title: 'Isi Field Dengan Benar!',
                html: ' {$transfer["error_sql"]}',
                confirmButtonText: 'Ulangi',
                confirmButtonColor: 'blue',
                })
                </script>";
        } ?>
        <?php if (isset($transfer["error_email_sama"])) {
            echo $transfer["error_email_sama"];
            echo "  <script>
                Swal.fire({
                icon: 'error',
                title: 'Email Sama!',
                text: ' Email Sendiri dan Target Tidak Boleh Sama',
                confirmButtonText: 'Ulangi',
                confirmButtonColor: 'blue',
                })
                </script>";
        } ?>
        <?php if (isset($transfer["error_username_sama"])) {
            echo $transfer["error_username_sama"];
            echo "  <script>
                Swal.fire({
                icon: 'error',
                title: 'Username Sama!',
                text: ' Username Sendiri dan Target Tidak Boleh Sama',
                confirmButtonText: 'Ulangi',
                confirmButtonColor: 'blue',
                })
                </script>";
        } ?>
        <?php if (isset($transfer["error_space"])) {
            echo $transfer["error_space"];
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
        <?php if (isset($transfer["success"])) {
            echo $transfer["success"];
            echo "  <script>
                Swal.fire({
                icon: 'success',
                title: 'Transfer Data Berhasil!,
                text: ' Silahkan Menggunakan Akun Baru',
                confirmButtonText: 'OK',
                confirmButtonColor: 'blue',
                })
                </script>";
        } ?>
        <form id="form_transfer" action="" method="POST">
            <section class="row">
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="username_sendiri" name="username_sendiri" placeholder="name@example.com" required>
                        <label for="username_sendiri">Username Akun Ini</label>
                    </div>
                    <?php if (isset($transfer["error_username_sendiri"])) {
                        echo $transfer["error_username_sendiri"];
                        echo "  <script>
                            Swal.fire({
                            icon: 'error',
                            title: 'Username Tidak Ditemukan!',
                            text: 'Silahkan Masukan Username yang Benar',
                            confirmButtonText: 'Ulangi',
                            confirmButtonColor: 'blue',
                            })
                            </script>";
                    } ?>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control" id="password_sendiri" name="password_sendiri" placeholder="name@example.com" required>
                        <label for="password_sendiri">Password Akun Ini</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email_sendiri" name="email_sendiri" placeholder="email_sendiri">
                        <label for="email_sendiri">Email Akun Ini</label>
                    </div>
                    <?php if (isset($transfer["error_emailVal_sendiri"])) {
                        echo $transfer["error_emailVal_sendiri"];
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
                    <?php if (isset($transfer["error_email_sendiri"])) {
                        echo $transfer["error_email_sendiri"];
                        echo "  <script>
                            Swal.fire({
                            icon: 'error',
                            title: 'Email Tidak Ditemukan!',
                            text: 'Silahkan Masukan Email yang Benar',
                            confirmButtonText: 'Ulangi',
                            confirmButtonColor: 'blue',
                            })
                            </script>";
                    } ?>

                </div>
                <div class="col-6">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="username_target" name="username_target" placeholder="name@example.com" required>
                        <label for="username_target">Username Akun Target</label>
                    </div>
                    <?php if (isset($transfer["error_username_target"])) {
                        echo $transfer["error_username_target"];
                        echo "  <script>
                            Swal.fire({
                            icon: 'error',
                            title: 'Username Tidak Ditemukan!',
                            text: 'Silahkan Masukan Username yang Benar',
                            confirmButtonText: 'Ulangi',
                            confirmButtonColor: 'blue',
                            })
                            </script>";
                    } ?>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control" id="password_target" name="password_target" placeholder="name@example.com" required>
                        <label for="password_target">Password Akun Target</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email_target" name="email_target" placeholder="email_target">
                        <label for="email_target">Email Akun Target</label>
                    </div>
                    <?php if (isset($transfer["error_emailVal_target"])) {
                        echo $transfer["error_emailVal_target"];
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
                    <?php if (isset($transfer["error_email_target"])) {
                        echo $transfer["error_email_target"];
                        echo "  <script>
                            Swal.fire({
                            icon: 'error',
                            title: 'Email Tidak Ditemukan!',
                            text: 'Silahkan Masukan Email yang Benar',
                            confirmButtonText: 'Ulangi',
                            confirmButtonColor: 'blue',
                            })
                            </script>";
                    } ?>
                </div>
            </section>
            <div class=" d-flex justify-content-center">
                <button type="submit" id="submit_transfer" name="submit_transfer" class="btn btn-primary mt-3 m-auto visually-hidden">Transfer Data</button>
                <button type="button" id="submit_transfer_trigger" name="submit_transfer_trigger" class="btn btn-primary mt-3 m-auto">Transfer Data</button>
            </div>
        </form>
        <h6 class="my-4 text-center">Ayo <a href="profile.php" class="text-decoration-none">Kembali!</a></h3>
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
    <script src="js/sweetalert.js"></script>
</body>

</html>