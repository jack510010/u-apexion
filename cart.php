<?php
// 這個是read
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

$sql = sprintf("SELECT * FROM cart LIMIT %s, %s", ($page - 1) * $perPage, $perPage);
// $perPage = 5; 每一頁有幾筆資料。 假設我要看第三頁的資料，那就表示我要從第11筆開示看嘛，因為前兩頁一共有10筆資料
// 兩頁 * 每頁5筆, 顯示第三頁5筆資料。 所以程式碼才會是($page - 1) * $perPage, $perPage

$row = $pdo->query($sql)->fetchAll(); // 拿到所有資料的陣列

print_r($row);
// ---------在這條線以上做操作---------------
?>
<?php include __DIR__ . "/__html_head.php" ?>
<?php include __DIR__ . "/__navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-dark table-striped table-bordered">
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
                    <?php foreach ($row as $r) : ?>
                        <!--不知道foreach哪來的去看這個檔案『4foreach-0有問題要問老師.php』-->
                        <tr>
                            <!--這一坨就是後端生畫面-->
                            <td>
                                <!-- 裡面這是第一種刪除方法。比較直觀簡單。因為我們要告訴他要刪除哪一筆，所以加上?sid=<?= $r["sid"] ?>，看a標籤 -->
                                <a href="cart-delete.php?sid=<?= $r["sid"] ?>" onclick="return confirm('確定要刪除這筆資料嗎？')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                            <td><?= $r["sid"] ?></td>
                            <td><?= htmlentities($r["user_id"]) ?></td>
                            <td><?= htmlentities($r["product_id"]) ?></td>
                            <td><?= htmlentities($r["count_number"]) ?></td>
                            <!--htmlentities 放這個的原因是防範惡意程式攻擊，例如惡意javaScript系統-->
                            <td>
                                <a href="edit.php?sid=<?= $r["sid"] ?>">
                                    <!--因為我們要告訴他要修改哪一筆，所以加上?sid= 『$r["sid"]』，看a標籤 -->
                                    <i class="fas fa-edit"></i>
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