<?php
require __DIR__ . "/__connect_db.php";

$title = "星座行程列表";
$pageName = "element";


$perPage = 3;
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$page = $page < 1 ? 1 : $page;


$t_sql = "SELECT COUNT(1) FROM travel";


$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);


$sql = sprintf("SELECT * FROM travel LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$rows = $pdo->query($sql)->fetchAll();

?>

<style>
    i{
     font-size: 30px;
     text-align: center;
     padding: 20px 10px 10px 10px;
    }
</style>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col">
            <?= "$totalRows", "$totalPages" ?>
        </div>
    </div>
    <table class="table table-dark table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col"style="text-align: center;">刪除</th>
                <th scope="col">行程編號</th>
                <th scope="col">行程標題</th>
                <th scope="col">行程介紹</th>
                <th scope="col">注意事項</th>
                <th scope="col">價格</th>
                <th scope="col"style="text-align: center;">修改</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($rows as $r) : ?>

                <tr>
                    <td>
                        <a href="travel_delete.php?sid=<?= $r["sid"] ?>" onclick="return confirm('確定要刪除嗎?')"><i class="fas fa-times-circle"></i></a>
                    </td>
                    <td style="text-align: center;"><?= $r["sid"] ?></td>
                    <td><?= $r["name"] ?></td>
                    <td><?= $r["introduction"] ?></td>
                    <td><?= $r["attention"] ?></td>
                    <td style="font-size:30px;"><?= $r["price"] ?></td>
                    <td>
                        <a href="travel_edit.php?sid=<?= $r["sid"] ?>"><i class="fas fa-pen-nib"></i></a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

</div>
<?php require __DIR__ . "/__scripts.php"; ?>
<?php require __DIR__ . "/__html_foot.php"; ?>