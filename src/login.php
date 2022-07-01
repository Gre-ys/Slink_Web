<?php
// Import Function
require "function.php";

// Penggunaan Cookie
if (isset($_COOKIE["user_id"]) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['user_id'];
    $key = $_COOKIE['key'];

    $cek = queryGetData("SELECT * FROM users WHERE id = $id");

    if ($key = hash('sha256', $cek[0]['username'])) {
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $id;
    }
}

// Redirect Ke Halaman Home Ketika Sudah Login
if (isset($_SESSION["login"])) {
    header("Location: home.php");
    exit();
}

// Trigger Login
if (isset($_POST["login"])) {
    // Eksekusi Fungsi Login
    $login = login($_POST);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style2.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Slink | Login</title>
</head>

<body>

    <main class="vh-100" style="background-color: #A2D2D4;">
        <div class="container h-100 ">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11  ">
                    <div class="card text-black my-5" style="border-radius: 25px;">
                        <div class="card-body p-md-5">

                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1 p-5">
                                    <!--awal login-->
                                    <main class="animasi">
                                        <div class="login border shadow p-3 mb-1 bg-body rounded-5 position-relative">
                                            <!-- Info Hasil Proses -->
                                            <?php if (isset($login["error_verified"])) {
                                                echo $login["error_verified"];
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
                                            <?php if (isset($login["error"])) {
                                                echo $login["error"];
                                                echo "  <script>
                                                    Swal.fire({
                                                    icon: 'error',
                                                    title: 'Username atau Password Salah!',
                                                    text: ' Masukan Username dan Password yang Dibuat Ketika Register!',
                                                    confirmButtonText: 'Ulangi',
                                                    confirmButtonColor: 'blue',
                                                    })
                                                    </script>";
                                            } ?>
                                            <center><img src="../Foto/logo.png" alt="Logo_slink" class="logo1"></center>
                                            <h1 class="h3 mb-3 fw-normal">Login</h1>
                                            <form action="" method="POST">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
                                                    <label class="fw-normal" for="username">Username</label>
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                                                    <label class="fw-normal" for="password">Password</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                                    <label for="remember" class="form-check-label">Remember Me</label>
                                                </div>
                                                <div class="d-flex justify-content-around mt-3">
                                                    <a href="sendRecovery.php" class=" position-relative text-decoration-none " style="font-size: 14px;">Lupa Password?</a>
                                                    <a href="register.php" class=" position-relative text-decoration-none " style="font-size: 14px;">Register?</a>
                                                    <a href="verifikasi.php" class=" position-relative text-decoration-none " style="font-size: 14px;">Verifikasi?</a>
                                                </div>
                                                <div class="d-grid gap-2 col-6 mx-auto">
                                                    <br />
                                                    <button class="btn " id="login" name="login" type="submit">Login</button>
                                                </div>
                                            </form>
                                        </div>
                                    </main>
                                    <!--akhir login-->
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2 md-1">

                                    <img src="../Foto/login.png" alt="" width="550px">
                                </div>
                            </div>
                        </div>
                        <footer>
                            <div class="row">
                                <div class="col-lg-12 text-center ">
                                    <p class="pb-5"><small>Copyright &copy; Slink 2022</small></p>
                                </div>
                                <!-- /.col-lg-12 -->
                            </div>
                            <!-- /.row -->
                        </footer>
                    </div>
                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>


</html>