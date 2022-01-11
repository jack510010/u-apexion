<?php require __DIR__ . "/__connect_db.php"; ?>
<?php
$title = 'Transportation';

$perPage = 6;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: list.php');
    exit;
}


$t_sql = "SELECT COUNT(1) FROM trans_mainlists";

// 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);
if ($page > $totalPages) {
    header('Location: list.php?page=' . $totalPages);
    exit;
}


$sql = sprintf("SELECT t.*, s.name FROM `trans_mainlists` t LEFT JOIN `user` s ON t.user_sid = s.sid ORDER BY t.sid ASC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$rows = $pdo->query($sql)->fetchAll();




?>
<?php require __DIR__ . "/__html_head.php"; ?>

<style>

    .container-wrap{
       z-index: -2;
       /* opacity: .9; */
    }
    .transports {
        width: 70%;
        margin: 0 auto;
    }

    .table,
    .table-striped,
    .table-bordered {
        color: azure;
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
        color: lightcyan;
    }

    .trstyle {
        text-align: center;
        color: rgb(164, 255, 243);
        font-size: 20px;
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

<video class="vdo" playsinline="" loop="loop" autoplay="autoplay" style=" width: 120%; height: 120%; position: fixed;left:-8%;filter:brightness(.6);z-index:-1">
    <source src="https://assets.mixkit.co/videos/preview/mixkit-stars-in-the-sky-rotating-10011-large.mp4" type="video/mp4">
</video>


<section class="transports" style="object-fit:cover; z-index:1; ">
    <div class="container">


    
        <div class="row">
            <div class="col">
                <div class="not" style="margin-bottom:50px;"></div>
                <h1>Apexion - Transportation</h1>
                <a href="./trans-button.php?sid=2" style="margin:10px;" class="btn btn-outline-light collapsed " >
            Back To Babo</a>
                <table class="table">

                    <thead>
                        <tr class="trstyle">

                            <th scope="col">#</th>
                            <th scope="col" style="color:rgb(164, 255, 243); font-size:20px; text-align:center">Name</th>
                            <th scope="col">Destination Address</th>
                            <th scope="col">Transportation</th>
                            <th scope="col">Schedule</th>
                            <th scope="col">Boarding Location</th>
                            <th scope="col">Seat / Room</th>
                            <th scope="col"><i class="fas fa-edit"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r) : ?>
                            <tr>
                                <td><?= $r['sid'] ?></td>
                                <td style="color:rgb(164, 255, 243) ; font-size:20px; text-align:center"><?= htmlentities($r['name']) ?></td>
                                <td><?= htmlentities($r['destination_address_main']) ?></td>
                                <td style=" font-size:15px; text-align:center "><?= $r['transportation_way'] ?></td>
                                <td><?= $r['schedule'] ?></td>
                                <td><?= $r['boarding_location_main'] ?></td>
                                <td><?= $r['seat_main'] ?></td>

                                <td>
                                    <a href="trans_input_delet.php?sid=<?= $r['sid'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;  ?>

                    </tbody>

                </table>
            </div>
        </div>
        <div class="row" style="opacity: .6;">
            <div class="col">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-sm justify-content-center">
                        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 ?>">
                                <i class="fas fa-arrow-circle-left"></i>
                            </a></li>

                        <?php for ($i = $page - 2; $i <= $page + 2; $i++)
                            if ($i >= 1 && $i <= $totalPages) :
                        ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endif; ?>
                        <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>">
                                <i class="fas fa-arrow-circle-right"></i>
                            </a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


</section>


</div>

<?php require __DIR__ . "/__scripts.php"; ?>


<?php require __DIR__ . "/__html_foot.php"; ?>