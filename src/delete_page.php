<?php
// ini_set("display_errors", 0);

require "function.php";

ob_start();

// Redirect Ke Halaman Login Ketika Belum Login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$validation_text = "Saya Menyetujui";


if (isset($_POST['delete_user'])) {
    $deleteStatus = deleteAccount($user_id, $_POST['text'], $validation_text);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style2.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <title>Slink | Delete Account</title>
</head>

<body>
    <main class="animasi">
        <div class="login border shadow p-3 mb-1 bg-body rounded-5 position-relative">
            <center><img src="../Foto/logo.png" alt="Logo_slink" class="logo1"></center>
            <h1 class="h3 mb-3 fw-normal">Delete Account</h1>
            <?php if (isset($deleteStatus["error_kalimat"])) {
                echo $deleteStatus["error_kalimat"];
                echo "  <script>
                          Swal.fire({
                          icon: 'error',
                          title: 'Kalimat Tidak Sesuai!',
                          text: 'Masukan Kalimat yang Sesuai/Identik dengan Arahan yang Diberikan',
                          confirmButtonText: 'Ulangi',
                          confirmButtonColor: 'blue',
                        })
                        </script>";
            } ?>
            <form id="form_hapus_user" action="" method="POST">
                <h3 class="mb-3 font-weight-bold">Ketikan &nbsp <strong class="fw-bold">"<?php echo $validation_text; ?>"</strong></h3>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="text" name="text" required />
                    <label class="fw-normal" for="username">Masukan kalimat</label>
                </div>
                <div class="row d-grid gap-2 col-6 mx-auto">
                    <br />
                    <button class="btn btn-outline-danger visually-hidden" id="delete_user" name="delete_user" type="submit">Hapus Akun</button>
                    <button class="btn btn-outline-danger" id="delete_user_trigger" name="delete_user_trigger" type="click">Hapus Akun</button>
                    <h4 class="text-center"><a href="home.php" class="text-decoration-none"><small>Kembali</small></a></h4>
            </form>
        </div>
    </main>
    <!--akhir login-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="js/sweetalert.js"></script>
</body>

</html>