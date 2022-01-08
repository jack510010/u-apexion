<?php 
// 這個是create
include __DIR__ . "/__connect_db.php";   //!只有處理資料沒有畫面!!!!!!!!!!!!!!! 因為是API
if (!isset($_SESSION['admin'])) {
    header('Location: user_login.php');
    exit;
}

$output = [               // $output這個變數是要告訴前端一些訊息用的，例如success拉，error拉等等。
    "success" => false,
    "code" => 0,
    "error" => "",
];
$user_id = $_POST["user_id"] ?? "";      //如果有$_POST["user_id"]的話就給$_POST["user_id"]，
                                         //沒有的話就給""
$product_id = $_POST["product_id"] ?? "";
$count_number = $_POST["count_number"] ?? "";

//todo 檢查欄位資料

if (empty($user_id)){                      // 如果沒有輸入user_id
    $output["code"] = 401;                 // 顯示$output
    $output["error"] = "請輸入您的會員編號";
    echo json_encode($output); exit;    // 到這邊就不繼續往下做了，因為沒有填會員編號。
                                        //這邊echo就會拿到"success" => false
                                        // 直接結束exit，告訴前端說『啊你沒有給我會員編號，所以後面我不做了』。
}

if (empty($product_id) or !preg_match("/^[a-zA-Z0-9]+$/", $product_id)){
    $output["code"] = 403;
    $output["error"] = "請輸入想購買的商品編號";
    echo json_encode($output); exit;
}

if (empty($count_number) or !preg_match("/^[a-zA-Z0-9]+$/", $product_id)){
    $output["code"] = 407;
    $output["error"] = "您想購入的數量";
    echo json_encode($output); exit;
}

$sql = "INSERT INTO `cart`( 
                    `user_id`, 
                    `product_id`, 
                    `count_number`,
                    `create_at`
                    ) VALUES (?, ?, ?, NOW())";

$stmt = $pdo->prepare($sql); // 我要準備來執行這個$sql，只有準備而已還沒有執行
                             // 先檢查這個語法是否正確

$stmt->execute([             // execute 執行的意思，中括號裡面的是array。
$user_id,                    // VALUES(?, ?, ?) 會依照順序把對應的值放入
$product_id,
$count_number,

]); // 但是這樣的寫法比較不容易除錯，因為我不會看到這個值塞進去長什麼樣子。

$output["success"] = $stmt->rowCount() == 1; // 這串的意思是說，如果我成功新增了會顯示"success" => true
                                             // 反之則會是"success" => false

$output["rowCount"] = $stmt->rowCount();  // rowCount字面上的意思就是『有幾筆』
// 如果我是SELECT，rowCount的意思就是我撈到幾筆。
// 如果我是INSERT INTO，rowCount的意思就是我新增幾筆。

echo json_encode($output); //「json_encode」的意思是編碼成json的字串