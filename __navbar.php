<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" id="navbar" style="width: 20%;height: 100vh">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto  text-decoration-none">
            <div class="logo"><img src="./img/logo.png" alt=""></div>
            <svg class="bi me-2" width="5" height="5">
                <use xlink:href="#speedometer2"></use>
            </svg>
            <span class="fs-4">U-Apexion</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="#" class="nav-link ">
                    <svg class="bi me-2" width="25" height="25">
                        <use xlink:href="#speedometer2"></use>
                    </svg>
                    行程介紹
                </a>
            </li>
            <li>
                <a href="ticket_insert.php" class="nav-link">
                    <svg class="bi me-2" width="25" height="25">
                        <use xlink:href="#table"></use>
                    </svg>
                    訂票
                </a>
            </li>
            <li>
                <a href="#" class="nav-link ">
                    <svg class="bi me-2" width="25" height="25">
                        <use xlink:href="#grid"></use>
                    </svg>
                    交通
                </a>
            </li>
            <li>
            <a href="product.php" class="nav-link <?= $pageName=='product' ? 'active disabled' : '' ?>">
                    <svg class="bi me-2" width="25" height="25">
                        <use xlink:href="#people-circle"></use>
                    </svg>
                    商品
                </a>
            </li>
            <li>
                <a href="#" class="nav-link ">
                    <svg class="bi me-2" width="25" height="25">
                        <use xlink:href="#people-circle"></use>
                    </svg>
                    論壇
                </a>
            </li>
            <li>
                <a href="#" class="nav-link ">
                    <svg class="bi me-2" width="25" height="25">
                        <use xlinhref="#people-circle"></use>
                    </svg>
                    購物車
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    <svg class="bi me-2" width="25" height="25">
                        <use xlink:href="#home"></use>
                    </svg>
                    會員
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center  text-decoration-none dropdown-toggle" id="dropdownUser1"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div id="userPic"><img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2"></div>
                <svg class="bi me-2" width="5" height="5">
                    <use xlink:href="#speedometer2"></use>
                </svg>
                <strong>會員名稱</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">我的帳戶</a></li>
                <li><a class="dropdown-item" href="#">購買清單</a></li>
                <li>
                    <hr class="dropdown-divider bg-white">
                </li>
                <li><a class="dropdown-item" href="#">登出</a></li>
            </ul>
        </div>
    </div>
