<?php require __DIR__ . "/__connect_db.php";

if (isset($_GET['sid'])) {
    $sid = intval($_GET['sid']);
    $pdo->query("DELETE FROM `product` WHERE sid=$sid");
}
//轉向頁面回product.php
$come_form = $_SERVER['HTTP_SERVER'] ?? 'product.php';
header("Location:$come_form");
