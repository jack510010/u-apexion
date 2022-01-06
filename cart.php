<?php
include __DIR__ . "/__connect_db.php";

$title = "購物車列表"; // 這個變數可以吃到從『include __DIR__ . "/__html_head.php"』過來的值。
$pageName = "cart"; // 意思是給這個『cart.php』檔叫做cart。

//todo 以下開始做分頁

$perPage = 5; //每一頁有幾筆資料

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
//ORDER BY sid DESC意思就是降冪排序
$sql = sprintf("SELECT * FROM cart LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
// $perPage = 5; 每一頁有幾筆資料。 假設我要看第三頁的資料，那就表示我要從第11筆開示看嘛，因為前兩頁一共有10筆資料
// 兩頁 * 每頁5筆, 顯示第三頁5筆資料。 所以程式碼才會是($page - 1) * $perPage, $perPage

$row = $pdo->query($sql)->fetchAll(); // 拿到所有資料的陣列
// ---------在這條線以上做操作---------------
?>
<!---------這條線以下做呈現的頁面------------->
<?php include __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <?= "$totalRows, $totalPages" ?>
            <!--會顯示總筆數、總頁數。-->
            <nav aria-label="Page navigation example">
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
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table　table-dark table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fas fa-trash-alt"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">會員</th>
                        <th scope="col">商品編號</th>
                        <th scope="col">數量</th>
                        <th scope="col">
                            <i class="fas fa-edit"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . "/__scripts.php"; ?>
<?php include __DIR__ . "/__html_foot.php"; ?>