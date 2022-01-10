<?php
require __DIR__. "/__connect_db.php";

$allData = "SELECT COUNT(1) FROM `ticket`";
$allDataCount = $pdo->query($allData)->fetch(PDO::FETCH_NUM)[0];
// echo json_encode($allDataCount);

$joinData = "SELECT a.`sid`,a.`flight_time`, a.`trip_sid`, a.`seat_sid`, b.`member_name`,b.`passport`,c.`level`,d.`name` FROM `ticket` a JOIN `member` b ON a.sid = b.`ticket_sid` JOIN `flight_seat` c ON a.`seat_sid` = c.`price` JOIN `travel` d ON d.`price` = a.`trip_sid` ORDER BY a.`sid` DESC ";
$rows = $pdo->query($joinData)->fetchAll();

?>

<?php require __DIR__. "/__html_head.php";?>
<?php require __DIR__. "/__navbar.php";?>
<div class="all-bg">
<!-- <form class="ticket-form mt-3" name="ticketForm"> -->
<div class="all-wrap">
<div class="myticket-wrap"> 
<h2 class="my-3 text-white">訂票資訊一覽</h2>
<?php foreach($rows as $r):
  $membergroup = explode(",",$r['member_name']);
  $memberPassgroup = explode(",",$r['passport']) ?>
  <?php for($i=0;$i<count($membergroup);$i++): ?>
  <div class="myticket-change d-flex justify-content-end">
    <a class="myticket-edit-btn" href="ticket_edit.php?sid=<?= $r['sid']?>"><i class="far fa-edit"></i>修改</a>
    <a class="myticket-delete-btn" href="ticket_delete.php?sid=<?= $r['sid'] ?>" onclick="return confirm('確定要刪除這筆資料嗎?')"><i class="fas fa-trash-alt"></i>刪除</a>
  </div>
  <div class="myticket-content d-flex">
    <img class="rocket-pic" src="./img/rocket.png" alt="">
  <div class="myticket-content-word w-75">
  <h4 class="py-2">My Ticket</h4>
  <ul class="pt-2">
      <li class="">Name&emsp;<?= $membergroup[$i] ?></li>
      <li class="">Date&emsp;<?= $r['flight_time'] ?></li>
      <li class="">Seat lvl&emsp;<?= $r['level'] ?></li>
      <li class="">Trip&emsp;<?= $r['name'] ?></li>
      <li class=" barcode"><img src="./img/barcode.png" alt=""></li>
  </ul>
  </div>
  <div class="myticket-content-pic w-25">
      <img src="./img/uploaded/<?= $memberPassgroup[$i]?>" alt="">
  </div>
  </div>
  <br>
<?php endfor; endforeach;?>
</div>
</div>
</div>
<!-- </form> -->
<?php require __DIR__. "/__scripts.php";?>
<?php require __DIR__. "/__html_foot.php";?>
