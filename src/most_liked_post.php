<?php
// Import Function
require "function.php";

// Session untuk Limit Data Posts
if (!isset($_SESSION['limit'])) {
  $_SESSION['limit'] = 0;
}

// Redirect Ke Halaman Login Ketika Belum Login
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


// Handler Logout
if (isset($_GET['logout'])) {
  logout();
}

// Id User yang Login
$user_id = $_SESSION['user_id'];

// cek limit
if ($_SESSION['limit'] == 0) {
  $_SESSION['limit'] = 5;
}

// Ambil Data Posts Terbaru
// $posts = getPosts($_SESSION['limit']);

// Ambil Data Post Sesuai Keyword Pencarian
if (isset($_POST["submit_search"])) {
  $posts = searchPosts($_POST["keyword"]);
}

// Ambil Data Post Sesuai Category
if (isset($_POST['submit_category'])) {
  $posts = getPostsByCategory($_POST['cat_id']);
}

// Ambil data post sesuai like terbanyak
//$query = "SELECT a.*, b.post_id, count(b.user_id) FROM posts AS a INNER JOIN likes AS b WHERE b.post_id = a.id GROUP BY b.post_id ORDER BY count(b.user_id) DESC";
$query = "SELECT a.*, b.post_id, count(b.user_id), DENSE_RANK() OVER (ORDER BY COUNT(b.user_id) DESC) rank FROM posts AS a INNER JOIN likes AS b WHERE b.post_id = a.id GROUP BY b.post_id ORDER BY rank ASC";
$posts = queryGetData($query);

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

  <main class="row">
    <section class="container m-auto mt-3 p-3 w-50">
      <!-- Form dan Tombol Cari -->
      <form action="" method="POST">
        <div class="input-group mb-4 mt-3 row mx-2">
          <div class="col-1"></div>
          <div class="col-8">
            <input type="text" class="form-control" placeholder="Cari Posts..." id="keyword" name="keyword" />
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-outline-success col-12" type="button" name="submit_search">Cari</button>
          </div>
        </div>
      </form>


      <!-- Posts Terbaru -->
      <div class="row" id="new_posts">
        <?php if (count($posts) == 0) : ?>
          <div class="d-flex justify-content-center mt-4"><img src="../Foto/kosong.png" alt=""></div>
          <center>
            <h3 class="">Posts Tidak Ditemukan!</h3>
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

                    <?php
                    //ambil username
                    $query = "SELECT username FROM users WHERE id = $user_id";
                    $get_username = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($get_username)) {
                      $username = $row['username'];
                    }

                    ?>

                    <h5><span style="color: #45625D;">by</span><a target="_blank" class="text-decoration-none text-reset" href="./user.php?username=<?= $username ?>"><?= " " .  $username; ?></a></h5>
                    <h5 class="mx-4"><?= $post['waktu_aksi']; ?></h5>
                  </div>
                  <a class="btn col-3 mt-1 mb-1 shadow" href="<?= $post["link"] ?>" style="background-color:#6aa5a9; color: white;" target="_blank">Go Link</a>
                  <p class="mt-1 mb-1"><?= $post['deskripsi']; ?></p>
                  <i class="<?= $likeCondition ?>" style="cursor:pointer;" data-id="<?= $post["id"] ?>"></i>
                  <i class="bi bi-chat fs-5 mx-1 comment_button" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal_form" data-id="<?= $post['id'] ?>"></i>
                  <i class="<?= $bookmarkCondition; ?>" style="cursor:pointer;" data-id="<?= $post["id"] ?>"></i>

                  <?php
                  //ambil nama category
                  $cat_id = $post['cat_id'];

                  $query = "SELECT nama FROM category WHERE id = $cat_id";
                  $get_cat = mysqli_query($conn, $query);

                  while ($row = mysqli_fetch_assoc($get_cat)) {
                    $cat = $row['nama'];
                  }

                  ?>

                  <i class="float-end fs-5 fw-normal"><?= $cat; ?></i>
                  <br>
                  <span class="likes fs-5"><?= getPostLikes($post['id']); ?> Likes</span>
            </div>
          </div>

        <?php endforeach; ?>
      </div>

      <div class="text-center">
        <button class=" btn btn-outline-success btn-lg me-auto rounded-pill" id="button_seeMore" type="button" <?php if (count($posts) < $_SESSION['limit']) : ?> style="display: none;" <?php endif;  ?>>See More</button>
        <button class=" btn btn-outline-danger btn-lg me-auto rounded-pill" id="button_seeLess" type="button" <?php if ($_SESSION['limit'] == 5) : ?> style="display: none;" <?php endif;  ?>>See Less</button>
      </div>
    </section>

    <!-- Sidebar -->
    <?php include('./include/sidebar.php') ?>
  </main>
  <footer>
    <div class=" row">
      <div class="col-lg-12 text-center mt-5">
        <p><small>Copyright &copy; Slink 2022</small></p>
      </div>
    </div>
  </footer>

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


  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="js/home.js"></script>
  <script src="js/profile.js"></script>
</body>

</html>