<?php
require "./function.php";

ob_start();

$user_id = $_SESSION['user_id'];

// Default Rank
$rankTable = "ranklikes";
$rankLabel = "Likes";

if (isset($_POST["sort_likes"])) {
    $rankTable = "ranklikes";
    $rankLabel = "Likes";
}

if (isset($_POST["sort_posts"])) {
    $rankTable = "rankposts";
    $rankLabel = "Posts";
}

if (isset($_POST["sort_followers"])) {
    $rankTable = "rankfollow";
    $rankLabel = "Followers";
}

if (isset($_POST["sort_comments"])) {
    $rankTable = "rankcm";
    $rankLabel = "Comments";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style4.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Slink | Leaderboard</title>
</head>

<body>
    <!-- Header Berisi Navbar -->
    <header class="animasi3">
        <?php
        include("./include/navbar.php");
        ?>
    </header>

    <!-- Rank Likes -->
    <section class="main-content">

        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 d-flex justify-content-start">
                        <h1 class="">Top <?= $rankLabel; ?></h1>

                        <div class="dropdown">
                            <button class="dropbtn text-dark"><img src="../Foto/arrow.svg" alt=""></button>
                            <div class="dropdown-content">
                                <form action="" method="POST">
                                    <button type="submit" class="btn btn-light" name="sort_likes">Likes</button>
                                </form>
                                <form action="" method="POST">
                                    <button type="submit" class="btn btn-light" name="sort_followers">Followers</button>
                                </form>
                                <form action="" method="POST">
                                    <button type="submit" class="btn btn-light" name="sort_posts">Posts</button>
                                </form>
                                <form action="" method="POST">
                                    <button type="submit" class="btn btn-light" name="sort_comments">Comments</button>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <br>
            <br>
            <div class="row">
                <?php
                // ambil data
                $rankUser = queryGetData("Select user_id from $rankTable LIMIT 3");
                if (sizeof($rankUser) > 0) {
                    $idRank1 = $rankUser[0]["user_id"];
                    $rank1 = leaderboard($idRank1);

                    $foto1 = $rank1[0]['foto'];
                    if ($foto1 == "" || empty($foto1) || $foto1 == null) {
                        $tag1 = "<img class='circle-img mb-2' width='150px' src='../Foto/user.png'><span class=' font-weight-bold'>$foto1</span>";
                    } else {
                        $tag1 = "<img class='circle-img mb-2' width='auto' height='auto'src='../Foto/$foto1'>";
                    }

                    if (sizeof($rankUser) > 1) {
                        $idRank2 = $rankUser[1]["user_id"];
                        $rank2 = leaderboard($idRank2);

                        $foto2 = $rank2[0]['foto'];
                        if ($foto2 == "" || empty($foto2) || $foto2 == null) {
                            $tag2 = "<img class='circle-img mb-2' width='150px' src='../Foto/user.png'><span class=' font-weight-bold'>$foto2</span>";
                        } else {
                            $tag2 = "<img class='circle-img mb-2' width='auto' height='auto'src='../Foto/$foto2'>";
                        }

                        if (sizeof($rankUser) > 2) {
                            $idRank3 = $rankUser[2]["user_id"];
                            $rank3 = leaderboard($idRank3);

                            $foto3 = $rank3[0]['foto'];
                            if ($foto3 == "" || empty($foto3) || $foto3 == null) {
                                $tag3 = "<img class='circle-img mb-2' width='150px' src='../Foto/user.png'><span class=' font-weight-bold'>$foto3</span>";
                            } else {
                                $tag3 = "<img class='circle-img mb-2' width='auto' height='auto'src='../Foto/$foto3'>";
                            }
                        }
                    }
                }
                ?>

                <!-- rank 2 -->
                <?php if (isset($rank2)) : ?>
                    <div class=" col-sm-4">
                        <div class="rank leaderboard-card">
                            <div class="leaderboard-card__top">
                                <h3 class="text-center">2</h3>
                            </div>
                            <div class="leaderboard-card__body">
                                <div class="text-center">
                                    <?php echo $tag2; ?>
                                    <a href="./user.php?username=<?= $rank2[0]['username'] ?>" target="_blank" class="text-reset text-decoration-none">
                                        <h5 class="mb-0"><?php echo $rank2[0]['username']; ?></h5>
                                    </a>
                                    <hr>
                                    <div class="row">
                                        <div class="col md-1" style="font-size: 12px;">Likes</div>
                                        <div class="col md-1" style="font-size: 12px;">Followers</div>
                                        <div class="col md-1" style="font-size: 12px;">Posts</div>
                                        <div class="col md-1" style="font-size: 12px;">Comments</div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><?php echo $rank2[0]['count_likes']; ?></div>
                                        <div class="col"><?php echo $rank2[0]['count_follower']; ?></div>
                                        <div class="col"><?php echo $rank2[0]['count_posts']; ?></div>
                                        <div class="col"><?php echo $rank2[0]['count_comments']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- rank 1 -->
                <?php if (isset($rank1)) : ?>
                    <div class=" col-sm-4">
                        <div class="rank leaderboard-card leaderboard-card--first">
                            <div class="leaderboard-card__top">
                                <h3 class="text-center">1</h3>
                            </div>
                            <div class="leaderboard-card__body">
                                <div class="text-center">
                                    <?php echo $tag1; ?>
                                    <a href="./user.php?username=<?= $rank1[0]['username'] ?>" target="_blank" class="text-reset text-decoration-none">
                                        <h5 class="mb-0"><?php echo $rank1[0]['username']; ?></h5>
                                    </a>
                                    <hr>
                                    <div class="row">
                                        <div class="col md-1" style="font-size: 12px;">Likes</div>
                                        <div class="col md-1" style="font-size: 12px;">Followers</div>
                                        <div class="col md-1" style="font-size: 12px;">Posts</div>
                                        <div class="col md-1" style="font-size: 12px;">Comments</div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><?php echo $rank1[0]['count_likes']; ?></div>
                                        <div class="col"><?php echo $rank1[0]['count_follower']; ?></div>
                                        <div class="col"><?php echo $rank1[0]['count_posts']; ?></div>
                                        <div class="col"><?php echo $rank1[0]['count_comments']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- rank 3 -->
                <?php if (isset($rank3)) : ?>
                    <div class="col-sm-4">
                        <div class="rank leaderboard-card">
                            <div class="leaderboard-card__top">
                                <h3 class="text-center">3</h3>
                            </div>
                            <div class="leaderboard-card__body">
                                <div class="text-center">
                                    <?php echo $tag3; ?>
                                    <a href="./user.php?username=<?= $rank3[0]['username'] ?>" target="_blank" class="text-reset text-decoration-none">
                                        <h5 class="mb-0"><?php echo $rank3[0]['username']; ?></h5>
                                    </a>
                                    <hr>
                                    <div class="row">
                                        <div class="col md-1" style="font-size: 12px;">Likes</div>
                                        <div class="col md-1" style="font-size: 12px;">Followers</div>
                                        <div class="col md-1" style="font-size: 12px;">Posts</div>
                                        <div class="col md-1" style="font-size: 12px;">Comments</div>
                                    </div>
                                    <div class="row">
                                        <div class="col"><?php echo $rank3[0]['count_likes']; ?></div>
                                        <div class="col"><?php echo $rank3[0]['count_follower']; ?></div>
                                        <div class="col"><?php echo $rank3[0]['count_posts']; ?></div>
                                        <div class="col"><?php echo $rank3[0]['count_comments']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- All User -->
                <h4>All Users</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Likes</th>
                            <th>Followers</th>
                            <th>Posts</th>
                            <th>Comments</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $userRankList = queryGetData("select user_id from $rankTable");
                        if (isset($idRank1)) {
                            $userRankList = queryGetData("select user_id from $rankTable where user_id not in($idRank1)");
                        }
                        if (isset($idRank2)) {
                            $userRankList = queryGetData("select user_id from $rankTable where user_id not in($idRank1, $idRank2)");
                        }
                        if (isset($idRank3)) {
                            $userRankList = queryGetData("select user_id from $rankTable where user_id not in($idRank1, $idRank2, $idRank3)");
                        }
                        ?>
                        <?php foreach ($userRankList as $user) : ?>
                            <?php


                            $rank = leaderboard($user["user_id"]);
                            $id = $rank[0]['id'];
                            $username = $rank[0]['username'];
                            $foto = $rank[0]['foto'];
                            $count_posts = $rank[0]['count_posts'];
                            $count_likes = $rank[0]['count_likes'];
                            $count_follower = $rank[0]['count_follower'];
                            $count_comments = $rank[0]['count_comments'];
                            $rank_likes = $rank[0]['rank_like'];
                            $rank_posts  = $rank[0]['rank_posts'];
                            $rank_follow  = $rank[0]['rank_follow'];
                            $rank_cm  = $rank[0]['rank_cm'];
                            if ($foto == "" || empty($foto) || $foto == null) {
                                $tag = "<img class='circle-img circle-img--small mr-2' width='auto' src='../Foto/user.png'><span class=' font-weight-bold'>$foto</span>";
                            } else {
                                $tag = "<img class='circle-img circle-img--small mr-2' width='auto' height='auto'src='../Foto/$foto'>";
                            }
                            ?>
                            <?php $followCondition = (checkFollows($user['user_id'], $user_id)) ? "<button type='button' class='btn btn-outline-danger btn-sm follow_button' data-id='" . $user['user_id'] . "'>Unfollow</button>" : "<button type='button' class='btn btn-primary btn-sm follow_button' data-id='" . $user['user_id'] . "'>Follow</button>"; ?>
                            <tr class="rank">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php echo $tag; ?>
                                        <div class="user-info__basic">
                                            <a href="./user.php?username=<?= $username ?>" target="_blank" class="text-reset text-decoration-none">
                                                <h5 class="mb-0"><?php echo $username; ?></h5>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <div class="d-flex align-items-baseline">
                                    <td>
                                        <h4 class="mr-5"><?php echo $count_likes; ?></h4>
                                    <td>
                                        <h4 class="mr-1"><?php echo $count_follower; ?></h4>
                                    </td>
                                    <td>
                                        <h4 class="mr-5"><?php echo $count_posts; ?></h4>
                                    </td>
                                    <td>
                                        <h4 class="mr-1"><?php echo $count_comments; ?></h4>
                                    </td>
                                    <td>
                                        <?= $followCondition; ?>
                                    </td>
                                </div>
                            </tr>
                        <?php endforeach; ?>
                        <?php
                        ?>
                    </tbody>
                </table>
            </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous">
    </script>
    <script src="js/profile.js"></script>
    <script src="js/sweetalert.js"></script>

</body>

</html>