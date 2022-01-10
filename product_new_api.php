<?php require __DIR__ . "/__connect_db.php";

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];

$category = $_POST['category'] ?? '';
$product_name = $_POST['product_name'] ?? '';
$img = $_FILES['img'] ?? '';
$style = $_POST['style'] ?? '';
$size = $_POST['size'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$price = $_POST['price'] ?? '';
// $imgName = implode(",", $img['name']);

//檢查欄位資料
if (empty($product_name)) {
    $output['code'] = 401;
    $output['error'] = '請輸入正確的產品名稱';
    echo json_encode($output);
    exit;
}

if (empty($quantity)) {
    $output['code'] = 401;
    $output['error'] = '請填入庫存數量並且必須是數字';
    echo json_encode($output);
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

        $sql = "INSERT INTO `product`(`category`, `product_name`, `img`, `style`,
 `size`, `quantity`, `price`, `create_date`, `update_date`) VALUES (?,?,?,?,?,?,?,NOW(),NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $category,
            $product_name,
            $filename,
            $style = $_POST['style'] ?? '',
            $size = $_POST['size'] ?? '',
            $quantity,
            empty($_POST['price']) ? NULL : $_POST['price'],

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

/*
$exts = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];

if (!empty($_FILES['img'])) {
    $ext = $exts[$_FILES['img']['type']] ?? '';  // 拿到對應的副檔名
    if (!empty($ext)) {

        $filename = sha1($_FILES['img']['name'] . rand()) . $ext;
        //設定變數去接
        $target = $upload_folder . '/' . $filename;
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            $output['success'] = true;
            $output['filename'] = $filename;
            // TODO: 可以將檔案寫入資料表
        } else {
            $output['error'] = '無法移動檔案';
        }
    } else {
        $output['error'] = '不合法的檔案類型';
    }
} else {
    $output['error'] = '沒有上傳檔案';
}
*/

$output['success'] = $stmt->rowCount() == 1;
$output['rowCount'] = $stmt->rowCount();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
