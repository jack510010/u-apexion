<?php
require __DIR__. "/__connect_db.php";

if (!isset($_SESSION['admin'])) {
  $path=explode("?","$_SERVER[REQUEST_URI]");
  $filename=basename($path[0]);
  $_SESSION['page_from'] = $filename;
  
  header('Location: user_login.php');
  exit;
}

$flightsql = 'SELECT `flight_time` FROM `flight`';
$flightrows = $pdo->query($flightsql)->fetchAll();
$seatsql = 'SELECT * FROM `flight_seat`';
$seatrows = $pdo->query($seatsql)->fetchAll();
$travelsql = "SELECT * FROM `travel`";
$travelnamerows = $pdo->query($travelsql)->fetchAll();
// echo json_encode($flightrows);
$pageName = 'ticket_insert';
?>
<?php require __DIR__. "/__html_head.php";?>
<?php require __DIR__. "/__navbar.php";?>

<div class="all-bg">
<div class="all-wrap">
<form class="ticket-form mt-3" name="ticketForm">
  <h2 class="mb-3">新增訂票資訊</h2>
  <div class="mb-3 wow fadeInDown">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class=" align-self-stretch d-flex align-items-center justify-content-center">啟航日程</label>
    <select required id="flightTime" class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="flightTime">
  <option selected disabled>請選擇日程</option>
  <?php foreach ($flightrows as $r) { ?>
    <option><?= $r['flight_time'] ?></option>
  <?php } ?>
</select>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"> -->
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3 wow fadeInDown" data-wow-delay=".5s">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch">旅遊行程</label>
    <select id="trip" class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="trip" required>
  <option selected disabled>請選擇行程</option>
  <?php foreach ($travelnamerows as $r) { ?>
    <option value="<?= $r['price']?>"><?= $r['name'] ?></option>
  <?php } ?>
</select>
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3 wow fadeInDown" data-wow-delay="1s">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch">艙等</label>
    <select required id="seatlvl" class="ticket-form-select form-select form-control flex-fill" aria-label="Default select example" name="seatLevel">
  <option selected disabled>請選擇艙等</option>
  <?php foreach ($seatrows as $r) { ?>
  <option onmouseover="changeColor(this)" value="<?=$r['price']?>"><?= $r['level'] ?></option>
  <?php } ?>
</select>
    </div>
    <div class="ticket-incorrect"></div>
  </div>
  <div class="mb-3 wow fadeInDown" data-wow-delay="1.5s">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="exampleInputEmail1" class="form-label  d-flex align-items-center justify-content-center align-self-stretch flex-grow-1">人數</label>
    <input type="number" maxlength="2" class="form-control" id="members" placeholder="請輸入人數(上限10人)" name="memberNumber" required>
    <button class="member-confirm d-flex align-items-center justify-content-center align-self-stretch" onclick="memberCount(); return false;">確認</button>
    </div>
    <div class="ticket-incorrect "></div>
  </div>
  <div class="member-input">
  </div>
  <button type="submit" class="ticketBtn btn-primary px-4 py-1" onclick="sendTicketForm(); return false">送出</button>
</form>

<div class="ticket-price-wrap">
<table>
  <thead>
    <tr>
      <th scope="col" colspan="2">價格</th>
      <th scope="col" ></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td scope="row">行程</td>
      <td class="ticket-price-content ticket-price-trip" scope="row"></td>
    </tr>
    <tr>
      <td scope="row">艙等</td>
      <td class="ticket-price-content ticket-price-seat" scope="row"></td>
    </tr>
    <tr>
      <td scope="row">人數</td>
      <td class="ticket-price-content ticket-members" scope="row"></td>
    </tr>
    <tr>
      <td class="ticket-sumprice" scope="row">總計</td>
      <td id="ticket-sumprice" class="ticket-sumprice ticket-price-content" scope="row"></td>
    </tr>
  </tbody>
</table>
</div>
</div>
</div>


<?php require __DIR__. "/__scripts.php";?>

