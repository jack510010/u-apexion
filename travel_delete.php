 <?php require __DIR__ . "/__connect_db.php";
if(isset($_GET['sid'])){
    $sid = intval($_GET['sid']);
    $pdo->query("DELETE FROM `travel` WHERE sid=$sid");
}

$come_from = $_SERVER['HTTP_REFERER'] ?? 'element.php';


header("Location: $come_from");