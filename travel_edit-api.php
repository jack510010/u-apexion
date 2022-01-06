<?php require __DIR__ . "/__connect_db.php";


$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
if(empty($sid)) {
    $output['code'] = 400;
    $output['error'] = '沒有 sid';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}

$name = $_POST['name'] ?? '';
$introduction = $_POST['introduction'] ?? '';
$attention = $_POST['attention'] ?? '';


// TODO: 檢查欄位資料
if(empty($name)) {
    $output['code'] = 401;
    $output['error'] = '請輸入標題';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}
if(empty($introduction)) {
    $output['code'] = 405;
    $output['error'] = '請輸入介紹';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}
if(empty($attention)) {
    $output['code'] = 407;
    $output['error'] = '請輸入注意事項';
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;
}




$sql = "UPDATE `travel` SET 
                          `name`=?,
                          `introduction`=?,
                          `attention`=?,
                          `price`=?
WHERE `sid`=?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $introduction,
    $attention,
    $_POST['price'] ?? '',
    $sid
]);

if($stmt->rowCount()==0){
    $output['error'] = '資料沒有修改';
} else {
    $output['success'] = true;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
