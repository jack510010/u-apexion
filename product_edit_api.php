<?php require __DIR__ . "/__connect_db.php";

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
    'sid' => isset($_POST['sid']) ? intval($_POST['sid']) :0
];

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
if (empty($sid)) {
    $output['code'] = 400;
    $output['error'] = '沒有sid';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}
$category = $_POST['category'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$img = $_FILES['img'] ?? '';
$style = $_POST['style'] ?? '';
$size = $_POST['size'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$price = $_POST['price'] ?? '';


//檢查欄位資料
if (empty($product_name)) {
    $output['code'] = 401;
    $output['error'] = '請輸入正確的產品名稱';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($quantity)) {
    $output['code'] = 401;
    $output['error'] = '請填入庫存數量並且必須是數字';
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "UPDATE `product` SET `category`=?,`product_name`=?,`img`=?,`style`=?,`size`=?,`quantity`=?,`price`=?,`update_date`=NOW() WHERE `sid`=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $category,
    $product_name,
    $img,
    $style = $_POST['style'] ?? '',
    $size = $_POST['size'] ?? '',
    $quantity,
    empty($_POST['price']) ? NULL : $_POST['price'],
    isset($_POST['sid']) ? intval($_POST['sid']) :0
]);

$output['success'] = $stmt->rowCount() == 1;
$output['rowCount'] = $stmt->rowCount();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
