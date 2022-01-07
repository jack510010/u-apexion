<?php require __DIR__ . '/ua__connect.php';


$title = 'Transportation';
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
<?php include __DIR__ . '/__html_head.php'; ?>
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<style>
    .transports{
            width: 70%;
            margin: 0 auto;
        }
        .transports h1{
            text-align: center;
            color: antiquewhite;
            text-shadow: 5px 8px 10px rgb(67, 195, 255),-5px -3px 10px rgb(67, 255, 230),-15px 2px 15px rgb(255, 253, 133),10px -6px 15px rgb(255, 236, 221);
        }   
        h4{
            color:rgb(109, 160, 184);
        }
    .update-div {
        background-color: rgb(22, 33, 11, .5);
    }
    .form-control, .form-select{
        border:2px solid rgb(67, 195, 255);
        border-radius:50px;
        box-shadow: 7px 5px 15px rgb(67, 195, 255,.4),-7px -3px 15px rgba(67, 255, 214, 0.3) ;
    }
    .btn {
        filter: saturate(.7);
        border-radius:20px;
        box-shadow:inset 5px 8px 10px rgb(67, 195, 255,.5);
    }
</style>
<?php include __DIR__ . '/__navbar.php'; ?>

<section class="transports">
    <form name="transForm" >
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
                <select class="form-select destination-addr" aria-label="Default select example" id="transport" name="transport" >
                    <option selected>What Kind Transportation Do You Want?</option>
                    <?php
                    foreach ($user_country_trans as $i) {
                        foreach ($all_country_trans as $r) {
                            if ($i['country'] == $r['country_trans']) {
                                $new[] = $r;
                            };
                        };
                    };
                    foreach ($all_country_trans as $r) {
                        if ($new[0]['parent_sid'] == $r['sid']) { ?>
                            <option value="<?= $r['country_trans']; ?>">
                                <?= $r['country_trans']; ?>
                            </option>
                        <?php
                        }
                        if ($new[1]['parent_sid'] == $r['sid']) { ?>
                            <option value="<?= $r['country_trans']; ?>">
                                <?= $r['country_trans']; ?>
                            </option>
                        <?php
                        }
                        if ($new[2]['parent_sid'] == $r['sid']) { ?>
                            <option value="<?= $r['country_trans']; ?>">
                                <?= $r['country_trans']; ?>
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
                    <option value="1"> </option>
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
                </div>

        </div>
        <div class="printhere">
        </div>
    </form>


</section>

<?php include __DIR__ . '/__scripts.php'; ?>

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment-with-locales.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>
    const user_country = <?= json_encode($user_country_trans) ?>;
    const boarding = <?= json_encode($boarding) ?>;
    const usercon_box = JSON.parse(JSON.stringify(user_country));
    const bording_box = JSON.parse(JSON.stringify(boarding));
    const aaa = bording_box.filter(plan => plan.bording_location)



    $('#departure-date').datetimepicker({
        format: 'YYYY/MM/DD',
        locale: moment.locale('zh-tw'),
        minDate: moment().add(1, 'days'),
        maxDate: moment().add(30, 'days'),
    });

    // function update() {
    //     var select = document.getElementById('transport');
    //     var option = select.options[select.selectedIndex];
    //     document.getElementById('value').value = option.value;
    //     document.getElementById('text').value = option.text;

    // }
    // update();

    const transport = document.getElementById("transport");

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
        const fd = new FormData(document.transForm);

        fetch('transportation-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                 console.log(obj);
                 if (obj.success) {
                        alert('SUCCESS');
                        location.href = 'trans_input_delet.php';
                    } 
            });
    }
</script>
<?php include __DIR__ . '/__html_foot.php'; ?>