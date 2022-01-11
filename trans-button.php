<?php require __DIR__ . "/__connect_db.php"; ?>
<?php
$title = 'Transportation';


$mainlist_user_sql = "SELECT * FROM trans_mainlists LEFT JOIN user ON trans_mainlists.user_sid=user.sid";
$mainlist_user = $pdo->query($mainlist_user_sql)->fetchAll();

// $tans_country_sql = "SELECT c.sid,c.country_trans,c.parent_sid,t.transport_kind FROM `country_transportation` c LEFT JOIN `transportation` t ON c.parent_sid=t.sid";
// $tans_country = $pdo->query($tans_country_sql)->fetchAll();

$sid = $_GET['sid'];
$user_sql  = "SELECT * FROM `user` WHERE `sid`=".$sid;
$user_data = $pdo->query($user_sql)->fetch();
$user_country_sid = $user_data["country_sid"];

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










?>
<?php require __DIR__ . "/__html_head.php"; ?>
<!-- <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" /> -->
<style>
    .transports {
        width: 70%;
        margin: 0 auto;
    }

    .transports h1 {
        text-align: center;
        color: antiquewhite;
        text-shadow: 5px 5px 10px rgb(00,00,00),5px 8px 10px rgb(67, 195, 255), -5px -3px 10px rgb(67, 255, 230), -15px 2px 15px rgb(255, 253, 133), 10px -6px 15px rgb(255, 236, 221);
    }

    h5 {
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
        border: none;

    }
</style>
<?php require __DIR__ . "/__navbar.php"; ?>

<section class="transports">
    <div class="container" style="display:flex;
    flex-direction:row;
    justify-content:space-evenly;
    padding:20px 0;">

        <?php foreach ($mainlist_user as $mainlists) { ?>
            <a href="./trans-button.php?sid=<?=$mainlists['sid']; ?>" style="margin:10px;" class="btn btn-outline-info collapsed "  data-bs-toggle="" data-bs-target="#collapseExample<?php echo intval($mainlists['user_sid']); ?>" aria-expanded="false" aria-controls="collapseExample">
                <?php echo $mainlists['name']?> No.<?=$mainlists['sid']; ?> </a>
        <?php } ?>
    </div>
    <!-- ===================== -->
    <div class="showhere">
        <?php foreach ($mainlist_user as $mainlists) { ?>
            <!-- ========= -->
            <?php if($mainlists['user_sid'] === $sid) { ?>
            <div class="" id="collapseExample<?php echo intval($mainlists['user_sid']); ?>">
                <div class="card card-body" style="background-color: rgb(00,00,00,.0); color:skyblue; border:none;">
                    <h1>Apexion - Transportation</h1>
                    <div class="outdiv1">
                        <h5>Name</h5>
                        <input class="form-control" type="text" value=" <?= $mainlists['name'] ?>" aria-label="readonly input example" readonly>
                        <h5>Order Number</h5>
                        <input class="form-control" name="user_sid" type="text" value=" <?= $mainlists['sid'] ?>" aria-label="readonly input example" readonly>
                        <h5>Destination Address</h5>
                        <input class="form-control" type="text" value=" <?= $mainlists['destination_address_main'] ?>" aria-label="readonly input example" readonly>
                        <h5>Transportation </h5>
                        <input class="form-control" type="text" value=" <?= $mainlists['transportation_way'] ?>" aria-label="readonly input example" readonly>
                        <h5>Boarding Location</h5>
                        <input class="form-control" type="text" value=" <?= $mainlists['boarding_location_main'] ?>" aria-label="readonly input example" readonly>
                        <h5>Departure Date</h5>
                        <input class="form-control" type="text" value=" <?= $mainlists['schedule'] ?>" aria-label="readonly input example" readonly>
                        <h5> Your Seat/Room</h5>
                        <input class="form-control" type="text" value=" <?= $mainlists['seat_main'] ?>" aria-label="readonly input example" readonly>
                    </div>
                    <form id="transForm">
                        <h1>Change List</h1>
                        
                        <div class="outdiv">
                            <h4>User Address</h4>
                            <input hidden name="sid" value="<?= $user_data['sid'] ?>">
                            <?php foreach ($user_add as $u) { ?>
                                
                                <input  class="form-control" type="text" value=" <?= $u['address'] ?>" <?php } ?> aria-label="readonly input example" readonly>
                                <h4>Destination Address</h4>
                                <select class="form-select destination-addr" aria-label="Default select example" name="destination_add">
                                    <option selected>Choose Destination Address</option>
                                    <?php foreach ($dest_add as $u) { ?><option value="<?= $u['training_address'] ?>">
                                            <?= $u['training_address'] ?> <?php } ?></option>
                                </select>
                                <h4>User Transportation Kind</h4>
                                <select class="form-select destination-addr" aria-label="Default select example" id="transport" name="transport">
                                    <option selected disabled>What Kind Transportation Do You Want?</option>
                                    <?php foreach ($userTrans_view as $b) {   ?>
                                        <option value="<?= $b ?>">
                                            <?= $b ?>

                                        </option>
                                    <?php  }; ?>

                                    <!-- HHHEEELLLPP!!!! -->
                                </select>
                                <div class="board">
                                    <h4>Boarding Location</h4>
                                    <select class="form-select destination-addr" aria-label="Default select example" name="board" id="board">

                                    </select>
                                </div>
                                <h4>Departure Datetime</h4>
                                <div class="input-group date" id='departure-date datetime'>
                                    <input type="text" class="form-control" name="date" value="">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-calendar "></i>
                                        <!-- <i class="far fa-calendar-alt"></i> -->
                                    </span>
                                </div>
                                <div class="seat">
                                    <h4>Room / Seat</h4>
                                    <select class="form-select destination-addr" aria-label="Default select example" name="seat" id="seat">

                                    </select>

                                </div>


                                <div class="buttonc" style="display:flex;flex-direction:row;justify-content:space-evenly;margin-top:30px;">
                                    <button type="submit" class="btn btn-outline-info" onclick="sendTransportation(); return false">Done! Send It</button>
                                    <button type="reset" class="btn btn-outline-warning">Oops... Reset</button>
                                </div>

                        </div>
                    </form>
                </div>
            </div>

            <?php }?>
        <?php } ?>
        <!-- ============ -->
    </div>

    <!-- ======= showhere = -->
