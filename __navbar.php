<div class="nav-bg d-flex flex-column flex-shrink-0 p-3" id="navbar" style="width: 15%;height: 100vh">
    <a href="index_.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto  text-decoration-none">
        <div class="logo"><img src="./img/logo.jpg" alt=""></div>
        <!-- <svg class="bi me-2" width="5" height="5">
            <use xlink:href="#speedometer2"></use>
        </svg> -->
        <!-- <span class="fs-4">U-Apexion</span> -->
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="element_index.php" class="nav-link <?= $pageName == 'element' ? 'active disabled' : '' ?>">
                <svg class="bi me-2" width="10" height="25">
                    <use xlink:href="#speedometer2"></use>
                </svg>
                行程
            </a>
        </li>
        <li>
            <a href="ticket_insert.php" class="nav-link <?= $pageName == 'ticket_insert' ? 'active disabled' : '' ?>">
                <svg class="bi me-2" width="10" height="25">
                    <use xlink:href="#table"></use>
                </svg>
                訂票
            </a>
        </li>
        <li>
            <a href="trans-button.php?sid=2" class="nav-link ">
                <svg class="bi me-2" width="10" height="25">
                    <use xlink:href="#grid"></use>
                </svg>
                交通
            </a>
        </li>
        <li>
            <a href="product.php" class="nav-link <?= $pageName == 'product' ? 'active disabled' : '' ?>">
                <svg class="bi me-2" width="10" height="25">
                    <use xlink:href="#people-circle"></use>
                </svg>
                商品
            </a>
        </li>
        <li>
            <a href="forum-list copy.php" class="nav-link <?= $pageName == 'forum-list' ? 'active disabled' : '' ?>">
                <svg class="bi me-2" width="10" height="25">
                    <use xlink:href="#people-circle"></use>
                </svg>
                論壇
            </a>
        </li>
        <li>
            <a href="cart.php" class="nav-link <?= $pageName == 'cart' ? 'active disabled' : '' ?>">
                <svg class="bi me-2" width="10" height="25">
                    <use xlinhref="#people-circle"></use>
                </svg>
                購物車
            </a>
        </li>
        <li class="nav-item">
            <a href="user_login.php?pagefrom=login" class="nav-link <?= $pageName == 'user_list' ? 'active disabled' : '' ?>">
                <svg class="bi me-2" width="10" height="25">
                    <use xlink:href="#home"></use>
                </svg>
                會員

            </a>

        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center  text-decoration-none dropdown-toggle " id="dropdownUser1"
            data-bs-toggle="dropdown" aria-expanded="false">
            <?php if(isset($_SESSION['admin'])){ ?>
            <div id="userPic" style="width: 50px"><img src="./img/userpic.png" alt=""  height=""
                    class=" me-2"></i></div>
                <?php }else {?>
                    <div id="userPic" style="width: 50px"><i class="fas fa-user"></i></div>
                    <?php } ?>
            <svg class="bi me-2" width="5" height="5">
                <use xlink:href="#speedometer2"></use>
            </svg>
            <strong><?= $_SESSION['admin']['name'] ?? '會員你好' ?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
            <li>
                <?php if (!isset($_SESSION['admin']['email']) && !isset($_SESSION['admin']['name'])) { ?>
                <a class="dropdown-item" href="user_login.php">登入</a>
                <?php } ?>
            </li>
            <li>
                <?php if (isset($_SESSION['admin']['email']) && isset($_SESSION['admin']['name'])) { ?>
                <a class="dropdown-item" href="user_logout.php">登出</a>
                <?php } ?>
            </li>
        </ul>






    </div>
</div>
