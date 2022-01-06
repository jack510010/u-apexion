<?php
require __DIR__. "/__connect_db.php";

$flightsql = 'SELECT * FROM `flight`';
$flightrows = $pdo->query($flightsql)->fetchAll();
$seatsql = 'SELECT * FROM `flight_seat`';
$seatrows = $pdo->query($seatsql)->fetchAll();
$travelsql = "SELECT `name` FROM `travel`";
$travelnamerows = $pdo->query($travelsql)->fetchAll();

$sid = intval($_GET['sid']);
$nowDataSql = "SELECT a.`sid`,a.`flight_time`,a.`trip_sid`,a.`seat_sid`,a.`member_count`,b.`ticket_sid`,b.`name`,b.`passport` FROM `ticket` a JOIN `member` b ON a.`sid` = b.`ticket_sid` WHERE a.`sid` = $sid";

$nowDatarow = $pdo->query($nowDataSql)->fetch();
$nowDatarowName = explode(",",$nowDatarow['name']);

// echo $flightrows["flight_time"];
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
  <option id="selected" selected><?= $nowDatarow['flight_time']?></option>
  <?php foreach ($flightrows as $r) { 
      if($r['flight_time'] != $nowDatarow['flight_time']){?>
    <option><?= $r['flight_time'] ?></option>
  <?php }} ?>
</select>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"> -->
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch">旅遊行程</label>
    <select id="select-trip" class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="trip" required>
    <option selected><?= $nowDatarow['trip_sid']?></option>
  <?php foreach ($travelnamerows as $r) { 
     if($r['name'] != $nowDatarow['trip_sid']){?>
  <option ><?= $r['name'] ?></option>
  <?php }} ?>
</select>
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch">艙等</label>
    <select id="select-seat" required class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="seatLevel">
  <option selected><?= $nowDatarow['seat_sid']?></option>
  <?php foreach ($seatrows as $r) { 
     if($r['level'] != $nowDatarow['seat_sid']){?>
  <option ><?= $r['level'] ?></option>
  <?php }} ?>
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
    

window.onload=function (){
    // document.querySelector(".member-input").innerHTML = "";
        const membernum = members.value;
        console.log(membernum);
        const memberName = <?= json_encode($nowDatarowName)?>;
        console.log(memberName);
        
        for(let i=0;i<membernum;i++){
          const memberValue = `<div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="membername" class="memberName form-label  d-flex align-items-center justify-content-center align-self-stretch">成員姓名</label>
    <input type="" class="form-control flex-fill" id="membername" aria-describedby="emailHelp" name="member[]" placeholder="請輸入護照英文名字" value="${memberName[i]}">
    </div>
    <div class="ticket-incorrect"></div>
  </div><div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="memberPassport form-label  d-flex align-items-center justify-content-center align-self-stretch">護照上傳</label>
    <input type="file" class="form-control UploadPas flex-fill" name="memberPass[]" value="456">
    </div>
    <div class="ticket-incorrect"></div>
  </div>`;
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
    <label for="membername" class="memberName form-label  d-flex align-items-center justify-content-center align-self-stretch">成員姓名</label>
    <input type="" class="memberNowName form-control flex-fill" id="membername" aria-describedby="emailHelp" name="member[]" placeholder="請輸入護照英文名字">
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
        document.querySelector(".ticketBtn").style= "display: block";
        }
        else {
          alert("超過人數上限10人，請重新輸入人數");
          document.querySelector(".member-input").innerHTML = "";
          document.querySelector(".ticketBtn").style= "display: none";
          break;
        } 
        }
        
}

function sendTicketForm(){
  const fd = new FormData(document.ticketForm);
  let isPass = true;

  if(members.value.length == 0){
    isPass = false;
    alert("請輸入人數");
  }
  

  //TODO::防呆機制怎麼了?
  const abc = document.querySelectorAll("input")
  console.log(abc)
  const isEnglish = /^[A-Za-z]+$/;
  // for(let v of eee){
  // if(v.getAttribute('value').length == 0 | isEnglish.test(v.getAttribute('value')) == false){
  //   isPass = false;
  //   alert("請輸入護照英文姓名");
  // }
  // }


  if(isPass){
  fetch("ticket_edit_api.php",{
    method: 'POST',
    body: fd,
  }).then(r=>r.json())
  .then(txt => {
    alert(txt.sid);
    location.href = "ticket_myticket.php";
});
}
}

</script>