</section>


<?php require __DIR__ . "/__scripts.php"; ?>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment-with-locales.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    
    $(function() {
        $('#departure-date').datetimepicker({
            format: "YYYY/MM/DD",
            defaultDate: new Date(),
            locale: moment.locale('zh-tw'),
            maxDate: moment().add(30, 'days'),
            minDate: moment().add(1, 'days'),
        });
    });

    <?php $boarding_view_dto = json_encode($boarding_view) ?>
    <?php $seats_view_dto = json_encode($seats_view) ?>

    let boradData = <?php echo $boarding_view_dto ?>;
    let seatsData = <?php echo $seats_view_dto ?>;
        console.log('boradData',boradData);
        console.log('sssssssssssss');
        console.log(seatsData);

    const transport = document.querySelector('#transport');
    transport.addEventListener('change',test);
    function test() {


        // let transportSelect = ''
        transportSelect = document.getElementById('transport').value;
        //

        $('#board').find('option').remove();
        boradData[transportSelect].forEach(element => {
            $('#board').append("<option>" + element + "</option>")
        });


        $('#seat').find('option').remove();
        seatsData[transportSelect].forEach(element => {
            $('#seat').append("<option>" + element + "</option>")
        });
    }

    function sendTransportation() {
        const fd = new FormData(document.querySelector('#transForm'));

        fetch('trans_button_api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('SUCCESS');
                    location.href = 'product.php';
                }
            });

    }

    function delete_it(sid) {
        if (confirm(`Are You Sure You Want To Delet This Order?`)) {
            location.href = `trans_input_delet_delet_api.php?sid=${sid}`;
        }
    }
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>