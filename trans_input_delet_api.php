<?php
require __DIR__ . "/__connect_db.php";

header('Content-Type: application/json', 'Accept: application/json');


$user_sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
$destination_address = isset($_POST['destination_add']) ? $_POST['destination_add'] : '';
$transportation_kind = isset($_POST['transport']) ? $_POST['transport'] : '';
$boarding_locat = isset($_POST['board']) ? $_POST['board'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$seats = isset($_POST['seat']) ? $_POST['seat'] : '';
$output = [
    'success' => false,
    'error' => '',
    'userid' => $user_sid,
    'add' => $destination_address,
    'kind' => $transportation_kind,
    'boarding_locat' => $boarding_locat,
    'date' => $date,
     'seats' => $seats
];
// $memberPass = isset($_FILES['memberPass'])? implode(",",$_FILES['memberPass']['name']) : '';


if (empty($date)) {
    $output['success'] = false;
    $output['error'] = 'Please Select The Date';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($destination_address)) {
    $output['success'] = false;
    $output['error'] = 'Please Chek Out The Destination Address Form';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($transportation_kind)) {
    $output['success'] = false;
    $output['error'] = 'Are You Blind?';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


// $transql = "UPDATE `trans_mainlist` SET `transportation_way`='bus' WHERE `sid` = 2";
// $pdo->query($transql);
$transql ="UPDATE `trans_mainlists` SET `boarding_location_main`=?, `seat_main`=?, `transportation_way`=?, `destination_address_main`=?, `schedule`=? WHERE sid=?";


$stmt = $pdo->prepare($transql); //prepare() 準備執行


$stmt->execute([
    $boarding_locat,
    $seats,
    $transportation_kind,
    $destination_address,
    $date,
    $user_sid
]); 


if($stmt->rowCount()==0){
    $output['error'] = 'nothing changed';
} else {
    $output['success'] = true;
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
