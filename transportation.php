<?php require __DIR__ . '/__connect_db.php';
$title = 'Transportation';
if(! isset($_GET['sid'])) {
    header('Location: trans-list.php');
    exit;
}

$sid = intval($_GET['sid']);


$user_sql  = "SELECT * FROM `user` WHERE `sid`=$sid ";
$user_country_sid = json_encode($pdo->query($user_sql)->fetch()["country_sid"]);

$transportation_sql = "SELECT * FROM `transportation`";
$transportation = $pdo->query($transportation_sql)->fetchAll();
//transportation有sid,trans_kind,  用sid當陣列    印出{"1":"train","2":"plan","3":"curise"}
$user_transport_sql = "SELECT * FROM `country_transportation` WHERE `country_sid`= $user_country_sid";
$user_transport = $pdo->query($user_transport_sql)->fetchAll();

foreach ($transportation as $value) {
    $transportationList[$value['sid']] = $value['transport_kind'];
}

foreach ($user_transport as $key => $value) {
    $userTrans_view[$key] = $transportationList[$value['trans_sid']];
}


$seats_sql = "SELECT * FROM `seats`";
$seats = $pdo->query($seats_sql)->fetchAll();

foreach ($seats as $value) {
    $seats_view[$transportationList[$value['trans_sid']]][] = $value['seat_kind'];
}

// echo json_encode($seats_view);




$boarding_sql = "SELECT * FROM `boarding_location` WHERE `country_sid`= $user_country_sid";
$boarding = $pdo->query($boarding_sql)->fetchAll();

foreach ($boarding as $key => $value) {
    $boarding_view[$transportationList[$value['trans_sid']]][] = $value['name'];
}





// $sql = "SELECT `address` FROM `user`";
// $stmt = $pdo->query($sql);
// $data = $stmt->fetch();
// echo json_encode($data);

// user's address <- for outset
$address_sql = "SELECT  `address` FROM `user`";
$user_add = $pdo->query($address_sql)->fetchAll();
//destination addrss <- only one can select
$destination_sql = "SELECT `training_address` FROM `destination_address`";
$dest_add = $pdo->query($destination_sql)->fetchAll();
// transportation <- for train plan curise

//user_country_trans 裝user  all_country_trans
// $user_country_sql = "SELECT * FROM `user`";
// $user_country_sid = $pdo->query($user_country_sql)->fetchAll();

// $transport_sql = "SELECT * FROM `transportation`";
// $transport_id = $pdo->query($transport_sql)->fetchAll();





$country_trans_sql = "SELECT * FROM `country`";
$all_country_trans = $pdo->query($country_trans_sql)->fetchAll();
//
$board_sql = "SELECT * FROM `boarding_location`";
$boarding = $pdo->query($board_sql)->fetchAll();
// echo json_encode($boarding);

?>
<?php include __DIR__ . '/__html_head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />

<style>
    .transports {
        width: 70%;
        margin: 0 auto;
    }

    .transports h1 {
        text-align: center;
        color: antiquewhite;
        text-shadow: 5px 8px 10px rgb(67, 195, 255), -5px -3px 10px rgb(67, 255, 230), -15px 2px 15px rgb(255, 253, 133), 10px -6px 15px rgb(255, 236, 221);
    }

    h4 {
        color: rgb(109, 160, 184);
    }

    .update-div {
        background-color: rgb(22, 33, 11, .5);
    }

    .form-control,
    .form-select {
        border: 2px solid rgb(67, 195, 255);
        border-radius: 50px;
        box-shadow: 7px 5px 15px rgb(67, 195, 255, .4), -7px -3px 15px rgba(67, 255, 214, 0.3);
    }

    .btn {
        filter: saturate(.7);
        border-radius: 20px;
        box-shadow: inset 5px 8px 10px rgb(67, 195, 255, .5);
    }
    .date {
        filter: saturate(.7);
        border-radius: 20px;
        box-shadow: inset 5px 8px 10px rgb(67, 195, 255, .5);
    }
</style>
<?php include __DIR__ . '/__navbar.php'; ?>

