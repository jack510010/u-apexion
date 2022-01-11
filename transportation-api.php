<?php
require __DIR__. "/__connect_db.php";

header('Content-Type: application/json', 'Accept: application/json');

$output = [
    'success' => false,
    'error' => '',
    'des' =>$destination_address,
    '$trans' =>$transportation_kind,
    '$board' =>$boarding_locat,
    '$date' =>$date ,
    'seat' =>$seats,
];
// $usersid = isset($_POST['sid']) ? intval($_POST['sid']) : 1;
$destination_address = isset($_POST['destination_add']) ? $_POST['destination_add'] : '';

$transportation_kind = isset($_POST['transport']) ? $_POST['transport'] : '';

$boarding_locat = isset($_POST['board']) ? $_POST['board'] : '';

$date = isset($_POST['myDate']) ? $_POST['myDate'] : '';

$seats = isset($_POST['seat']) ? $_POST['seat'] : '';


// $memberPass = isset($_FILES['memberPass'])? implode(",",$_FILES['memberPass']['name']) : '';


if(empty($date)){
    $output['success']=false;
    $output['error']=$date;
    echo json_encode($output);
    exit;
}

if(empty($destination_address)){
    $output['success']=false;
    $output['error']='Please Chek Out The Destination Address Form';
    echo json_encode($output);
    exit;
}

if(empty($transportation_kind)){
    $output['success']=false;
    $output['error']='Are You Blind?';
    echo json_encode($output);
    exit;
}


$transql = sprintf("INSERT INTO `trans_mainlists` ( `boarding_location_main`, `seat_main`, `transportation_way`,`destination_address_main`,`schedule`) VALUES (?,?,?,?,?)");

//$transql = sprintf("INSERT INTO `trans_mainlists` ( `boarding_location_main`) VALUES ('TTB')");


$stmt = $pdo->prepare($transql);//prepare() 準備執行

$stmt->execute([
    $boarding_locat,
    $seats,
    $transportation_kind,
    $destination_address,
    $date
]);
$output['success'] = $stmt->rowCount() == 1;

$output['sql'] = $transql;

$output['var'] = [$boarding_locat,
$seats,
$transportation_kind,
$destination_address,
$date];
//$output['success'] = true;
// echo $output;
echo json_encode($output);

?>
