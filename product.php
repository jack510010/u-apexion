<?php require __DIR__ . "/__connect_db.php";
$title = '周邊商品';
$pageName = 'product';

if(!isset($_SESSION['admin'])){
     header('Location: user_list.php');
    exit;
}

//幾筆資料一頁
$perPage = 7;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: product.php');
  exit;
}

$newProduct = '';
if (isset($_GET["category"])) {
  $newProduct = " WHERE category='" . $_GET["category"] . "' AND product_name='" . $_GET["product_name"] . "'";
}

//提取表單資料
$sql = sprintf("SELECT SQL_CALC_FOUND_ROWS * FROM product %s LIMIT %s, %s", $newProduct, ($page - 1) * $perPage, $perPage);
$products = $pdo->query($sql)->fetchAll();

$t_sql = "SELECT FOUND_ROWS()";
// 算總比數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);
if ($page > $totalPages) {
  header('Location: product.php?page=' . $totalPages);
  exit;
}

?>
<?php require __DIR__ . "/__html_head.php"; ?>
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
            <a class="nav-link dropdown-toggle text-light" href="product.php?category=1" id="womanProduct" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              女生
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="product.php?category=女生&product_name=外套">外套</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="product.php?category=女生&product_name=T恤">T恤</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="product.php?category=女生&product_name=帽子">帽子</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              男生
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="product.php?category=男生&product_name=外套">外套</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="product.php?category=男生&product_name=T恤">T恤</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="product.php?category=男生&product_name=帽子">帽子</a></li>
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
  <!-- 下方列表 -->
  <div class="bd-example p-3">
    <table class="table table-hover text-light">
      <thead>
        <tr class="text-info">
          <th scope="col">編號</th>
          <th scope="col">分類</th>
          <th scope="col">商品名稱</th>
          <th scope="col">產品照片</th>
          <th scope="col">尺寸</th>
          <th scope="col">顏色</th>
          <th scope="col">庫存數量</th>
          <th scope="col">價格</th>
          <th scope="col">上架時間</th>
          <th scope="col">修改</th>
          <th scope="col">刪除</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $p) : ?>
          <tr>
            <td><?= $p['sid'] ?></td>
            <td><?= $p['category'] ?></td>
            <td><?= $p['product_name'] ?></td>
            <td><?= $p['img'] ?></td>
            <td><?= $p['size'] ?></td>
            <td><?= $p['style'] ?></td>
            <td><?= $p['quantity'] ?></td>
            <td class="text-warning"><?= $p['price'] ?></td>
            <td><?= $p['create_date'] ?></td>
            <td>
              <a href="product_edit.php?sid=<?= $p['sid'] ?>">
                <i class="fas fa-pencil-alt"></i>
              </a>
            </td>
            <td>
              <a href="product_delete.php?sid=<?= $p['sid'] ?>" onclick="return conform('確定要刪除這筆資料嗎')">
                <i class="fas fa-trash-alt"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="row">
      <div class="col text-warning d-flex justify-content-end align-items-center">
        <p class="px-2">共有<?= $totalRows ?>筆資料</p>
        <nav aria-label="Page navigation example">
          <ul class="pagination pagination">
            <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <?php for ($i = $page - 2; $i <= $page + 2; $i++)
              if ($i >= 1 && $i <= $totalPages) :
            ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endif; ?>
            <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>

    </div>
  </div>
</div>

<?php require __DIR__ . "/__scripts.php"; ?>
<?php require __DIR__ . "/__html_foot.php"; ?>