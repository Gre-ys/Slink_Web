<?php
$query = "SELECT * FROM showchat WHERE date(tanggal_kirim) = date(now()) ";
$posts = queryGetData($query);

?>

<link rel="stylesheet" href="../../css/style5.css">
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl">
                <div class="card card-bordered">

                    <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">
                        <div class="media media-chat">
                            <div class="media-body p-1">
                                <?php if (count($posts) == 0) : ?>
                                    <small class="d-flex justify-content-center mt-4">Belum ada diskusi :(</small>
                                <?php endif; ?>
                                <?php foreach ($posts as $post) : ?>
                                    <small><a target="_blank" href="./user.php?username=<?php echo $post['username'] ?>" style="text-decoration: none;"><?php echo $post['username'] ?></a>&nbsp date: <?php echo $post['tanggal_kirim'] ?></small>
                                    <p><?php echo $post['content'] ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>