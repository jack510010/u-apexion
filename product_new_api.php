<?php require __DIR__ . "/__connect_db.php";

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];

$category = $_POST['category'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$img = $_POST['img'] ?? '';
$style = $_POST['style'] ?? '';
$size = $_POST['size'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$price = $_POST['price'] ?? '';


//檢查欄位資料
if(empty($product_name)) {
   $output['code'] = 401;
    $output['error'] = '請輸入正確的產品名稱';
echo json_encode($output); exit;}

if(empty($quantity)) {
    $output['code'] = 401;
     $output['error'] = '請填入庫存數量並且必須是數字';
 echo json_encode($output); exit;}

$sql = "INSERT INTO `product`(`category`, `product_name`, `img`, `style`,
 `size`, `quantity`, `price`, `create_date`, `update_date`) VALUES (?,?,?,?,?,?,?,NOW(),NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $category,
    $product_name,
    $img = $_POST['img'] ?? '',
    $style = $_POST['style'] ?? '',
    $size = $_POST['size'] ?? '',
    $quantity,
    empty($_POST['price']) ? NULL : $_POST['price'],
]);

$output['success'] = $stmt->rowCount() == 1;
$output['rowCount'] = $stmt->rowCount();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
