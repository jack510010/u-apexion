<?php
require __DIR__. "/__connect_db.php";

$flightsql = 'SELECT `flight_time` FROM `flight`';
$flightrows = $pdo->query($flightsql)->fetchAll();
$seatsql = 'SELECT * FROM `flight_seat`';
$seatrows = $pdo->query($seatsql)->fetchAll();

$sid = intval($_GET['sid']);
$nowDataSql = "SELECT a.`sid`,a.`flight_time`,a.`trip_sid`,a.`seat_sid`,a.`member_count`,b.`ticket_sid`,b.`name`,b.`passport` FROM `ticket` a JOIN `member` b ON a.`sid` = b.`ticket_sid` WHERE a.`sid` = $sid";

$nowDatarow = $pdo->query($nowDataSql)->fetch();
$nowDatarowName = explode(",",$nowDatarow['name']);
?>
<?php require __DIR__. "/__html_head.php";?>
<?php require __DIR__. "/__navbar.php";?>

<form class="ticket-form mt-3" name="ticketForm">
<input type="hidden" name="sid" value="<?= $nowDatarow['sid'] ?>">
  <h2 class="mb-3">修改訂票資訊</h2>
  <div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class=" align-self-stretch d-flex align-items-center justify-content-center">啟航日程</label>
    <select required class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="flightTime">
  <option selected disabled>目前所選日程:&nbsp<?= $nowDatarow['flight_time']?></option>
  <?php foreach ($flightrows as $r) { ?>
    <option><?= $r['flight_time'] ?></option>
  <?php } ?>
</select>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"> -->
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch">旅遊行程</label>
    <select id="select-trip" class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="trip" required>
  <option  selected disabled>目前所選行程:&nbsp<?= $nowDatarow['trip_sid']?></option>
  <option value="50元">One</option>
  <option value="100元">Two</option>
  <option value="150元">Three</option>
</select>
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch">艙等</label>
    <select id="select-seat" required class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="seatLevel">
  <option selected disabled>目前所選艙等:&nbsp<?= $nowDatarow['seat_sid']?></option>
  <?php foreach ($seatrows as $r) { ?>
  <option ><?= $r['level'] ?></option>
  <?php } ?>
</select>
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch flex-grow-1">人數</label>
    <input required type="number" maxlength="2" class="form-control " id="members" placeholder="請輸入人數(上限10人)" name="memberNumber" value="<?= $nowDatarow['member_count'] ?>">
    <button class="member-confirm d-flex align-items-center justify-content-center align-self-stretch" onclick="memberCount(); return false;">確認</button>
    </div>
    <div class="ticket-incorrect "></div>
  </div>
  <div class="member-input">
  </div>
  <button type="submit" class="ticketBtn btn-primary px-4 py-1" onclick="sendTicketForm(); return false">修改</button>
</form>

<?php require __DIR__. "/__scripts.php";?>
<script>

//載入當前資料
    const memberValue = `<div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="memberName form-label  d-flex align-items-center justify-content-center align-self-stretch">成員姓名</label>
    <input type="" class="form-control flex-fill" id="exampleInputEmail1" aria-describedby="emailHelp" name="member[]" placeholder="請輸入護照英文名字" value="<?= $nowDatarowName[0]?>">
    </div>
    <div class="ticket-incorrect"></div>
  </div><div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="memberPassport form-label  d-flex align-items-center justify-content-center align-self-stretch">護照上傳</label>
    <input type="file" class="form-control UploadPas flex-fill" name="memberPass[]" value="456">
    </div>
    <div class="ticket-incorrect"></div>
  </div>`;

window.onload=function (){
    // document.querySelector(".member-input").innerHTML = "";
        const membernum = members.value;
        console.log(membernum);
        for(let i=1;i<=membernum;i++){
            document.querySelector(".member-input").innerHTML += memberValue;
            const memberInputTitle = document.querySelectorAll("label");
            memberInputTitle.forEach(function(v) {
            if(v.classList.contains("memberName")){
            v.setAttribute('style' , `background-color: #048ABF`);
            // console.log(memberInputTitle);
        }else if(v.classList.contains("memberPassport")){
            v.setAttribute('style' , `background-color: #023E73`);
        }
        })
        }
        document.querySelector(".ticketBtn").style= "display: block";
}

//重新選取人數
const memberInput = `<div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="memberName form-label  d-flex align-items-center justify-content-center align-self-stretch">成員姓名</label>
    <input type="" class="form-control flex-fill" id="exampleInputEmail1" aria-describedby="emailHelp" name="member[]" placeholder="請輸入護照英文名字">
    </div>
    <div class="ticket-incorrect"></div>
  </div><div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="memberPassport form-label  d-flex align-items-center justify-content-center align-self-stretch">護照上傳</label>
    <input type="file" class="form-control UploadPas flex-fill" name="memberPass[]">
    </div>
    <div class="ticket-incorrect"></div>
  </div>`;

  function memberCount(){
        document.querySelector(".member-input").innerHTML = "";
        const membernum = members.value;
        console.log(membernum);
        for(let i=1;i<=membernum;i++){
          if(i<=10){
            document.querySelector(".member-input").innerHTML += memberInput;
            const memberInputTitle = document.querySelectorAll("label");
            memberInputTitle.forEach(function(v) {
            if(v.classList.contains("memberName")){
            v.setAttribute('style' , `background-color: #048ABF`);
            // console.log(memberInputTitle);
        }else if(v.classList.contains("memberPassport")){
            v.setAttribute('style' , `background-color: #023E73`);
        }
        })
        }
        else {
          alert("人數超過10人了喔");
          document.querySelector(".member-input").innerHTML = "";
          break;
        } 
        }
        document.querySelector(".ticketBtn").style= "display: block";
}

function sendTicketForm(){
  const fd = new FormData(document.ticketForm);

  fetch("ticket_edit_api.php",{
    method: 'POST',
    body: fd,
  }).then(r=>r.json())
  .then(txt => {
    alert(txt.sid);
    location.href = "ticket_myticket.php";
});
}

const select = document.querySelector("#select");
select.addEventListener('change', showValue);

function showValue(e){
  console.log(e.target.value);
};

</script>

設定監聽器 
監聽下拉選單value改變 or 使用者點選特定項目
console.log(value)
