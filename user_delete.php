<?php
require __DIR__ . '/__connect_db.php';


if (isset($_GET['sid'])) {
    $sid = intval($_GET['sid']);

    $pdo->query("DELETE FROM `user` WHERE sid=$sid");
}

$come_from = $_SERVER['HTTP_REFERER'] ?? 'user_list.php';

header("Location: $come_from");