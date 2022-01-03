<?php require __DIR__ . "/__connect_db.php"; ?>
<?php require __DIR__ . "/__html_head.php"; ?>
<div class="d-flex">
  <?php require __DIR__ . "/__navbar.php"; ?>
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light pt-3 shadow ">
      <div class="container-fluid"><i class="fas fa-laptop-house text-warning"></i>
        <a class="navbar text-warning" href="product.php" style="text-decoration:none;">所有商品</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                女生
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">外套</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">T恤</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">帽子</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                男生
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">外套</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">T恤</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">帽子</a></li>
              </ul>
            </li>
          </ul>
          <button type="button" class="btn btn-info"><a class="text-dark" href="product_new.php" style="text-decoration:none;">新增商品</a></button>
          <form class="d-flex align-items-center ms-2">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-warning" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
    <!-- 下方新增表單列表 -->
    <div class="d-flex">
      <form class="container pt-4 mx-2">
        <div class="form-row text-light">
          <div class=" mb-3">
            <label for="validationDefault01">商品名稱</label>
            <input type="text" class="form-control" id="validationDefault01" placeholder="名稱" required>
          </div>
          <div class=" mb-3">
            <label for="validationDefault02">產品分類</label>
            <select class="custom-select d-block w-100" id="country" required="">
              <option value=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">選擇...</font></font></option>
              <option>
                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">女生</font></font>
            </option>
            <option>
                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">男生</font></font>
            </option>
            </select>
          </div>
          <div class=" mb-3">
            <label for="validationDefaultUsername">產品照片</label>
            <div class="input-group">
              <input type="text" class="form-control" id="validationDefaultUsername" placeholder="照片" aria-describedby="inputGroupPrepend2" required>
            </div>
          </div>
          <div class=" mb-3">
            <label for="validationDefaultUsername">庫存數量</label>
            <div class="input-group">
              <input type="text" class="form-control" id="validationDefaultUsername" placeholder="請填入數字" aria-describedby="inputGroupPrepend2" required>
            </div>
          </div>
          <div class=" mb-3">
            <label for="validationDefaultUsername">價格</label>
            <div class="input-group">
              <input type="text" class="form-control" id="validationDefaultUsername" placeholder="請填入數字" aria-describedby="inputGroupPrepend2" required>
            </div>
          </div>
        </div>
        <div class="">
        <label class="text-light">尺寸</label>
          <select class="mb-3">
            <option value="1">F</option>
            <option value="2">S</option>
            <option value="3">M</option>
            <option value="4">L</option>
            <option value="5">其他</option>
          </select>
        </div>
        <button class="btn btn-primary" type="submit">資料送出</button>

      </form>
      <div class="pt-4 mx-2">
        <img class="img-fluid " src="./img/logo.png" width="50" height="50">
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . "/__scripts.php"; ?>
<?php require __DIR__ . "/__html_foot.php"; ?>