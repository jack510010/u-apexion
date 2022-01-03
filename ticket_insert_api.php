<?php
require __DIR__. "/__connect_db.php";

header('Content-Type: application/json');

$output = [
    "success" => "成功",
    "error" => "沒有錯誤"
];

// echo json_encode($output);

$flightTime = isset($_POST['flightTime'])? $_POST['flightTime'] : '';
$trip = $_POST['trip'];
$seatLevel = $_POST['seatLevel'];
$memberNumber = intval($_POST['memberNumber']);
$member = $_POST['member'];
$memberPass = $_FILES['memberPass']['name'];

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

if(empty($memberNumber) or $memberNumber > 10){
    $output["success"]=false;
    $output["error"]="人數上限10人，請輸入正確人數";
    echo json_encode($output);
    exit;
}

if(empty($member) or strlen($member) < 2 or !preg_match("/^[a-zA-Z\s]+$/",$member)){
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

$ticketSql = sprintf("INSERT INTO `ticket` (`flight_time`, `trip_sid`, `seat_sid`, `member_count`,`created_at`) VALUES ('%s', '%s', '%s', '%s', NOW())",$flightTime,$trip,$seatLevel,$memberNumber);

$stmt = $pdo->query($ticketSql)->fetch();

$memberSql = "INSERT INTO `member`(`name`, `passport`) VALUES ('$member','$memberPass')";

$pdo->query($memberSql);



// echo json_encode($member);

?>