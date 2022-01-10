<?php
require __DIR__. '/__connect_db.php';

$output = [
    'success' => false,
    'code' => 0,
    'error' => [],
    'files' =>[],
];
// if(!isset($_SESSION['admin'])){
//     $output['error'] = '請登入管理帳號';
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }
$exts = [
    'image/jpeg' => '.jpg',
    'image/png' => '.png',
    'image/gif' => '.gif',
];

$title = $_POST['title'] ?? '';
$category = $_POST['category'] ?? '';
$content = $_POST['content'] ?? '';
$photo = $_FILES['photo'] ?? '';

//將上傳的檔案指定到對的路徑
$upload_folder = __DIR__. '/img';
$ext = $exts[$photo['type']] ?? '';  // 拿到對應的副檔名 沒有則空字串


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

//圖片上傳部分 : 如果拿到的附檔名不為空 ==> 就是有拿到對應的副檔名
if (!empty($ext)) {
    //將檔案名稱改為==> 拿到的名子+rand() 再用SHA1 轉換  最後在+上副檔名
    // $filename = 'MA_' . $name . $ext;
    $filename = $photo['name'];

    // $target = $upload_folder . '/' . $_FILES['imgInps']['name'];

    // 傳到目的資料夾用新的名子去放到指定的資料夾
    $target = $upload_folder . '/' . $filename;

    //將檔案幫搬移(用拿到的暫存檔案名稱 移動目標位置)
    if (move_uploaded_file($photo['tmp_name'], $target)) {
        $output['success'] = true; // 執行成功的次數 -> 上傳的檔案數量
        $output['filename'] = $filename;
        //印出檔案名稱
        // $output['files'][] = $filename; // push 檔名
        // TODO: 可以將檔案寫入資料表

        // $sql =
        //     "INSERT INTO `materials` (`material_img_path` )VALUES (?)";

        // // 先prepare準備要將SQL 的語法塞進 stmt 中 做檢查SQL的動作 
        // $stmt = $pdo->prepare($sql);
        // //execute 執行 準備好後才作執行
        // $stmt->execute([
        //     $filename,

        // ]);
    } else {
        $output['error'] = '無法移動檔案';
    }
} else {

    $output['error'] = '不合法的檔案類型';
}



$sql = "INSERT INTO `forum_article`(
                           `user_sid`,`art_title`, `art_category_sid`,
                           `art_photo`, `art_content`, `art_create_time`
                           ) VALUES (?,?, ?,?, ?, NOW() )";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    2,
    // 待設定變數
    $title,
    $category,
    empty($output['filename']) ? NULL : $output['filename'],
    $content,
    
]);


$output['success'] = $stmt->rowCount()==1;
$output['rowCount'] = $stmt->rowCount();



echo json_encode($output, JSON_UNESCAPED_UNICODE);
