<?php
require "./function.php";

// Redirect Ke Halaman Login Ketika Belum Login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $user = queryGetData("SELECT id FROM users WHERE username ='$username' ");
    $this_id = $user[0]['id'];
}

$user_id = $_SESSION['user_id'];

if ($this_id == $user_id) {
    header("location: profile.php");
    exit;
}

// Get Data Profile
if (isset($this_id)) {

    $profile = getProfile($this_id);

    $this_nama = $profile[0]['nama'];
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


    $posts = getPostsByUser($this_id);
} else {
    header("location: ./home.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.2/font/bootstrap-icons.min.css" integrity="sha512-YzwGgFdO1NQw1CZkPoGyRkEnUTxPSbGWXvGiXrWk8IeSqdyci0dEDYdLLjMxq1zCoU0QBa4kHAFiRhUL3z2bow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Slink | User</title>
</head>
<!-- navigasi -->
<div class="animasi2">

    <?php include("./include/navbar.php"); ?>

    <main class="container-xl ">
        <!-- profil -->
        <section class="container shadow rounded bg-white ms-5 mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5 shadow-sm p-3 mb-5 bg-body rounded">
                        <!-- Foto -->
                        <?php echo $tag; ?>
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
                                    <div id='follower' class="col" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal_form_follows" data-id="<?= $this_id ?>">Follower <br><?= $count_follower; ?></div>
                                    <div id='following' class="col" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal_form_follows" data-id="<?= $this_id ?>">Following <br><?= $count_following; ?></div>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile</h4>
                        </div>
                        <table>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <tr>
                                        <td>
                                            <h5 class="fw-strong">Nama </h5>
                                        </td>
                                        <td>
                                            <h5 class="fw-normal">:<?= " " . $this_nama; ?></h5>
                                        </td>
                                    </tr>

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <tr>
                                        <td>
                                            <h5 class="fw-strong">Username </h5>
                                        </td>
                                        <td>
                                            <h5 class="fw-normal">:<?= " " . $username; ?></h5>
                                        </td>
                                    </tr>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <tr>
                                    <td>
                                        <h5 class="fw-strong">Bio </h5>
                                    </td>
                                    <td>:</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="col-md-12">
                                            <h5 class="fw-normal"><?= $bio; ?> </h5>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                        </table>
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
                                <?php $follow_condition = (checkFollows($this_id, $user_id)) ? "btn btn-outline-danger follow_button" : "btn btn-primary follow_button" ?>
                                <?php $follow_text_condition = (checkFollows($this_id, $user_id)) ? "Unfollow" : "Follow"; ?>
                                <button class="<?= $follow_condition; ?>" type="button" data-id="<?= $this_id ?>"><?= $follow_text_condition; ?></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Posts -->
        <section class="container rounded bg-white ms-5 mt-5 mb-5">
            <div class="row" id="posts">
                <?php if (count($posts) == 0) : ?>
                    <div class="d-flex justify-content-center mt-4"><img src="../Foto/kosong.png" alt=""></div>
                    <center>
                        <h3 class="">Posts Not Found!</h3>
                    </center>
                <?php endif; ?>
                <?php foreach ($posts as $post) : ?>
                    <?php $bookmarkCondition = (checkPostBookmarked($user_id, $post['id'])) ? 'bi bi-bookmark-fill text-primary fs-5 mx-1 bookmark_button' : 'bi bi-bookmark fs-5 mx-1 bookmark_button' ?>
                    <?php $likeCondition = (checkPostliked($user_id, $post['id'])) ? 'bi bi-heart-fill text-danger fs-5 mx-1 like_button' : 'bi bi-heart fs-5 mx-1 like_button' ?>
                    <div class="media border p-3 mb-3 shadow w-75 m-auto">
                        <div class="media-body">
                            <h2><a style="text-decoration: none;color:black" href="post.php?post_id=<?= $post['id']; ?>" target="_blank"><?= $post['judul']; ?></a>
                                <h2>
                                    <div class="d-flex">
                                        <h5><span style="color: #45625D;">by</span><a target="_blank" class="text-decoration-none text-reset" href="./user.php?username=<?= $post["username"]; ?>"><?= " " . $post["username"]; ?></a></h5>
                                        <h5 class="mx-4"><?= $post['waktu_aksi']; ?></h5>
                                    </div>
                                    <div class="ratio ratio-21x9 border  my-2 ">
                                    <iframe src="<?= $post["link"] ?>" title="sumber tautan" allowfullscreen></iframe>

                                </div>
                                    <a class="btn col-2 mt-1 mb-1 shadow" href="<?= $post["link"] ?>" style="background-color:#6aa5a9; color: white;" target="_blank">Go Link</a>
                                    <p class="mt-1 mb-1"><?= $post['deskripsi']; ?></p>
                                    <i class="<?= $likeCondition ?>" style="cursor:pointer;" data-id="<?= $post["id"] ?>"></i>
                                    <i class="bi bi-chat fs-5 mx-1 comment_button" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal_form" data-id="<?= $post['id'] ?>"></i>
                                    <i class="<?= $bookmarkCondition; ?>" style="cursor:pointer;" data-id="<?= $post["id"] ?>"></i>
                                    <i class="float-end fs-5 fw-normal"><?= $post['nama']; ?></i>
                                    <br>
                                    <span class="likes fs-5"><?= getPostLikes($post['id']); ?> Likes</span>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- Modal untuk Follower dan Following -->
    <div class="modal fade" id="modal_form_follows" tabindex="-1" aria-labelledby="modal_form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Follower</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-follows">

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

    <!-- Modal Form untuk Komentar-->
    <div class="modal fade" id="modal_form" tabindex="-1" aria-labelledby="modal_form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Comments</h5>
                    <div id="message"></div>
                    <button type="button" class="btn-close" id="close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/profile.js"></script>
    <script src="js/home.js"></script>
    <script src="js/sweetalert.js"></script>
    </body>

</html>