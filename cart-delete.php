<?php  
// 現在要做delete。

include __DIR__ . "/__connect_db.php"; //__connect_db.php
if (!isset($_SESSION['admin'])) {
    header('Location: user_login.php');
    exit;
}

if (isset($_GET["sid"])){
    $sid = intval($_GET["sid"]);  // 這邊拿到的一定是整數，因為有intval。

    $pdo->query("DELETE FROM `cart` WHERE sid = $sid ");  // query()括號裡面的是sql語法，
                                                                  //目前括號裡的是刪除語法。
                                                                  // 這樣子就可以刪掉某一筆
}
// if (isset($_GET["sid"])) 如果沒有get到值的話，就會直接返回列表頁了。

// 做完之後讓用戶轉向，所以給他一個header讓他轉向
$come_from = $_SERVER["HTTP_REFERER"] ?? "cart.php";  // 轉去上一頁或列表頁。

header("Location: $come_from");
?>