<?php
$db_host= '192.168.40.17';
$db_name='bteam';
$db_user='bteam';
$db_pass='12345678';

$dsn= "mysql:host={$db_host};dbname={$db_name};charset=utf8";
$db_options=[
    PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8",
];
try{
    $pdo = new PDO($dsn,$db_user,$db_pass,$db_options);
} catch(PDOException $ex){
    echo'資料庫錯誤'. $ex->getMessage();
}
if(! isset($_SESSION)){
    session_start();
}
?>