<script>
  //   針對多個element下監聽器無效
  //   var sel = document.querySelectorAll('.ticket-form-select');
  //   console.log(sel);
  //   for(i in sel){
  //   sel[i].addEventListener('click', function(){
  //   var options = this.children;
  //   for(var i=0; i < this.childElementCount; i++){
  //       options[i].style="color: #021943";
  //   }
  //   var selected = this.children[this.selectedIndex];
  //       selected.style = "color: white;background-color: #021943";
  //   }, false);
  // }
    
    const flight_sel = document.querySelector('#flightTime');
    flight_sel.addEventListener('click', function(){
    var options = this.children;
    for(var i=0; i < this.childElementCount; i++){
        options[i].style="color: #021943";
    }
    var selected = this.children[this.selectedIndex];
        selected.style = "color: white;background-color: #021943";
    }, false);

    const trip_sel = document.querySelector('#trip');
    trip_sel.addEventListener('click', function(){
    var options = this.children;
    for(var i=0; i < this.childElementCount; i++){
        options[i].style="color: #021943";
    }
    var selected = this.children[this.selectedIndex];
        selected.style = "color: white;background-color: #021943";
    }, false);

    const seatlvl_sel = document.querySelector('#seatlvl');
    seatlvl_sel.addEventListener('click', function(){
    var options = this.children;
    for(var i=0; i < this.childElementCount; i++){
        options[i].style="color: #021943";
    }
    var selected = this.children[this.selectedIndex];
        selected.style = "color: white;background-color: #021943";
    }, false);
  


    seatlvl.addEventListener("change",function(){
      document.querySelector(".ticket-price-seat").innerHTML = this.value;
      // console.log(document.querySelector(".ticket-price-seat").innerHTML);
      totalPrice();
    })

    trip.addEventListener("change",function(){
      document.querySelector(".ticket-price-trip").innerHTML = this.value;
      totalPrice();
    })

    function totalPrice(){
      document.querySelector(".ticket-price-wrap").style = "display: block";
      const a = parseInt(document.querySelector(".ticket-price-seat").innerHTML);
      const b = parseInt(document.querySelector(".ticket-price-trip").innerHTML);
      const c = parseInt(document.querySelector(".ticket-members").innerHTML);
      console.log((a+b)*c);
      if(!isNaN((a+b)*c)){
        document.querySelector("#ticket-sumprice").innerHTML = (a+b)*c}
    }

    

    const memberInput = `<div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="membername" class="memberName form-label  d-flex align-items-center justify-content-center align-self-stretch">成員姓名</label>
    <input type="text" class="memberNowName form-control flex-fill" id="membername" aria-describedby="emailHelp" name="member[]" placeholder="請輸入護照英文名字">
    </div>
    <div class="ticket-incorrect"></div>
  </div><div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="memberPass" class="memberPassport form-label  d-flex align-items-center justify-content-center align-self-stretch">護照上傳</label>
    <input type="file" class="form-control UploadPas flex-fill" id="memberPass" name="memberPass[]">
    </div>
    <div class="ticket-incorrect"></div>
  </div>`;
    function memberCount(){
        document.querySelector(".member-input").innerHTML = "";
        const membernum = members.value;
        for(let i=1;i<=membernum;i++){
          if(i<=10){
            document.querySelector(".member-input").innerHTML += memberInput;
            document.querySelector(".ticket-members").innerHTML = i;
            totalPrice();
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
          document.querySelector(".ticket-price-wrap").style = "display: none";
          break;
        } 
        }
        
}

function sendTicketForm(){
  const fd = new FormData(document.ticketForm);
  let isPass = true;

  if(flightTime.value == "0000-00-00 00:00:00"){
    isPass = false;
    alert("請選擇日程");
  }
  if(trip.value.length == 0){
    isPass = false;
    alert("請選擇行程");
  }
  if(seatlvl.value.length == 0){
    isPass = false;
    alert("請選擇艙等");
  }
  if(members.value.length == 0){
    isPass = false;
    alert("請輸入人數");
  }

 //TODO::判斷內容是空值時語法錯誤 & 護照檔案無選擇時尚未撰寫
 const isEnglish = /^[A-Za-z]+$/;
  const EachmembersName = document.querySelectorAll(".memberNowName");
  console.log([...EachmembersName[0].value].length);
  for(let v in EachmembersName){
    if(isEnglish.test(EachmembersName[v].value) == false){
      isPass = false;
      alert("請輸入護照英文姓名");
    }
    console.log(EachmembersName[v].value);
  };

  
  
  if(isPass){
  fetch("ticket_insert_api.php",{
    method: 'POST',
    body: fd,
  }).then(r=>r.json())
  .then(txt => {
  if(txt.success){
    console.log(txt.files);
    alert("資料新增成功");
    location.href = "ticket_myticket.php";
  }else {
    alert(txt.error);
  }
});
}
}

</script>
<?php require __DIR__. "/__html_foot.php";?>
