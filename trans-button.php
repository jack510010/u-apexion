<?php require __DIR__ . "/__connect_db.php"; ?>
<?php
$title = 'Transportation';

// $sid = intval($_GET['sid']);
//  fetch()  and  fetchAll()  's different!
$usersql = "SELECT * FROM `user`";
$userlist = $pdo->query($usersql)->fetchAll();

$impt = $pdo->query("SELECT * FROM `trans_mainlist`")->fetchAll();
// if (empty($impt)) {
//     header('Location: transportation.php');
//     exit;
// }
$address_sql = "SELECT  `address` FROM `user`";
$user_add = $pdo->query($address_sql)->fetchAll();
//destination addrss <- only one can select
$destination_sql = "SELECT `training_address` FROM `destination_address`";
$dest_add = $pdo->query($destination_sql)->fetchAll();
// transportation <- for train plan curise
$tpa_sql = "SELECT `transport_kind` FROM `transportation`";
$tpa = $pdo->query($tpa_sql)->fetchAll();
//user_country_trans 裝user  all_country_trans
$user_country_sql = "SELECT `country` FROM `user`";
$user_country_trans = $pdo->query($user_country_sql)->fetchAll();


$country_trans_sql = "SELECT * FROM `country_transportation`";
$all_country_trans = $pdo->query($country_trans_sql)->fetchAll();
//
$board_sql = "SELECT * FROM `boarding_location`";
$boarding = $pdo->query($board_sql)->fetchAll();
// echo json_encode($boarding);

