<?php
// Ambil Data Users yang Di Follow Para Follower dan Following 
$rekFollows = getRekFollows($user_id);
?>

<?php if (sizeof($rekFollows) > 0) :  ?>

    <div class="d-flex justify-content-center mt-5 fs-2 fw-bolder">
        <p class="px-3 text-white rounded rounded-5" style="background-color: #7EC384;">Diikuti</p>
        <p class="pe-2">&nbsp oleh Temanmu</p>
    </div>

    <div class="owl-carousel owl-theme mt-5">
        <?php foreach ($rekFollows as $rek) : ?>
            <?php $followCondition = (checkFollows($rek['user_id'], $user_id)) ? "<button type='button' class='col-3 btn btn-outline-danger follow_button' data-id='" . $rek['user_id'] . "'>Unfollow</button>" : "<button type='button' class='col-3 btn btn-primary follow_button' data-id='" . $rek['user_id'] . "'>Follow</button>"; ?>
            <?php $fotoCondition = ($rek['foto'] == null) ? "<img class='rounded-circle shadow-1-strong me-3' src='../Foto/user.png' alt='avatar' width='50' height='50' />" : "<img class='rounded-circle shadow-1-strong me-3' src='../Foto/" . $rek['foto'] . "' alt='avatar' width='50' height='50' />"; ?>
            <div class="item" style="width: 600px ;">
                <div class="card mb-5" style="width: 550px ;">
                    <div class="card-body d-flex">
                        <a target="_blank" href="./user.php?user_id=<?= $rek['user_id'] ?>" class="col-9 row text-decoration-none text-reset">
                            <div class="col-2">
                                <?= $fotoCondition; ?>
                            </div>
                            <h6 class="col-4"><?= $rek['username']; ?></h6>
                            <div class="col-2">
                                <h7 class="text-center bi bi-heart-fill text-danger"></h7>
                                <span class="mx-1"><?= $rek['jml_like']; ?></span>
                            </div>
                            <div class="col-2 ">
                                <h7 class="text-center bi bi-card-heading text-primary"></h7>
                                <span class="mx-1"><?= $rek['jml_post']; ?></span>
                            </div>
                        </a>
                        <?= $followCondition; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;  ?>