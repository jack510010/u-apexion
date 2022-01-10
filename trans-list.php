<?php require __DIR__ . "/__connect_db.php"; ?>
<?php
$title = 'Transportation';

$perPage = 5;

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


$sql = sprintf("SELECT t.*, s.name FROM `trans_mainlists` t LEFT JOIN `user` s ON t.user_sid = s.sid ORDER BY t.sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$rows = $pdo->query($sql)->fetchAll();


// $main_list_sql = "SELECT t.*, s.name FROM `trans_mainlists` t LEFT JOIN `user` s ON t.user_sid = s.sid";
// $main_list = $pdo->query($main_list_sql)->fetchAll();

?>
<?php require __DIR__ . "/__html_head.php"; ?>
<!-- <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" /> -->
<style>
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
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
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


        <div class="row">
            <div class="col">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            
                            <th scope="col"><i class="fas fa-trash-alt"></i></th>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
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
                               
                                <td>
                                    
                                    <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                                <td><?= $r['sid'] ?></td>
                                <td><?= htmlentities($r['name']) ?></td>
                                <td><?= htmlentities($r['destination_address_main']) ?></td>
                                <td><?= $r['transportation_way'] ?></td>
                                <td><?= $r['schedule'] ?></td>
                                <td><?= $r['boarding_location_main'] ?></td>
                                <td><?= $r['seat_main'] ?></td>

                                <td>
                                    <a href="transportation.php?sid=<?= $r['sid'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach;  ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    </div>
</section>


<?php require __DIR__ . "/__scripts.php"; ?>

<script type="text/javascript">
    function delete_it(sid) {
        if (confirm(`Are You Sure You Want To Delet This Order?`)) {
            location.href = `trans_input_delet_delet_api.php?sid=${sid}`;
        }
    }
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>