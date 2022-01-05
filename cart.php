<?php
include __DIR__. "/__connect_db.php"; 

$title = "購物車列表"; // 這個變數可以吃到從『include __DIR__ . "/__html_head.php"』過來的值。
$pageName = "cart"; // 意思是給這個『cart.php』檔叫做cart。

//todo 以下開始做分頁

$perPage = 5; //每一頁有幾筆資料
// ---------在這條線以上做操作---------------
?>
<!---------這條線以下做呈現的頁面------------->
<?php include __DIR__. "/__html_head.php"; ?>
<?php include __DIR__. "/__navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col">
            
        </div>
    </div>
</div>
<?php include __DIR__. "/__scripts.php"; ?>
<?php include __DIR__. "/__html_foot.php"; ?>