<section class="transports">
    <form id="transForm">
        <h1>Apexion - Transportation</h1>
        <div class="outdiv">
            <h4>Your Address</h4>
            <?php foreach ($user_add as $u) { ?>
                <input class="form-control" type="text" value=" <?= $u['address'] ?>" <?php } ?> aria-label="readonly input example" readonly>
                <h4>Destination Address</h4>
                <select class="form-select destination-addr" aria-label="Default select example" name="destination_add">
                    <option selected>Choose Destination Address</option>
                    <?php foreach ($dest_add as $u) { ?><option value="<?= $u['training_address'] ?>">
                            <?= $u['training_address'] ?> <?php } ?></option>
                </select>
                <h4>What Kind Transportation Do You Want?</h4>
                <select class="form-select destination-addr" aria-label="Default select example" id="transport" name="transport" onchange="test()">
                    <option selected disabled>What Kind Transportation Do You Want?</option>
                    <?php foreach ($userTrans_view as $b) {   ?>
                        <option value="<?= $b ?>">
                            <?= $b ?>

                        </option>
                    <?php  }; ?>

                    <!-- HHHEEELLLPP!!!! -->
                </select>
                <div class="board">
                    <h4>Here Do You Want Board?</h4>
                    <select class="form-select destination-addr" aria-label="Default select example" name="board" id="board">

                    </select>
                </div>
                <h4>Select Your Departure Datetime...</h4>
                <div class="input-group" id='departure-date datetime'>
                    <input id="date" type="date" class="form-control date" name="myDate" value="">
                    
                      
                        <!-- <i class="far fa-calendar-alt"></i>
                    <input type="date" class="form-control" id="birthday" name="birthday"> -->
                    
                </div>
                <div class="seat">
                    <h4>Chosse Your Seat?</h4>
                    <select class="form-select destination-addr" aria-label="Default select example" name="seat" id="seat">

                    </select>

                </div>


                <div class="buttonc" style="display:flex;flex-direction:row;justify-content:space-evenly;margin-top:30px;">
                    <button type="submit" class="btn btn-outline-info" onclick="sendTransportation(); return false">Done! Send It</button>
                    <button type="reset" class="btn btn-outline-warning">Oops... Reset</button>
                </div>

        </div>

    </form>


</section>
<?php include __DIR__ . '/__scripts.php'; ?>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

<script>
    
    <?php $boarding_view_dto = json_encode($boarding_view) ?>
    <?php $seats_view_dto = json_encode($seats_view) ?>

    let boradData = <?php echo $boarding_view_dto ?>;
    let seatsData = <?php echo $seats_view_dto ?>;

    //console.log(boradData)

    function test() {

        // let transportSelect = ''
        transportSelect = document.getElementById('transport').value;
        //alert(transportSelect)

        $('#board').find('option').remove();
        boradData[transportSelect].forEach(element => {
            $('#board').append("<option>" + element + "</option>")
        });


        $('#seat').find('option').remove();
        seatsData[transportSelect].forEach(element => {
            $('#seat').append("<option>" + element + "</option>")
        });
    }
    // if(!transportSelect) {
    //     document.getElementsByClassName('board')[0].style.display = 'none';
    //     document.getElementsByClassName('seat')[0].style.display = 'none';
    // } else {
    //     document.getElementsByClassName('board')[0].style.display = 'block';
    //     document.getElementsByClassName('seat')[0].style.display = 'block';

    //     console.log(transportSelect)
    //     if(transportSelect === 'plan') {
    //         document.getElementsByClassName('plan')[0].style.display = 'block';
    //         document.getElementsByClassName('curise')[0].style.display = 'none';
    //         document.getElementsByClassName('train')[0].style.display = 'none';
    //         document.getElementsByClassName('plan')[1].style.display = 'block';
    //         document.getElementsByClassName('curise')[1].style.display = 'none';
    //         document.getElementsByClassName('train')[1].style.display = 'none';
    //     }
    //     if( transportSelect === 'curise') {
    //         document.getElementsByClassName('plan')[0].style.display = 'none';
    //         document.getElementsByClassName('curise')[0].style.display = 'block';
    //         document.getElementsByClassName('train')[0].style.display = 'none';
    //         document.getElementsByClassName('plan')[1].style.display = 'none';
    //         document.getElementsByClassName('curise')[1].style.display = 'block';
    //         document.getElementsByClassName('train')[1].style.display = 'none';
    //     }
    //     if( transportSelect === 'train') {
    //         document.getElementsByClassName('plan')[0].style.display = 'none';
    //         document.getElementsByClassName('curise')[0].style.display = 'none';
    //         document.getElementsByClassName('train')[0].style.display = 'block';
    //         document.getElementsByClassName('plan')[1].style.display = 'none';
    //         document.getElementsByClassName('curise')[1].style.display = 'none';
    //         document.getElementsByClassName('train')[1].style.display = 'block';
    //     }
    // }



    // transport.addEventListener("click", function() {
    //     var options = transport.querySelectorAll("option");
    //     var count = options.length;
    //     if (typeof(count) === "undefined" || count < 2) {
    //         addActivityItem();
    //     }
    // });

    // transport.addEventListener("change", function() {
    //     if (transport.value == "train") {
    //         console.log("PERFECT");
    //         train();
    //     }
    //     if (transport.value == "plan") {
    //         console.log("GOOD");
    //         plan();
    //     }
    //     if (transport.value == "cruise") {
    //         console.log("NIce");
    //         curise();
    //     }

    // });

    // function train() {
    //     var train_bord = `<option value=""> </option>`;
    //     if (usercon_box[0].country === "") {}


    // };

    // function plan() {

    // };

    // function curise() {

    // };

    function sendTransportation() {
        const fd = new FormData(document.querySelector('#transForm'));
        fetch('transportation-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                //console.log(obj);
                if (obj.success) {
                    alert('SUCCESS');
                    location.href = 'trans_input_delet.php';
                } else {
                    console.log(obj);
                    alert('xxx');
                    
                }
            });
    }
</script>




<?php include __DIR__ . '/__html_foot.php'; ?>