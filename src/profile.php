<?php
require "./function.php";

// Redirect Ke Halaman Login Ketika Belum Login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// ob_start();

$user_id = $_SESSION['user_id'];

// Get Data Profile
if (isset($user_id)) {

    // Update Profile
    if (isset($_POST['update_prof'])) {
        $profileStatus = updateProfile($_POST, $_FILES, $user_id);
    }

    // Hapus Akun
    if (isset($_POST['delete'])) {
        header("location: ./delete_page.php");
    }

    // Data Profile
    $profile = getProfile($user_id);

    $id = $profile[0]['id'];
    $nama = $profile[0]['nama'];
    $username = $profile[0]['username'];
    $foto = $profile[0]['foto'];
    $bio = $profile[0]['bio'];
    $date = $profile[0]['waktu_bergabung'];
    $count_posts = $profile[0]['count_posts'];
    $count_likes = $profile[0]['count_likes'];
    $count_follower = $profile[0]['count_follower'];
    $count_following = $profile[0]['count_following'];

    if ($foto == "" || empty($foto) || $foto == null) {
        $tag = "<img class='rounded-circle mt-5' width='150px' src='../Foto/user.png'><span class=' font-weight-bold'>$foto</span>";
    } else {
        $tag = "<img class='rounded-circle mt-5' width='150px' height='150px'src='../Foto/$foto'><span class=' font-weight-bold'>$foto</span>";
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="../css/style.css" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.2/font/bootstrap-icons.min.css" integrity="sha512-YzwGgFdO1NQw1CZkPoGyRkEnUTxPSbGWXvGiXrWk8IeSqdyci0dEDYdLLjMxq1zCoU0QBa4kHAFiRhUL3z2bow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="../css/style4.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Slink | Profile</title>
</head>
<!-- navigasi -->
<div class="animasi2">

    <?php include("./include/navbar.php"); ?>

    <!-- profil -->
    <div class="container-xl ">
        <form class="profil " action="" method="post" enctype="multipart/form-data">
            <div class="container rounded bg-white shadow ms-5 mt-5 mb-5">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5 shadow-sm p-3 mb-5 bg-body rounded">
                            <!-- Foto -->
                            <?php echo $tag; ?>
                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">Your Avatar</label>
                                <input class="form-control form-control-sm" name="image" id="formFileSm" type="file">
                            </div>
                            <br>
                            <span>
                                <div class="row">
                                    <div class="col">
                                        Post <br> <?= $count_posts; ?>
                                    </div>
                                    <div class="col">
                                        Like <br> <?= $count_likes; ?>
                                    </div>
                                    <div class="row mt-3 d-flex justify-content-center">
                                        <div id='follower' class="col" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal_form" data-id="<?= $id ?>">Follower
                                            <br><?= $count_follower; ?>
                                        </div>
                                        <div id='following' class="col" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal_form" data-id="<?= $id ?>">Following
                                            <br><?= $count_following; ?>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <?php if (isset($profileStatus["error_space"])) {
                                echo $profileStatus["error_space"];
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
                            <?php if (isset($profileStatus["error_space2"])) {
                                echo $profileStatus["error_space2"];
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
                            <?php if (isset($profileStatus["error_username"])) {
                                echo $profileStatus["error_username"];
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
                            <?php if (isset($profileStatus["success"])) {
                                echo $profileStatus["success"];
                                echo "  <script>
                                    Swal.fire({
                                    icon: 'success',
                                    title: 'Profile Berhasil Diupdate!',
                                    text: 'Ayo Aktif Update Profile',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: 'blue',
                                    })
                                    </script>";
                            } ?>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Profile Settings</h4>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Nama</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php echo $nama; ?>">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="labels">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <label for="floatingTextarea">Bio</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="bio" placeholder="Masukan Bio" id="floatingTextarea"><?php echo $bio; ?></textarea>
                                </div>
                            </div>
                            <div class="mt-5 text-center"></div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="p-3 py-5">
                            <br><br>
                            <div class="col-md-12"><label class="labels">Waktu Bergabung</label><br>
                                <span class="fs-3"><?php echo $date; ?></span>
                                <br><br>
                                <div class=" col-md-12">
                                    <button class="btn btn-success profile-button" name="update_prof" type="submit">Save
                                        Profile</button>
                                    <button class="btn btn-danger profile-button" name="delete" type="submit">Hapus
                                        Akun</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <button class="btn btn-outline-danger profile-button" type="button"><a href="./transfer.php" class="text-reset text-decoration-none">Transfer Data
                                        Akun</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal untuk Follower dan Following -->

    <div class="modal fade" id="modal_form" tabindex="-1" aria-labelledby="modal_form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Follower</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onClick="document.location.reload()"></button>
                </div>
                <div class="modal-body">

                    <!-- <div class="card mb-2">
                        <div class="card-body d-flex">
                            <a target="_blank" href="./user.php?user_id=" class="row text-decoration-none text-reset">
                                <div class="col-2">
                                    <img class="rounded-circle shadow-1-strong me-3" src="../Foto/Jonggun no glass.jpg" alt="avatar" width="50" height="50" />
                                </div>
                                <h6 class="col-4">Greyssdaddasdsa</h6>
                                <div class="col-2">
                                    <h7 class="text-center bi bi-heart-fill text-danger"></h7>
                                    <span class="mx-1">12</span>
                                </div>
                                <div class="col-2 ">
                                    <h7 class="text-center bi bi-card-heading text-primary"></h7>
                                    <span class="mx-1">12</span>
                                </div>
                            </a>
                            <button class="btn btn-primary btn follow_button">Follow</button>
                        </div>
                    </div> -->


                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="js/profile.js"></script>
    <script src="js/sweetalert.js"></script>
    </body>

</html>