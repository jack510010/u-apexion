<?php
require __DIR__ . "/__connect_db.php";

$flightsql = 'SELECT `flight_time` FROM `flight`';
$flightrows = $pdo->query($flightsql)->fetchAll();
$seatsql = 'SELECT * FROM `flight_seat`';
$seatrows = $pdo->query($seatsql)->fetchAll();
// echo json_encode($flightrows);
$pageName = 'ticket_insert';
?>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>

<form class="ticket-form mt-3" name="ticketForm">
    <h2 class="mb-3">新增訂票資訊</h2>
    <div class="mb-3">
        <div class="d-flex align-items-center ticket-wrap">
            <label for="exampleInputEmail1"
                class=" align-self-stretch d-flex align-items-center justify-content-center">啟航日程</label>
            <select required id="flightTime" class="ticket-form-select form-select form-control flex-fill"
                aria-label="Default select example" name="flightTime">
                <option selected disabled>請選擇日程</option>
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
            <label for="exampleInputEmail1"
                class="form-label  d-flex align-items-center justify-content-center align-self-stretch">旅遊行程</label>
            <select id="trip" class="ticket-form-select form-select form-control flex-fill"
                aria-label="Default select example" name="trip" required>
                <option selected disabled>請選擇行程</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
        <div class="ticket-incorrect"></div>
    </div>
    <div class="mb-3">
        <div class="d-flex align-items-center ticket-wrap">
            <label for="exampleInputEmail1"
                class="form-label  d-flex align-items-center justify-content-center align-self-stretch">艙等</label>
            <select required id="seatlvl" class="ticket-form-select form-select form-control flex-fill"
                aria-label="Default select example" name="seatLevel">
                <option selected disabled>請選擇艙等</option>
                <?php foreach ($seatrows as $r) { ?>
                <option><?= $r['level'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="ticket-incorrect"></div>
    </div>
    <div class="mb-3">
        <div class="d-flex align-items-center ticket-wrap">
            <label for="exampleInputEmail1"
                class="form-label  d-flex align-items-center justify-content-center align-self-stretch flex-grow-1">人數</label>
            <input type="number" maxlength="2" class="form-control " id="members" placeholder="請輸入人數(上限10人)"
                name="memberNumber" required>
            <button class="member-confirm d-flex align-items-center justify-content-center align-self-stretch"
                onclick="memberCount(); return false;">確認</button>
        </div>
        <div class="ticket-incorrect "></div>
    </div>
    <div class="member-input">
    </div>
    <button type="submit" class="ticketBtn btn-primary px-4 py-1" onclick="sendTicketForm(); return false">送出</button>
</form>

<?php require __DIR__ . "/__scripts.php"; ?>

<script>
const memberInput = `<div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="membername" class="memberName form-label  d-flex align-items-center justify-content-center align-self-stretch">成員姓名</label>
    <input type="text" class="form-control flex-fill" id="membername" aria-describedby="emailHelp" name="member[]" placeholder="請輸入護照英文名字">
    </div>
    <div class="ticket-incorrect"></div>
  </div><div class="mb-3">
    <div class="d-flex align-items-center ticket-wrap">
    <label for="memberPass" class="memberPassport form-label  d-flex align-items-center justify-content-center align-self-stretch">護照上傳</label>
    <input type="file" class="form-control UploadPas flex-fill" id="memberPass" name="memberPass[]">
    </div>
    <div class="ticket-incorrect"></div>
  </div>`;

function memberCount() {
    document.querySelector(".member-input").innerHTML = "";
    const membernum = members.value;
    console.log(membernum);
    for (let i = 1; i <= membernum; i++) {
        if (i <= 10) {
            document.querySelector(".member-input").innerHTML += memberInput;
            const memberInputTitle = document.querySelectorAll("label");
            memberInputTitle.forEach(function(v) {
                if (v.classList.contains("memberName")) {
                    v.setAttribute('style', `background-color: #048ABF`);
                    // console.log(memberInputTitle);
                } else if (v.classList.contains("memberPassport")) {
                    v.setAttribute('style', `background-color: #023E73`);
                }
            })
            document.querySelector(".ticketBtn").style = "display: block";
        } else {
            alert("超過人數上限10人，請重新輸入人數");
            document.querySelector(".member-input").innerHTML = "";
            document.querySelector(".ticketBtn").style = "display: none";
            break;
        }
    }

}

function sendTicketForm() {
    const fd = new FormData(document.ticketForm);
    let isPass = true;

    if (flightTime.value == "0000-00-00 00:00:00") {
        isPass = false;
        alert("請選擇日程");
    }
    if (trip.value.length == 0) {
        isPass = false;
        alert("請選擇行程");
    }
    if (seatlvl.value.length == 0) {
        isPass = false;
        alert("請選擇艙等");
    }
    if (members.value.length == 0) {
        isPass = false;
        alert("請輸入人數");
    }

    // const isEnglish = /^[A-Za-z]+$/;
    // if(membername.value.length == 0 | isEnglish.test(membername.value) == false){
    //   isPass = false;
    //   alert("請輸入護照英文姓名");
    // } 

    if (isPass) {
        fetch("ticket_insert_api.php", {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(txt => {
                if (txt.success) {
                    console.log(txt.memberpass);
                    location.href = "ticket_myticket.php";
                } else {
                    alert(txt.error);
                }
            });
    }
}
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>