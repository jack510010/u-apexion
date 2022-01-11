<?php
require __DIR__ . '/__connect_db.php';


if(isset($_GET['sid'])){
    $usersid = intval($_GET['sid']);
    $pdo->query("DELETE FROM `trans_mainlists` WHERE user_sid='$usersid'");
}else{
    echo 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss';
}
$come_from = $SERVER['HTTP_REFERER'] ?? 'transportation.php';

header( "Location:$come_from");