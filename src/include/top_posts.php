<?php
// Ambil Data Posts 10-Terbaik(Berdasarkan Like)
$top_posts = getTopPosts();

?>


<?php foreach ($top_posts as $post) : ?>
<div class="item" style="width: 670px ;">
    <?php $bookmarkCondition = (checkPostBookmarked($user_id, $post['id'])) ? 'bi bi-bookmark-fill text-primary fs-5 mx-1 bookmark_button' : 'bi bi-bookmark fs-5 mx-1 bookmark_button' ?>
    <?php $likeCondition = (checkPostliked($user_id, $post['id'])) ? 'bi bi-heart-fill text-danger fs-5 mx-1 like_button' : 'bi bi-heart fs-5 mx-1 like_button' ?>
    <div class="media border p-3 mb-3 shadow w-75 m-auto">
        <div class="media-body mb-2">
            <h2><a style="font-size: 25px; text-decoration: none;color:black"
                    href="post.php?post_id=<?= $post['id']; ?>" target="_blank"><?= $post['judul']; ?></a>
                <h2>
                    <div class="d-flex justify-content-between">
                        <h5><span style="color: #45625D;">by</span><a target="_blank"
                                class="text-decoration-none text-reset"
                                href="./user.php?username=<?= $post["username"]; ?>"><?= " " . $post["username"]; ?></a>
                        </h5>
                        <h5 class="mx-4" style="font-size: 12px;"><?= $post['waktu_aksi']; ?></h5>
                    </div>
                    <div class="ratio ratio-21x9 border  my-2 ">
                        <iframe src="<?= $post["link"] ?>" title="sumber tautan" allowfullscreen></iframe>

                    </div>
                    <a class="btn col-3 mt-1 mb-1 shadow" href="<?= $post["link"] ?>"
                        style="background-color:#6aa5a9; color: white;" target="_blank">Go Link</a>
                    <!-- <p class="mt-1 mb-1"><?= $post['deskripsi']; ?></p>
                    <i class="<?= $likeCondition ?>" style="cursor:pointer;" data-id="<?= $post["id"] ?>"></i>
                    <i class="bi bi-chat fs-5 mx-1 comment_button" style="cursor:pointer;" data-bs-toggle="modal"
                        data-bs-target="#modal_form" data-id="<?= $post['id'] ?>"></i>
                    <i class="<?= $bookmarkCondition; ?>" style="cursor:pointer;" data-id="<?= $post["id"] ?>"></i>
                    <i class="float-end fs-5 fw-normal"><?= $post['nama']; ?></i>
                    <br>
                    <span class="likes fs-5"><?= getPostLikes($post['id']); ?> Likes</span> -->
        </div>
    </div>
</div>
<?php endforeach; ?>