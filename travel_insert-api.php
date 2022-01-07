<?php require __DIR__ . "/__connect_db.php";

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];

$sql = sprintf(
    "INSERT INTO `travel`( `name`,`introduction`, `attention`, `price`) VALUES 
    ('%s', '%s', '%s', '%s' )",

    $_POST['name'] ,
    $_POST['introduction'] ,
    $_POST['attention'] ,
    $_POST['price']  ,
);

$stmt = $pdo->query($sql);


$output['success'] =  $stmt->rowCount()==1;
$output['rowCount'] = $stmt->rowCount();

echo json_encode($_output);


