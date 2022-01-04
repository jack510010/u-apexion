<?php
require __DIR__ . '/__connect_db.php';

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];


$sql = sprintf(
    "INSERT INTO `user`( `name`, `gender`, `email`, `password`, `mobile`, `birthday`, `address`,  `nick-name`, `country`, `create-date`, `update-date`) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW(), NOW() )",

    $_POST['name'],
    $_POST['gender'],
    $_POST['email'],
    $_POST['password'],
    $_POST['mobile'],
    $_POST['birthday'],
    $_POST['address'],

    $_POST['nick-name'],
    $_POST['country']

);

$stmt = $pdo->query($sql);

$output['rowCount'] = $stmt->rowCount();












echo json_encode($output);