?>
<?php require __DIR__ . "/__html_head.php"; ?>
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
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
</style>
<?php require __DIR__ . "/__navbar.php"; ?>
<section class="transports">
    <?php foreach ($impt as $w) { ?>
        <?php foreach ($userlist as $y) { ?>
            <?php if ($w['user_sid'] == $y['sid']) { ?>


                <div class=" bottonshow">
                    <div class="bd-example col">
                        <div class="buttonb" style="display:flex;flex-direction:row;justify-content:space-evenly;margin-top:20px;">
                            <button class="btn btn-outline-info collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo intval($y['sid']); ?>" aria-expanded="false" aria-controls="collapseExample">
                                <?php echo $y['name']; ?> </button>
                        </div>
                    </div>
                </div>
    <?php }
        }
    } ?>
    <!-- ===================== -->
    <div class="showhere">
        <?php foreach ($impt as $p) { 
             foreach ($userlist as $u) { 
                 if ($p['user_sid'] == $u['sid']) { ?>
                    <!-- ========= -->
                    <div class="collapse " id="collapseExample<?php echo intval($u['sid']); ?>">
                        <div class="card card-body" style="background-color: rgb(00,00,00,.0); color:skyblue; border:none;">
                            <h1>Apexion - Transportation</h1>
                            <div class="outdiv1">
                                <h4>Your Name</h4>
                                <input class="form-control" type="text" value=" <?= $u['name'] ?>" aria-label="readonly input example" readonly>
                                <h4>Destination Address</h4>
                                <input class="form-control" type="text" value=" <?= $p['destination_address_main'] ?>" aria-label="readonly input example" readonly>
                                <h4>Transportation </h4>
                                <input class="form-control" type="text" value=" <?= $p['transportation_way'] ?>" aria-label="readonly input example" readonly>
                                <h4>Boarding Location</h4>
                                <input class="form-control" type="text" value=" <?= $p['boarding_location_main'] ?>" aria-label="readonly input example" readonly>
                                <h4>Departure Date</h4>
                                <input class="form-control" type="text" value=" <?= $p['schedule'] ?>" aria-label="readonly input example" readonly>
                                <h4> Your Seat/Room</h4>
                                <input class="form-control" type="text" value=" <?= $p['seat_main'] ?>" aria-label="readonly input example" readonly>
                            </div>
                            <form name="transForm">
                                <h1>Change This List</h1>
                                <div class="outdiv2">
                                    <h4>Your Address</h4>

                                    <input class="form-control" type="text" value=" <?= $u['address'] ?>" aria-label="readonly input example" readonly>
                                    <h4>Destination Address</h4>
                                    <select class="form-select destination-addr" aria-label="Default select example" name="destination_add">
                                        <option selected>Choose Destination Address</option>
                                        <?php foreach ($dest_add as $dest) { ?><option value="<?= $dest['training_address'] ?>">
                                                <?= $dest['training_address'] ?> <?php } ?></option>
                                    </select>
                                    <h4>What Kind Transportation Do You Want?</h4>
                                    <select class="form-select destination-addr" aria-label="Default select example" name="transport">
                                        <option selected>Choose Your Transportation</option>
                                        <?php
                                            echo json_encode($u);
                                            foreach($all_country_trans as $a){
                                            if($u['contry'] == $a['country_trans']){
                                                
                                            }
                                        }
                                           ;?>
                                            <option selected><?= json_encode($new); ?></option>
                                        <?php foreach ($all_country_trans as $s) {
                                            if ($new[0]['parent_sid'] == $s['sid']) { ?>
                                                <option value="<?= $s['country_trans']; ?>">
                                                    <?= $s['country_trans']; ?>
                                                </option>
                                            <?php
                                            }
                                            if ($new[1]['parent_sid'] == $s['sid']) { ?>
                                                <option value="<?= $s['country_trans']; ?>">
                                                    <?= $s['country_trans']; ?>
                                                </option>
                                            <?php
                                            }
                                            if ($new[2]['parent_sid'] == $s['sid']) { ?>
                                                <option value="<?= $s['country_trans']; ?>">
                                                    <?= $s['country_trans']; ?>
                                                </option>
                                        <?php
                                            }
                                        }  ?>
                                        <!-- HHHEEELLLPP!!!! -->
                                    </select>
                                    <h4>Here Do You Want Board?</h4>
                                    <select class="form-select destination-addr" aria-label="Default select example" name="board">
                                        <option selected>Choose Your boarding Location...</option>
                                        <?php
                                        foreach ($user_country_trans as $u) {
                                            foreach ($boarding as $b) {
                                                if (strpos($b['location_kind'], $u['country']) !== false) {
                                                    $bor[] = $b; ?>
                                                    <option value="<?= $b['location_kind'] ?>">
                                                        <?= $b['location_kind'] ?>
                                                    </option>
                                        <?php
                                                };
                                            }
                                        }
                                        ?>
                                        <option value=""> </option>
                                    </select>
                                    <h4>Select Your Departure Datetime...</h4>
                                    <div class="input-group date" id='departure-date'>
                                        <input type="text" class="form-control" name="date" value="">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar "></i>
                                            <!-- <i class="far fa-calendar-alt"></i> -->
                                        </span>
                                    </div>
                                    <div class="train-seat">
                                        <h4>Choose Your Train Seat...</h4>
                                        <select class="form-select destination-addr" aria-label="Default select example" name="seat">
                                            <option selected>Choose Your Seat...</option>
                                            <option value="1"></option>
                                        </select>
                                    </div>
                                    <div class="plan-seat">
                                        <h4>Choose Your Plan Seat...</h4>
                                        <select class="form-select destination-addr" aria-label="Default select example" name="seat">
                                            <option selected>Choose Your Seat...</option>
                                            <option value="1"></option>
                                        </select>
                                    </div>
                                    <div class="cruise-seat">
                                        <h4>Choose Your Cruise Room...</h4>
                                        <select class="form-select destination-addr" aria-label="Default select example" name="seat">
                                            <option selected>Choose Your Room...</option>
                                            <option value="1"></option>
                                        </select>
                                    </div>
                                    <div class="buttonc" style="display:flex;flex-direction:row;justify-content:space-evenly;margin-top:30px;">
                                        <button type="submit" class="btn btn-outline-info" onclick="sendTransportation(); return false">Done! Send It</button>
                                        <button type="reset" class="btn btn-outline-warning">Oops... Reset</button>
                                        <button class="btn btn-outline-danger " type="button" onclick="delete_it(<?php echo $userlist['sid']; ?>); return false">
                                            Delet The Order!
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
        <?php }
            }
        } ?>
        <!-- ============ -->
    </div>




    <!-- =======show= -->
</section>


<?php require __DIR__ . "/__scripts.php"; ?>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment-with-locales.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $('#departure-date').datetimepicker({
        format: 'YYYY/MM/DD',
        locale: moment.locale('zh-tw'),
        minDate: moment().add(1, 'days'),
        maxDate: moment().add(30, 'days'),
    });

    function sendTransportation() {
        const fd = new FormData(document.transForm);

        fetch('trans_input_delet_api.php', {
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