<?php
require "function.php";

//mengambil post berdasarkan category
if (isset($_GET['cat_title'])) {
    $temp = $_GET['cat_title'];

    $query = "SELECT * FROM posts WHERE post_cat = '$temp'";
    $select_post = queryGetData($query);





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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
        <link rel="stylesheet" href="../css/style3.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.2/font/bootstrap-icons.min.css" integrity="sha512-YzwGgFdO1NQw1CZkPoGyRkEnUTxPSbGWXvGiXrWk8IeSqdyci0dEDYdLLjMxq1zCoU0QBa4kHAFiRhUL3z2bow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <title>Slink | Home</title>
    </head>

    <body>

        <!-- Header Berisi Navbar -->
        <header class="animasi3">
            <?php
            include("./include/navbar.php");
            ?>
        </header>

        <!-- Page Content -->
        <div class="container">

            <div class="row">

                <!-- Blog Entries Column -->
                <div class="col-md-8">


                    <section class="container m-auto mt-3 m-auto p-3 w-50">
                        <!-- Form dan Tombol Cari -->
                        <form action="" method="POST">
                            <div class="input-group mb-3 mt-4 row">
                                <div class="col-9">
                                    <input type="text" class="form-control" placeholder="Cari Posts..." id="keyword" name="keyword" />
                                </div>
                                <div class="col-3">
                                    <button type="submit" class="btn btn-outline-success col-12" type="button" name="submit_search">Cari</button>
                                </div>
                            </div>
                        </form>

                        <!-- Posts Terbaru -->
                        <div class="row" id="new_posts">
                            <?php if (count($select_post) == 0) : ?>
                                <h3 class="d-flex justify-content-center mt-4">Posts Tidak Ditemukan</h3>
                            <?php endif; ?>
                            <?php foreach ($select_post as $post) : ?>
                                <div class="media border p-3 mb-3 shadow">
                                    <div class="media-body">
                                        <h2><?= $post['judul']; ?></h2>

                                        <?php
                                        //select username
                                        $username = $post['user_id'];

                                        $query_username = "SELECT * FROM users WHERE id = '$username' ";
                                        $select_username = mysqli_query($conn, $query_username);

                                        while ($row = mysqli_fetch_array($select_username)) {
                                        ?>

                                            <h5><span style="color: #45625D;">by</span><?= " " . $row["username"]; ?></h5>
                                            <a class="btn shadow" href="<?= $post["link"] ?>" style="background-color:#6aa5a9; color: white;" target="_blank">Go Link</a>
                                            <p class="mt-1 mb-1"><?= $post['deskripsi']; ?></p>
                                            <i <?php if (checkPostLiked($row['id'], $post['id'])) : ?> class="bi bi-heart-fill text-danger fs-5 mx-1 like_button" <?php else : ?> class="bi bi-heart fs-5 mx-1 like_button" <?php endif ?> data-id="<?= $post["id"] ?>"></i>
                                            <i class="bi bi-chat fs-5 mx-1 comment_button" data-bs-toggle="modal" data-bs-target="#modal_form" data-id="<?= $post['id'] ?>"></i>
                                            <i <?php if (checkPostBookmarked($row['id'], $post['id'])) : ?> class="bi bi-bookmark-fill text-primary fs-5 mx-1 bookmark_button" <?php else : ?> class="bi bi-bookmark fs-5 mx-1 bookmark_button" <?php endif ?> data-id="<?= $post["id"] ?>"></i>
                                            <br>

                                        <?php } ?>
                                        <span class="likes"><?= getPostLikes($post['id']); ?> Likes</span>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>

                        <div class="text-center">
                            <button class=" btn btn-outline-success btn-lg me-auto rounded-pill" id="button_seeMore" type="button" <?php if (count($post) < $_SESSION['limit']) : ?> style="display: none;" <?php endif;  ?>>See More</button>
                            <button class=" btn btn-outline-danger btn-lg me-auto rounded-pill" id="button_seeLess" type="button" <?php if ($_SESSION['limit'] == 5) : ?> style="display: none;" <?php endif;  ?>>See Less</button>
                        </div>
                    </section>

                    <footer>
                        <div class=" row">
                            <div class="col-lg-12 text-center mt-5">
                                <p><small>Copyright &copy; Slink 2022</small></p>
                            </div>
                        </div>
                    </footer>

                    <!-- Modal Form-->
                    <div class="modal fade" id="modal_form" tabindex="-1" aria-labelledby="modal_form" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modal_label">Komentar</h5>
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
                </div>
            <?php

        }
        include("./sidebar.php"); ?>


            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="js/home.js"></script>
    </body>

    </html>