<?php
require __DIR__ . '/__connect_db.php';

$output = [
    'success' => false,
    'code' => 0,
    'error' => '帳號或密碼錯誤',
];

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) or empty($password)) {
    $output['error'] = '欄位資料不足';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = sprintf("SELECT * FROM `user` WHERE `email`=%s", $pdo->quote($email));

$user = $pdo->query($sql)->fetch();
if (empty($user)) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($password == $user['password']) {
    $output['success'] = true;
    $output['error'] = '';
    $_SESSION['admin'] = [
        'email' => $user['email'],
        'name' => $user['name'],
        'sid' => $user['sid'],
    ];
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);