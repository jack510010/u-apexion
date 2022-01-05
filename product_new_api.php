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

$sql = "INSERT INTO `product`(`category`, `product_name`, `img`, `style`,
 `size`, `quantity`, `price`, `create_date`, `update_date`) VALUES (?,?,?,?,?,?,?,NOW(),NOW())";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $category,
    $product_name,
    $img,
    $style,
    $size,
    $quantity,
    $price,
]);

$output['success'] = $stmt->rowCount() == 1;
$output['rowCount'] = $stmt->rowCount();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
