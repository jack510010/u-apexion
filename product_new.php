<?php require __DIR__ . "/__connect_db.php";?>
<?php require __DIR__ . "/__html_head.php"; ?>
<div class="d-flex">
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container-fluid">
<nav class="navbar navbar-expand-lg navbar-light pt-3 shadow ">
  <div class="container-fluid">
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
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">T恤</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">帽子</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            男生
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">外套</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">T恤</a></li>
            <li><hr class="dropdown-divider"></li>
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
</div>
</div>
<?php require __DIR__ . "/__scripts.php"; ?>
<?php require __DIR__ . "/__html_foot.php"; ?>

