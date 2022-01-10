<?php  
include __DIR__. "/__connect_db.php";   //!只有處理資料沒有畫面!!!!!!!!!!!!!!! 因為是API
if (!isset($_SESSION['admin'])) {
    header('Location: user_login.php');
    exit;
}
$output = [               // $output這個變數是要告訴前端一些訊息用的，例如success拉，error拉等等。
    "success" => false,
    "code" => 0,
    "error" => "",
];

$sid = isset($_POST["sid"]) ? intval($_POST["sid"]) : 0;  // 判斷有或沒有sid，有的話讓sid變成整數，
                                                          // 沒有的話就給0
                                                          // 就是從隱藏欄位來的

if (empty($sid)){                      
$output["code"] = 400;
$output["error"] = "沒有sid";
echo json_encode($output,JSON_UNESCAPED_UNICODE); exit;    
}

$user_id = $_POST["user_id"] ?? "";      //如果有$_POST["user_id"]的話就給$_POST["user_id"]，
                                         //沒有的話就給""
$product_id = $_POST["product_id"] ?? "";
$count_number = $_POST["count_number"] ?? "";

//todo 檢查欄位資料

if (empty($user_id)){            // 如果沒有會員編號          
    $output["code"] = 401;                                                    // 顯示$output       
    $output["error"] = "請輸入您的會員編號";
    echo json_encode($output, JSON_UNESCAPED_UNICODE); exit;    
    // 到這邊就不繼續往下做了，因為沒有填會員編號。
    //這邊echo就會拿到"success" => false
    // 直接結束exit，告訴前端說『啊你沒有給我會員編號，所以後面我不做了』。
}

if(empty($product_id) or !preg_match("/^[a-zA-Z0-9]+$/", $product_id)){
    // 這串的意思是：如果你product_id沒有填寫，
    // 或者你product_id格式不對，那就不讓你通過。
    $output["code"] = 405;
    $output["error"] = "請輸入想購買的商品編號";
    echo json_encode($output); exit;        //那就結束exit後面不做了
}

if(empty($count_number) or !preg_match("/^[a-zA-Z0-9]+$/", $count_number)){
    $output["code"] = 407;
    $output["error"] = "您想購入的數量";
    echo json_encode($output); exit;        //那就結束exit後面不做了
}

$sql = "UPDATE `cart` SET 
                    `user_id`= ?,
                    `product_id`= ?,
                    `count_number`= ?,
                    `create_at`= NOW()
WHERE `sid`= ?";  // 這個sid的值就是從隱藏欄位來的

$stmt = $pdo->prepare($sql); // 我要準備來執行這個$sql，只有準備而已還沒有執行
                             // 先檢查這個語法是否正確

$stmt->execute([             // execute 執行的意思，中括號裡面的是array。
    $user_id,                   // VALUES(?, ?, ?, ?, ?) 會依照順序把對應的值放入
    $product_id,
    $count_number,
    $sid
]); // 但是這樣的寫法比較不容易除錯，因為我不會看到這個值塞進去長什麼樣子。

if ($stmt->rowCount() == 0){
    $output["error"] = "清單沒有修改";
}else{
    $output["success"] = true;
}
echo json_encode($output); //「json_encode」的意思是編碼成json的字串
?>