<?php

// Import Function
require "function.php";


// Redirect Ke Halaman Login Ketika Belum Login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id']; // sementara

// Handler Logout
if (isset($_GET['logout'])) {
    logout();
}

// Handler Tombol Insert Data Post
if (isset($_POST["submit_createPost"])) {

    // Eksekusi Create Post
    $postStatus = createPost($_POST);
}

// Handler Tombol Update Data Post
if (isset($_POST["submit_updatePost"])) {

    // Eksekusi Update Post
    $postStatus = updatePost($_POST);
}

// Handler Tombol Delete Data Post
if (isset($_GET["delete_id"])) {
    $postStatus = deletePost($_GET["delete_id"]);
}

// Ambil Data Post untuk Ditampilkan
$posts = getPostsByUser($user_id);

// Ambil Data Post Sesuai Keyword Pencarian
if (isset($_POST["submit_search"])) {
    $posts = searchPostsPrivate($_POST["keyword"], $user_id);
}

// Ambil Data Category
$category = queryGetData("SELECT * FROM category");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../css/style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.2/font/bootstrap-icons.min.css" integrity="sha512-YzwGgFdO1NQw1CZkPoGyRkEnUTxPSbGWXvGiXrWk8IeSqdyci0dEDYdLLjMxq1zCoU0QBa4kHAFiRhUL3z2bow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Slink | Your Posts</title>
</head>

