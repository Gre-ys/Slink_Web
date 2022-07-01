<?php
//mengambil judul category
$category = getCategory();

// Handler Tombol Insert Data Post
if (isset($_POST["submit_chat"])) {
    // Eksekusi Create chat
    $postStatus = createChat($_POST);
}

?>

<div class="col-md-4">

    <!-- Blog Categories Well -->
    <div class="well-lg mt-5 border p-5 shadow p-3 mb-5 bg-white rounded w-75">
        <h4>Kategori</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php foreach ($category as $cat) : ?>
                        <form action="home.php" method="POST">
                            <input type="hidden" name="cat_id" value="<?= $cat['id'] ?>">
                            <button type="submit" name="submit_category" class="btn btn-outline-primary mb-2"><?= $cat['nama']; ?></button>
                        </form>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well-lg mt-5 border p-5 shadow p-3 mb-5 bg-white rounded w-75">
        <h4>Diskusi</h4>
        <div class="row">
            <div class="col-lg-12">

                <?php
                include("show_chat.php");
                ?>

                <form action="home.php" method="post">
                    <div class="input-group mt-3">
                        <input type="text" name="text" class="form-control" id="inputPassword2" placeholder="Tulis disini...">
                        <div class="input-group-btn">
                            <button type="submit" name="submit_chat" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>


            </div>

        </div>
        <!-- /.row -->
    </div>


</div>