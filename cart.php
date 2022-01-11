<?php
// 這個是read
include __DIR__ . "/__connect_db.php";
if (!isset($_SESSION['admin'])) {
    $path = explode("?", "$_SERVER[REQUEST_URI]");
    $filename = basename($path[0]);
    $_SESSION['page_from'] = $filename;

    header('Location: user_login.php');
    exit;
}

$title = "購物車列表"; // 這個變數可以吃到從『include __DIR__ . "/__html_head.php"』過來的值。
$pageName = "cart"; // 意思是給這個『cart.php』檔叫做cart。

//todo 以下開始做分頁

$perPage = 4; //每一頁有幾筆資料

// intval意思是轉換成整數』如果有的話轉換成整數
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;  // 去拿到所在頁面，
//如果有的話就去那一頁，沒有的話就去第一頁。
//這樣就不能亂改頁面

if ($page < 1) {                   // 如果page的頁數小於1的話就讓他轉向到『header("location: cart.php")』
    header("location: cart.php");
    exit;
};

$total_sql = "SELECT COUNT(1) FROM cart"; //這養只會有一筆，但裡面有總筆數，寫在COUNT裡面。

$totalRows = $pdo->query($total_sql)->fetch(PDO::FETCH_NUM)[0];
//因為只有一筆所以用fetch就好了，
//但是裡面是COUNT(1)的欄位名稱，而我不要欄位名稱，
//因此fetch()括弧裡面要用，『PDO::FETCH_NUM』
//返回以數字作為索引鍵(key) 的陣列(array)，由0開始編號』
// 得出來的值是總筆數

$totalPages = ceil($totalRows / $perPage); // 總頁數
//todo 分頁做完

if ($page > $totalPages) {
    // 我程式碼寫到這裡才拿到 $totalPages 所以才可以下這個條件
    // if ($page > $totalPages)
    // 要照邏輯走，所以這個條件不能跟『if ($page < 1)』寫在一起
    // 如果page的頁數大於$totalPages的話就讓他轉向到
    //『header("location: list.php?page=". $totalPages)』
    header("location: cart.php?page=" . $totalPages);
    exit;
};

$sql = sprintf("SELECT * FROM cart ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
// $perPage = 5; 每一頁有幾筆資料。 假設我要看第三頁的資料，那就表示我要從第11筆開示看嘛，因為前兩頁一共有10筆資料
// 兩頁 * 每頁5筆, 顯示第三頁5筆資料。 所以程式碼才會是($page - 1) * $perPage, $perPage

$row = $pdo->query($sql)->fetchAll(); // 拿到所有資料的陣列

//print_r($row);
// ---------在這條線以上做操作---------------
?>

<?php include __DIR__ . "/__html_head.php" ?>
<style>
    .container-wrap {
        z-index: -2;
    }

    #navbar {
        z-index: 1;
    }
</style>
<?php include __DIR__ . "/__navbar.php"; ?>

<video class="vdo" playsinline="" loop="loop" autoplay="autoplay" style=" width: 120%; height: 120%; position: fixed;left:-8%;filter:brightness(.9);z-index:-1;">
    <source src="https://assets.mixkit.co/videos/preview/mixkit-stars-in-the-sky-rotating-10011-large.mp4" type="video/mp4">
</video>


