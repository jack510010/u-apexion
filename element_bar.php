<?php
require __DIR__. "/__connect_db.php";
?>
<?php require __DIR__. "/__html_head.php";?>
<?php require __DIR__. "/__navbar.php";?>
<!-- Example single danger button -->
<div class="btn-group p-3 ">
  <button type="button" class="btn btn-danger dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
    旅程詳情
  </button>
  <ul class="dropdown-menu ">
    <li><a class="dropdown-item" href="element.php">星座之旅(Element)</a></li>
    <li><a class="dropdown-item" href="travel_insert.php">新增行程</a></li>
  </ul>
</div>
<?php require __DIR__ . "/__scripts.php"; ?>
<?php require __DIR__ . "/__html_foot.php"; ?>