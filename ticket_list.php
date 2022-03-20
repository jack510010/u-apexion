<?php
require __DIR__ . '/__connect_db.php';

$allData = 'SELECT COUNT(1) FROM `ticket`';
$allDataCount = $pdo->query($allData)->fetch(PDO::FETCH_NUM)[0];
// echo json_encode($allDataCount);

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ticket_list.php');
    exit();
}
$perPage = 4;

$joinData = sprintf(
    'SELECT a.`sid`,a.`flight_time`, a.`trip_sid`, a.`seat_sid`, b.`member_name`,b.`passport`,c.`level`,d.`name` FROM `ticket` a JOIN `member` b ON a.sid = b.`ticket_sid` JOIN `flight_seat` c ON a.`seat_sid` = c.`price` JOIN `travel` d ON d.`price` = a.`trip_sid` ORDER BY a.`sid` DESC LIMIT %s,%s',
    ($page - 1) * $perPage,
    $perPage
);

$rows = $pdo->query($joinData)->fetchAll();

$t_sql = 'SELECT COUNT(1) FROM `member`';
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPage = ceil($totalRows / $perPage);

// echo $totalPage;
?>

<?php require __DIR__ . '/__html_head.php'; ?>
<?php require __DIR__ . '/__navbar.php'; ?>
<div class="all-bg">
<!-- <form class="ticket-form mt-3" name="ticketForm"> -->
<div class="all-wrap">
<div class="ticket-list-wrap"> 
<h2 class="text-light">訂票資訊一覽</h2>
<table class="table ticket-list-table">
  <thead>
    <tr>
      <th scope="col"><input type="checkbox"></th>
      <th scope="col">No</th>
      <th scope="col">護照姓名</th>
      <th scope="col">護照照片</th>
      <th scope="col">出發日期</th>
      <th scope="col">旅遊行程</th>
      <th scope="col">艙等</th>
      <th scope="col">費用</th>
      <th scope="col"><a href=""><i class="fas fa-edit"></i></a></th>
      <th scope="col"><a href=""><i class="fas fa-trash-alt"></i></a></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r) {
        $membergroup = explode(',', $r['member_name']);
        $memberPassgroup = explode(',', $r['passport']);
        for ($i = 0; $i < count($membergroup); $i++) { ?>
      
    <tr>
      <td><input type="checkbox"></td>
      <td scope="row"><?php echo $r['sid']; ?></td>
      <td><?php echo $membergroup[$i]; ?></td>
      <td width="120px" height="120px"><img src="./img/uploaded/<?php echo $memberPassgroup[
          $i
      ]; ?>" alt=""></td>
      <td><?php echo $r['flight_time']; ?></td>
      <td><?php echo $r['flight_time']; ?></td>
      <td><?php echo $r['level']; ?></td>
      <td></td>
      <td scope="col"><a href="ticket_edit.php?sid=<?= $r[
          'sid'
      ] ?>"><i class="fas fa-edit"></i></a></td>
      <td scope="col"><a href="ticket_delete.php?sid=<?= $r[
          'sid'
      ] ?>"><i class="fas fa-trash-alt"></i></a></td>
    </tr>
    <?php }
    } ?>
  </tbody>
</table>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="?page=<?= $page -
        1 ?>">Previous</a></li>
    <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
    <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?php echo $i; ?></a></li>
    <?php } ?>
    <li class="page-item"><a class="page-link" href="?page=<?= $page +
        1 ?>">Next</a></li>
  </ul>
</nav>

</div>
</div>
</div>
<!-- </form> -->
<?php require __DIR__ . '/__scripts.php'; ?>
<?php require __DIR__ . '/__html_foot.php'; ?>
