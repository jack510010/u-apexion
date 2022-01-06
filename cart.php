<?php
include __DIR__ . "/__connect_db.php";

$title = "購物車列表"; // 這個變數可以吃到從『include __DIR__ . "/__html_head.php"』過來的值。
$pageName = "cart"; // 意思是給這個『cart.php』檔叫做cart。

//todo 以下開始做分頁

$perPage = 5; //每一頁有幾筆資料
// ---------在這條線以上做操作---------------
?>
<!---------這條線以下做呈現的頁面------------->
<?php include __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__. "/__navbar.php";?>
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php include __DIR__ . "/__scripts.php"; ?>
<?php include __DIR__ . "/__html_foot.php"; ?>