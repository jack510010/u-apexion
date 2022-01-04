<?php
require __DIR__. '/__connect_db.php';

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];
// if(!isset($_SESSION['admin'])){
//     $output['error'] = '請登入管理帳號';
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }

$title = $_POST['title'] ?? '';
$category = $_POST['category'] ?? '';
$content = $_POST['content'] ?? '';


// TODO: 檢查欄位資料
if(empty($title)){
    $output['code'] = 401;
    $output['error'] = '請輸入標題';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}
if(empty($category)){
    $output['code'] = 402;
    $output['error'] = '請輸入副標題';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}
if(empty($content)){
    $output['code'] = 403;
    $output['error'] = '請輸入內文';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}





$sql = "INSERT INTO `forum_article`(
                           `user_sid`,`art_title`, `art_category_sid`, `art_content`, `art_create_time`
                           ) VALUES (?,?, ?, ?, NOW() )";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    2,
    // 待設定變數
    $title,
    $category,
    $content,
    // empty($_POST['art_photo']) ? NULL : $_POST['art_photo'],
]);


$output['success'] = $stmt->rowCount()==1;
$output['rowCount'] = $stmt->rowCount();



echo json_encode($output, JSON_UNESCAPED_UNICODE);