<div class="second" style="object-fit:cover; z-index:1;">
    <div class="container">
        <div class="row">
            <div class="col-6 ">
                <div class="d-flex align-items-center">
                    <nav aria-label="Page navigation example">
                        <!--會顯示頁數的bootstrap-->
                        <ul class="pagination">

                            <li class="page-item <?= 1 == $page ? "disabled" : "" ?> "><a class="page-link" href="?page=1 "><i class="fas fa-step-backward"></i></a></li>
                            <!--去到最前頁icon-->
                            <!--如果page已經在第1頁了，就不讓使用者繼續按，所以呈現disabled 『1 == $page ? "disabled" : ""』-->

                            <li class="page-item <?= 1 == $page ? "disabled" : "" ?> "><a class="page-link" href="?page=<?= $page - 1 ?> "><i class="fas fa-chevron-circle-left"></i></a></li>
                            <!--『href="?"』連結是『？』代表檔案是同一個檔案-->
                            <!--上一頁的icon-->
                            <!--當前所在的頁數減1就是上一頁    href="?page= $page - 1-->
                            <!--如果page已經在第1頁了，就不讓使用者繼續按，所以呈現disabled 『1 == $page ? "disabled" : ""』-->
                            <!-- && $i <= $totalPages-->

                            <?php for ($i = $page - 2; $i <= $page + 2; $i++) :
                                if ($i >= 1 && $i <= $totalPages) : ?>
                                    <!--把頁數呈現出來，用for迴圈把$i的值帶入-->

                                    <li class="page-item <?= $i == $page ? "active" : "" ?> ">
                                        <!--這串是要讓使用者的所在頁數反白。如果$i的值等於所在頁數$page，『就反白"active"』，『沒有的話就啥也不做""』-->

                                        <a class="page-link" href="?page=<?= $i ?>">
                                            <!--#字號(改成用?page)後面會顯示所在頁數-->
                                            <?= $i ?>
                                            <!--本來是寫死的頁數，改成用變數$i把值帶入-->
                                        </a>
                                    </li>

                            <?php endif;
                            endfor; ?>
                            <li class="page-item <?= $totalPages == $page ? "disabled" : "" ?> "><a class="page-link" href="?page=<?= $page + 1 ?> "><i class="fas fa-chevron-circle-right"></i></a></li>
                            <!--下一頁的icon-->
                            <!--當前所在的頁數加1就是上一頁   href="?page= $page + 1  -->
                            <!--如果page已經在最後一頁了，就不讓使用者繼續按，所以呈現disabled 『$totalPages == $page ? "disabled" : ""』-->

                            <li class="page-item <?= $totalPages == $page ? "disabled" : "" ?> "><a class="page-link" href="?page=<?= $totalPages ?> "><i class="fas fa-step-forward"></i></a></li>
                            <!--最後一頁的icon-->
                            <!--如果page已經在最後一頁了，就不讓使用者繼續按，所以呈現disabled 『$totalPages == $page ? "disabled" : ""』-->

                        </ul>

                    </nav>
                    <p class="px-2 text-warning ml-5" style="width: 500px;">共有<?= $totalRows ?>筆資料</p>
                </div>
            </div>

            <div class="col-4"></div>

            <div class="col-2 justify-content-end">
                <!-- <a class="btn btn-primary col <?= $pageName == "cart" ? "active disabled" : "" ?> " href="#" role="button">清單</a> -->
                <a class="btn btn-info col text-dark" href="cart-insert.php" role="button">新增購入項目</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table  text-white">
                <thead>
                    <tr class="text-info">

                        <th scope="col">
                            <i class="fas fa-trash-alt"></i>
                        </th>
                        <th scope="col">編號</th>
                        <th scope="col">會員</th>
                        <th scope="col">商品編號</th>
                        <th scope="col">數量</th>
                        <th scope="col">下單時間</th>
                        <th scope="col">
                            <i class="fas fa-edit"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($row as $r) : ?>
                        <!--不知道foreach哪來的去看這個檔案『4foreach-0有問題要問老師.php』-->
                        <tr>
                            <!--這一坨就是後端生畫面-->
                            <td>
                                <!-- 裡面這是第一種刪除方法。比較直觀簡單。因為我們要告訴他要刪除哪一筆，所以加上?sid=<?= $r["sid"] ?>，看a標籤 -->
                                <a href="cart-delete.php?sid=<?= $r["sid"] ?>" onclick="return confirm('確定要刪除這筆資料嗎？')">
                                    <i class="fas fa-trash-alt text-white"></i>
                                </a>
                            </td>
                            <td><?= $r["sid"] ?></td>
                            <td><?= htmlentities($r["user_id"]) ?></td>
                            <td><?= htmlentities($r["product_id"]) ?></td>
                            <td><?= htmlentities($r["count_number"]) ?></td>
                            <td><?= htmlentities($r["create_at"]) ?></td>
                            <!--htmlentities 放這個的原因是防範惡意程式攻擊，例如惡意javaScript系統-->
                            <td>
                                <a href="cart-edit.php?sid=<?= $r["sid"] ?>">
                                    <!--因為我們要告訴他要修改哪一筆，所以加上?sid= 『$r["sid"]』，看a標籤 -->
                                    <i class="fas fa-edit text-white"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<?php include __DIR__ . "/__scripts.php" ?>
<?php include __DIR__ . "/__html_foot.php" ?>