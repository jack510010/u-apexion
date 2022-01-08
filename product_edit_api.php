<?php require __DIR__ . "/__connect_db.php";

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
    'sid' => isset($_POST['sid']) ? intval($_POST['sid']) : 0
];

$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
if (empty($sid)) {
    $output['code'] = 400;
    $output['error'] = '沒有sid';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
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
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($quantity)) {
    $output['code'] = 401;
    $output['error'] = '請填入庫存數量並且必須是數字';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
$exts = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];

header('Content-Type: application/json');
$upload_folder = __DIR__ . '/img/product_img';

if (!empty($_FILES['img'])) {
    $ext = $exts[$_FILES['img']['type']] ?? '';  // 拿到對應的副檔名
    if (!empty($ext)) {

        $filename = $_FILES['img']['name'] . rand() . $ext;
        //設定變數去接
        $target = $upload_folder . '/' . $filename;
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            $output['success'] = true;
            $output['filename'] = $filename;

            $sql = "UPDATE `product` SET `category`=?,`product_name`=?,`img`=?,`style`=?,`size`=?,`quantity`=?,`price`=?,`update_date`=NOW() WHERE `sid`=?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $category,
                $product_name,
                $filename,
                $style = $_POST['style'] ?? '',
                $size = $_POST['size'] ?? '',
                $quantity,
                empty($_POST['price']) ? NULL : $_POST['price'],
                isset($_POST['sid']) ? intval($_POST['sid']) : 0

            ]);
        } else {
            $output['error'] = '無法移動檔案';
        }
    } else {
        $output['error'] = '不合法的檔案類型';
    }
} else {
    $output['error'] = '沒有上傳檔案';
}


// $sql = "UPDATE `product` SET `category`=?,`product_name`=?,`img`=?,`style`=?,`size`=?,`quantity`=?,`price`=?,`update_date`=NOW() WHERE `sid`=?";

// $stmt = $pdo->prepare($sql);
// $stmt->execute([
//     $category,
//     $product_name,
//     $img,
//     $style = $_POST['style'] ?? '',
//     $size = $_POST['size'] ?? '',
//     $quantity,
//     empty($_POST['price']) ? NULL : $_POST['price'],
//     isset($_POST['sid']) ? intval($_POST['sid']) :0
// ]);

$output['success'] = $stmt->rowCount() == 1;
$output['rowCount'] = $stmt->rowCount();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