<body>
    <header class="animasi3">
        <?php
        include("./include/navbar.php");
        ?>
        <a class="navbar-brand p-2 text-white" href="./cms.php?logout=<?= true ?>" id="logout">
            <h3>Log Out</h3>
        </a>
        </nav>
    </header>

    <main class="animasi3">

        <main class="container shadow p-3 mb-5 bg-body rounded m-auto mt-5">
            <div class="row mb-2 d-flex">
                <!-- Tombol Trigger Modal untuk Insert/Tambah Data -->
                <div class="col-3">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal_form" id="trigger_createPost">+ Tambah Post</button>
                </div>
                <div class="col-6 justify-content-center">
                    <!-- Info Error -->
                    <?php if (isset($postStatus["error_space"])) {
                        echo $postStatus["error_space"];
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
                    <?php if (isset($postStatus["error_link"])) {
                        echo $postStatus["error_link"];
                        echo "  <script>
                          Swal.fire({
                          icon: 'error',
                          title: 'URL Tidak Valid!',
                          text: 'Silahkan Masukan URL Dengan Format yang Benar Http/Https/Localhost DLL',
                          confirmButtonText: 'Ulangi',
                          confirmButtonColor: 'blue',
                        })
                        </script>";
                    } ?>
                    <?php if (isset($postStatus["success_create"])) {
                        echo $postStatus["success_create"];
                        echo "  <script>
                          Swal.fire({
                          icon: 'success',
                          title: 'Post Berhasil Dibuat!',
                          text: 'Ayo Buat Lebih Banyak Post',
                          confirmButtonText: 'OK',
                          confirmButtonColor: 'blue',
                        })
                        </script>";
                    } ?>
                    <?php if (isset($postStatus["success_update"])) {
                        echo $postStatus["success_update"];
                        echo "  <script>
                          Swal.fire({
                          icon: 'success',
                          title: 'Post Berhasil Diupdate!',
                          text: 'Ayo Buat Post Sesempurna Mungkin',
                          confirmButtonText: 'OK',
                          confirmButtonColor: 'blue',
                        })
                        </script>";
                    } ?>
                    <?php if (isset($postStatus["success_delete"])) {
                        echo $postStatus["success_delete"];
                        echo "  <script>
                          Swal.fire({
                          icon: 'success',
                          title: 'Post Berhasil Dihapus!',
                          text: 'Tetap Semangat Bikin Post Ya',
                          confirmButtonText: 'OK',
                          confirmButtonColor: 'blue',
                        }).then((result) => {
                            if(result.isConfirmed){
                                document.location.href='./cms.php';
                            }
                        });
                        </script>";
                    } ?>
                </div>
            </div>

            <!-- Form dan Tombol Cari -->
            <form action="" method="POST">
                <div class="input-group mb-3 mt-4 col-4 row">
                    <div class="col-4">
                        <input type="text" class="form-control" placeholder="Cari Posts..." id="keyword" name="keyword" />
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-outline-success col-4" type="button" name="submit_search">Cari</button>
                    </div>
                </div>
            </form>



            <!-- Card Menampilkan Data-->
            <section class="row" id="list_posts">
                <?php if (count($posts) == 0) : ?>
                    <div class="d-flex justify-content-center mt-4"><img src="../Foto/kosong.png" alt=""></div>
                    <center>
                        <h3 class="">Posts Tidak Ditemukan</h3>
                    </center>
                <?php endif; ?>
                <?php foreach ($posts as $post) : ?>
                    <?php $likeCondition = (checkPostliked($user_id, $post['id'])) ? 'bi bi-heart-fill text-danger fs-6 like_button' : 'bi bi-heart fs-6  text-danger like_button' ?>
                    <div class="col-sm-4 mb-3">
                        <div class="card">
                            <di class="card-body">
                                <div class="row mb-3">
                                    <h7 class="col-8"><?= $post['waktu_aksi']; ?></h7>
                                    <h7 class="col-4 text-center"><?= $post['nama']; ?></h7>
                                </div>
                                <h5 class="card-title"><?= $post['judul']; ?></h5>
                                <p class="card-text"><?= $post['deskripsi']; ?></p>
                                <i class="<?= $likeCondition ?>" style="cursor:pointer; color:red;" data-id="<?= $post["id"] ?>"></i>
                                <i class="bi bi-chat fs-6 text-primary mx-2 comment_button" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal_form_comments" data-id="<?= $post['id'] ?>"></i>
                                <br>
                                <span class="likes fs-6"><?= getPostLikes($post['id']); ?> Likes</span>
                                <div class="row mt-2">
                                    <a class="btn btn-primary col-5" href="<?= $post['link']; ?>" target="_blank">Go Link</a>
                                    <div class="col-1"></div>
                                    <div class="d-grid gap-2 d-md-flex col-4">
                                        <button class="btn btn-outline-danger trigger_deletePost " type="button" data-id="<?= $post['id'] ?>">Hapus</button>
                                        <button class="btn btn-outline-success  trigger_updatePost" type=" button" data-bs-toggle="modal" data-bs-target="#modal_form" data-id="<?= $post['id'] ?>">Update</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                    </div>
                <?php endforeach; ?>
            </section>


            <!-- Modal Form Inputan-->
            <div class="modal fade" id="modal_form" tabindex="-1" aria-labelledby="modal_form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal_label">Tambah Data Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="POST">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                            <div class="modal-body" id="modal_input">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control form-control-sm" id="judul" name="judul" placeholder="Judul" required />
                                    <label for="judul">Judul</label>
                                </div>
                                <div class="form-floating mb-2">
                                    <textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" placeholder="Deskripsi" required></textarea>
                                    <label for="deskripsi">Deskripsi</label>
                                </div>

                                <input type="text" list="list_category" id="category" name="category" placeholder="Pilih Category..." class="form-control mb-2" />
                                <datalist id="list_category">
                                    <?php foreach ($category as $cat) : ?>
                                        <option value="<?= $cat['nama']; ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>

                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control form-control-sm" id="link" name="link" placeholder="Link" required />
                                    <label for="link">Link</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-primary" id="modal_button">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Form Komentar -->
            <div class="modal fade" id="modal_form_comments" tabindex="-1" aria-labelledby="modal_form" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal_label">Comments</h5>
                            <div id="message"></div>
                            <button type="button" class="btn-close" id="close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_comments">
                            <!-- Komentar-->
                        </div>
                        <hr>
                        <div class="mb-5">
                            <form action="" method="POST" id="comment_form">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="post_id" id="post_id">
                                <input type="hidden" name="parent_comment_id" id="parent_comment_id" value="0">
                                <input type="hidden" name="submit_comment">
                                <div class="row mb-2 mx-1">
                                    <div class="col-8">
                                        <textarea class="form-control form-control-sm" id="comment" name="comment" placeholder="Tulis comment..." required></textarea>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-outline-primary" name="button_submit_comment">Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </main>

        <footer>
            <div class="row">
                <div class="col-lg-12 text-center mt-5">
                    <p><small>Copyright &copy; Slink 2022</small></p>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="js/cms.js"></script>
        <script src="js/cms2.js"></script>
        <script src="js/sweetalert.js"></script>
</body>

</html>