<?php
require __DIR__ . '/ua__connect.php';


if(isset($_GET['sid'])){
    $usersid = intval($_GET['sid']);
    $pdo->query("DELETE FROM `trans_mainlist` WHERE sid='$usersid'");
}else{
    echo 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss';
}
$come_from = $SERVER['HTTP_REFERER'] ?? 'transportation.php';

header( "Location:$come_from");