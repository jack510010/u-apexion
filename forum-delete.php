<?php
require __DIR__. '/__connect_db.php';



if(isset($_GET['sid'])){
    $sid=intval($_GET['sid']);
    $pdo->query("DELETE FROM `forum_article` WHERE sid=$sid");
}

$come_from =$_SERVER['HTTP_REFERER'] ?? 'forum-list copy.php';

header("location: $come_from");