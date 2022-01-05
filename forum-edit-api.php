<?php
require __DIR__. '/__connect_db.php';

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];

$sid=isset($_POST['sid'])? intval($_POST['sid']) : 0;
if(empty($sid)){
    $sid['code']=400;
    $sid['error']='沒有sid';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}

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



$sql = "UPDATE `forum_article` SET 
                          `art_category_sid`=?,
                          `art_title`=?,
                          `art_content`=?
WHERE `sid`=?";



$stmt = $pdo->prepare($sql);

$stmt->execute([
    $category,
    $title,
    $content,
    $sid
]);


if($stmt->rowCount()==0){
    $output['error'] = '資料沒有修改';
}else{
    $output['success'] = true;
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
