<?php
require __DIR__. "/__connect_db.php";

header('Content-Type: application/json');

$output = [
    "success" =>  true,
    "error" => "",
];

$ticketsid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
$flightTime = isset($_POST['flightTime'])? $_POST['flightTime'] : '';
$trip = isset($_POST['trip'])? $_POST['trip'] : '';
$seatLevel = isset($_POST['seatLevel'])? $_POST['seatLevel'] : '';
$memberNumber = isset($_POST['memberNumber'])? intval($_POST['memberNumber']) : '';
$member = isset($_POST['member'])? implode(",",$_POST['member']) : '';
$memberPass = isset($_FILES['memberPass'])? implode(",",$_FILES['memberPass']['name']) : '';


if(empty($flightTime)){
    $output["success"]=false;
    $output["error"]="請選擇日程";
    echo json_encode($output);
    exit;
}

if(empty($trip)){
    $output["success"]=false;
    $output["error"]="請選擇行程";
    echo json_encode($output);
    exit;
}

if(empty($seatLevel)){
    $output["success"]=false;
    $output["error"]="請選擇艙等";
    echo json_encode($output);
    exit;
}

//TODO: 大於10防呆機制無效
if(empty($memberNumber) or $memberNumber > 10){
    $output["success"]=false;
    $output["error"]="人數上限10人，請輸入正確人數";
    echo json_encode($output);
    exit;
}

//TODO: 英文和小於2個字防呆機制無效
if(empty($member or strlen($member) < 2 or !preg_match("/^[a-zA-Z\s]+$/",$member))){
    $output["success"]=false;
    $output["error"]="請輸入成員護照姓名";
    echo json_encode($output);
    exit;
}

if(empty($memberPass)){
    $output["success"]=false;
    $output["error"]="請選擇護照檔案";
    echo json_encode($output);
    exit;
}


//移動檔案位置
$upload_folder = __DIR__."/img/uploaded";
if(! empty($_FILES['memberPass'])) {
    foreach($_FILES['memberPass']['name'] as $i=>$name){
        $filename = $memberPass;

        $target = $upload_folder. '/'. $filename;
        if( move_uploaded_file($_FILES['memberPass']['tmp_name'][$i], $target)){
            $output['success'] = true;
            $output['filename'] = $filename;
            $output['i'] = $i;
        } else {
            $output['error'] = '無法移動檔案';
            $output['target'] = $target;
        }
        }
    } 
else {
    $output['error'] = '沒有上傳檔案';
}


$ticketSql = sprintf("INSERT INTO `ticket` (`sid`,`flight_time`, `trip_sid`, `seat_sid`, `member_count`,`created_at`) VALUES ('%s','%s', '%s', '%s', '%s', NOW())",$ticketsid,$flightTime,$trip,$seatLevel,$memberNumber);

$stmt = $pdo->query($ticketSql)->fetch();
$ticketid = $pdo->lastInsertId();

// echo $ticketid;

$memberSql = "INSERT INTO `member`(`ticket_sid`,`name`, `passport`) VALUES ('$ticketid','$member','$memberPass')";

$pdo->query($memberSql);


echo json_encode($output,JSON_UNESCAPED_UNICODE);

?>
