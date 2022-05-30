<?php
require "function.php";
ob_start();

//mengambil post berdasarkan category
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $user_id = $_SESSION['user_id'];

    $posts = queryGetData("CALL getPostById($post_id)");
}




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

    <!-- Navigation -->
    <?php include("./include/navbar.php"); ?>

    <!-- Page Content -->
    <div class="container m-auto mt-3 w-50">
        <div class="row">
            <!-- Posts-->
            <div id="post">
                <?php foreach ($posts as $post) : ?>

                    <?php
                    $foto = $post['foto'];

                    if ($foto == "" || empty($foto) || $foto == null) {
                        $tag = "<img class='rounded-circle shadow-1-strong me-3' src='../Foto/user.png' alt='avatar' width='65' height='65' />";
                    } else {
                        $tag = "<img class='rounded-circle shadow-1-strong me-3' src='../Foto/$foto' alt='avatar' width='65' height='65' />";
                    }


                    ?>

                    <div class="media border pl-3 pt-3 pb-3 pr-5 mb-3 shadow">
                        <div class='card'>
                            <div class="media-body p-5 mr-5">
                                <h2><?= $post['judul']; ?></h2>
                                <?= $tag ?>
                                <div class="media-body">
                                    <h4><?= $post['username']; ?><small> - <small><?= $post['waktu_aksi']; ?></small></small></h4>
                                    <p><?= $post['deskripsi']; ?></p>
                                </div>

                                <a class="btn shadow mb-3" href="<?= $post["link"] ?>" style="background-color:#6aa5a9; color: white;" target="_blank">Go Link</a><br>
                                <i <?php if (checkPostLiked($user_id, $post['id'])) : ?> class="bi bi-heart-fill text-danger fs-5 mx-1 like_button" <?php else : ?> class="bi bi-heart fs-5 mx-1 like_button" <?php endif ?> data-id="<?= $post["id"] ?>"></i>
                                <i <?php if (checkPostBookmarked($user_id, $post['id'])) : ?> class="bi bi-bookmark-fill text-primary fs-5 mx-1 bookmark_button" <?php else : ?> class="bi bi-bookmark fs-5 mx-1 bookmark_button" <?php endif ?> data-id="<?= $post["id"] ?>"></i>
                                <br>

                                <span class="likes"><?= getPostLikes($post['id']); ?> Likes</span>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>



            <div class="row">
                <div class="media border pl-3 pt-3 pb-3 pr-5 mb-3 shadow">
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="" method="POST" id="comment_form">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="post_id" id="post_id" value="<?= $post_id ?>">
                                <input type="hidden" name="parent_comment_id" id="parent_comment_id" value="0">
                                <input type="hidden" name="submit_comment">

                                <textarea class="form-control form-control-sm mb-2" id="comment" name="comment" placeholder="Tulis comment..." required></textarea>

                                <button type="submit" class="btn btn-primary mb-5" name="button_submit_comment">Comment</button>

                            </form>

                            <div class="mt-3 mb-3" id="comments">
                                <div class="col">
                                    <div class="d-flex flex-start">
                                        <img class="rounded-circle shadow-1-strong me-3" src="../Foto/dhafin.jpg" alt="avatar" width="65" height="65" />
                                        <div class="flex-grow-1 flex-shrink-1">
                                            <div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="mb-1">
                                                        GFreys <span class="small">- 12-02-2022</span>
                                                    </p>
                                                </div>
                                                <p class="small mb-0">
                                                    Hay
                                                </p>
                                                <button type="button" name="reply" class="btn btn-primary btn-sm text-white reply" id="1">Reply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class=" row">
            <div class="col-lg-12 text-center mt-5">
                <p><small>Copyright &copy; Slink 2022</small></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="js/post.js"></script>
</body>

</html>