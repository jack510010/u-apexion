<?php require __DIR__ . "/__connect_db.php"; ?>
<?php
$title = 'Transportation';

if (!isset($_GET['sid'])) {
    header('Location: trans-list.php');
    exit;
}
$order_sid = $_GET['sid'];

$trans_sid_sql = "SELECT * FROM trans_mainlists  WHERE sid=$order_sid";
$trans_sid = $pdo->query($trans_sid_sql)->fetch();

$user_sql  = "SELECT * FROM `user` WHERE `sid`=" . $trans_sid['user_sid'];
$user_data = $pdo->query($user_sql)->fetch();
$user_country_sid = $user_data["country_sid"];

echo  $trans_sid['user_sid'];

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

$boarding_sql = "SELECT * FROM `boarding_location` WHERE `country_sid`= $user_country_sid";
$boarding = $pdo->query($boarding_sql)->fetchAll();

foreach ($boarding as $key => $value) {
    $boarding_view[$transportationList[$value['trans_sid']]][] = $value['name'];
}

$address_sql = "SELECT  `address` FROM `user`";
$user_add = $pdo->query($address_sql)->fetchAll();

$destination_sql = "SELECT `training_address` FROM `destination_address`";
$dest_add = $pdo->query($destination_sql)->fetchAll();


?>
<?php require __DIR__ . "/__html_head.php"; ?>

<style>
    .transports {
        width: 70%;
        margin: 0 auto;
    }

    .transports h1 {
        text-align: center;
        color: antiquewhite;
        text-shadow: 5px 5px 10px rgb(00, 00, 00), 5px 8px 10px rgb(67, 195, 255), -5px -3px 10px rgb(67, 255, 230), -15px 2px 15px rgb(255, 253, 133), 10px -6px 15px rgb(255, 236, 221);
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

    #navbar {
        z-index: 1;
    }
</style>
<?php require __DIR__ . "/__navbar.php"; ?>
<section class="transports">


    <h1>Apexion - Transportation</h1>
    <div class="outdiv">
        <h4>Your Name</h4>
        <input class="form-control" type="text" value=" <?= $user_data['name'] ?>" aria-label="readonly input example" readonly>

        <h4>Destination Address</h4>
        <input class="form-control" type="text" value=" <?= $trans_sid['destination_address_main'] ?>" aria-label="readonly input example" readonly>

        <h4>Transportation </h4>
        <input class="form-control" type="text" value=" <?= $trans_sid['transportation_way'] ?>" aria-label="readonly input example" readonly>

        <h4>Boarding Location</h4>
        <input class="form-control" type="text" value=" <?= $trans_sid['boarding_location_main'] ?>" aria-label="readonly input example" readonly>

        <h4>Departure Date</h4>
        <input class="form-control" type="text" value=" <?= $trans_sid['schedule'] ?>" aria-label="readonly input example" readonly>


        <h4> Your Seat/Room</h4>
        <input class="form-control" type="text" value=" <?= $trans_sid['seat_main'] ?>" aria-label="readonly input example" readonly>

    </div>

    <div class="bd-example">
        <div class="buttonb" style="display:flex;flex-direction:row;justify-content:space-evenly;margin-top:20px;">

            <button class="btn btn-outline-info collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Change The Order!
            </button>

            <button class="btn btn-outline-danger " type="button" onclick="delete_it(<?= $trans_sid['user_sid']; ?>); return false">
                Delet The Order!
            </button>

        </div>
        <div class="collapse" id="collapseExample">
            <div class="card card-body" style="background-color: rgb(00,00,00,.0); color:skyblue; border:none;">

                <form id="transFormData">
                    <h1>Apexion - Transportation</h1>
                    <div class="outdiv">
                        <input hidden name="sid" value="<?= $order_sid ?>">
                        <h4>Your Address</h4>
                        <input class="form-control" type="text" value=" <?= $user_data['address'] ?>" aria-label="readonly input example" readonly>
                        <h4>Destination Address</h4>
                        <select class="form-select destination-addr" aria-label="Default select example" name="destination_add" id="destination_add">
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
                            <input type="date" class="form-control" name="date" value="">

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
    </div>
</section>
<?php require __DIR__ . "/__scripts.php"; ?>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

<script>
    <?php $boarding_view_dto = json_encode($boarding_view) ?>
    <?php $seats_view_dto = json_encode($seats_view) ?>

    let boradData = <?php echo $boarding_view_dto ?>;
    let seatsData = <?php echo $seats_view_dto ?>;

    //console.log(boradData)
    transport.addEventListener('change', test);

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

    function sendTransportation() {
        const fd = new FormData(document.querySelector('#transFormData'));

        fetch('trans_input_delet_api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('SUCCESS');
                    location.href = 'trans-list.php';
                }
            });

    }

    function delete_it(sid) {
        if (confirm(`Do You Sure To Delete This Order?`)) {
            location.href = `trans_input_delet_delet_api.php?sid=${sid}`;
        } else {
            alert('????')
        }
    }
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>