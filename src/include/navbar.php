        <!-- Header Berisi Navbar -->
        <header class="animasi3">
            <nav class="navbar navbar-expand-lg bg-white shadow-sm p-3">
                <div class="container-fluid">
                    <a class="logo navbar-brand ms-5" href="./home.php"><img src="../Foto/logo.png" alt="" width="105" /></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nb nav-item rounded-1 mx-1">
                                <a class="nav-link " aria-current="page" href="./home.php" style="color: #6aa5a9;">Home</a>
                            </li>
                            <li class="nb nav-item rounded-2 mx-1">
                                <a class="nav-link " href="./cms.php" style="color: #6aa5a9;">Links</a>
                            </li>
                            <li class="nb nav-item rounded-2 mx-1  ">
                                <a class="nav-link " href="./bookmarks.php" style="color: #6aa5a9;">Bookmarks</a>
                            </li>
                            <li class="nb nav-item rounded-2 mx-1">
                                <a class="nav-link " href="./leaderboard.php " style="color: #6aa5a9;">Leaderboard</a>
                            </li>
                        </ul>
                        </ul>
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $userinfo = getProfile($user_id);

                        $id = $userinfo[0]['id'];
                        $nama = $userinfo[0]['nama'];
                        $foto = $userinfo[0]['foto'];
                        if ($foto == "" || empty($foto) || $foto == null) {
                            echo "<img src='../Foto/user.png' class='rounded-circle me-3' width='40px'>";
                        } else {
                            echo "<img src='../Foto/{$foto}' class='rounded-circle me-3' width='40px' height='40px'>";
                        }
                        ?>

                        <a class="nb nav-link me-5 rounded-1" href="./profile.php" style="color: #6aa5a9;"><?php echo $nama; ?></a>
                        <p class="nb nav-link me-5 text-danger mt-3" style="cursor:pointer" id="logout">Log Out</p>
                    </div>
                </div>
            </nav>
        </header>