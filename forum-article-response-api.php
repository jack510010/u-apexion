<?php
require __DIR__. '/__connect_db.php';

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];

if(!isset($_SESSION['admin'])){
    $output['error'] = '請登入管理帳號';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$response = $_POST['response'] ?? '';


// TODO: 檢查欄位資料
if(empty($response)){
    $output['code'] = 401;
    $output['error'] = '請輸入回應再送出';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}

$sql = "INSERT INTO `forum_response`(
                           `user_sid`,`res_art_sid`, `res_content`, `res_time`
                           ) VALUES (?, ?, ?, NOW() )";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_SESSION['admin']['sid'],
    // 待設定變數
    2,
    // 待設定變數
    $response,
]);


$output['success'] = $stmt->rowCount()==1;
$output['rowCount'] = $stmt->rowCount();



echo json_encode($output, JSON_UNESCAPED_UNICODE);
