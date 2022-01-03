<?php
require __DIR__. "/__connect_db.php";

$allData = "SELECT COUNT(1) FROM `ticket`";
$allDataCount = $pdo->query($allData)->fetch(PDO::FETCH_NUM)[0];
// echo json_encode($allDataCount);

$joinData = "SELECT a.`flight_time`, a.`trip_sid`, a.`seat_sid`, b.`name`,b.`passport` FROM `ticket` a JOIN `member` b ON a.sid = b.`ticket_sid`";
$rows = $pdo->query($joinData)->fetchAll();

?>

<?php require __DIR__. "/__html_head.php";?>
<?php require __DIR__. "/__navbar.php";?>

<!-- <form class="ticket-form mt-3" name="ticketForm"> -->
<div class="myticket-wrap"> 
<h2 class="my-3 text-white">我的訂票資訊</h2>
<?php foreach($rows as $r):?>
  <div class="myticket-content d-flex">
  <div class="myticket-content-word w-75">
  <h4 class="py-2">My Ticket</h4>
  <ul class="py-2">
      <li class="py-1">Name&emsp;<?= $r['name'] ?></li>
      <li class="py-1">Date&emsp;<?= $r['flight_time'] ?></li>
      <li class="py-1">Seat lvl&emsp;<?= $r['seat_sid'] ?></li>
      <li class="py-1">Destination&emsp;<?= $r['trip_sid'] ?></li>
  </ul>
  </div>
  <div class="myticket-content-pic w-25">
      <img src="./img/passtest.png" alt="">
  </div>
  </div>
  <br>
<?php endforeach;?>
</div>
<!-- </form> -->
<?php require __DIR__. "/__scripts.php";?>
<?php require __DIR__. "/__html_foot.php";?>
