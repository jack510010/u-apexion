<?php
require __DIR__ . '/__connect_db.php';

$output = [
    'success' => false,
    'code' => 0,
    'error' => '',
];

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$mobile = $_POST['mobile'] ?? '';

// TODO: 檢查欄位資料
if (empty($name)) {
    $output['code'] = 401;
    $output['error'] = '請輸入正確的姓名';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (empty($email) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $output['code'] = 405;
    $output['error'] = '請輸入正確的email';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (empty($password)) {
    $output['code'] = 406;
    $output['error'] = '請輸入正確的密碼';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}
if (empty($mobile) or !preg_match("/^09\d{2}-?\d{3}-?\d{3}$/", $mobile)) {
    $output['code'] = 407;
    $output['error'] = '請輸入正確的手機號碼';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql =
    "INSERT INTO `user`( `name`, `email`, `password`, `mobile`, `birthday`, `address`, `country`, `create-date`, `update-date`) VALUES(?, ?, ?, ?, ?, ?, ?, NOW(), NOW() )";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $name,
    $email,

    $password,
    $mobile,
    empty($_POST['birthday']) ? NULL : $_POST['birthday'],
    $_POST['address'] ?? '',
    $_POST['country'] ?? ''

]);



$output['success'] = $stmt->rowCount() == 1;
$output['rowCount'] = $stmt->rowCount();












echo json_encode($output);