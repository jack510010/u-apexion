<?php require __DIR__ . "/__connect_db.php";
$title = '所有會員';
//幾筆資料一頁
$perPage = 3;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: user_list.php');
    exit;
}

$t_sql = "SELECT COUNT(1) FROM user";
// 算總比數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);
if ($page > $totalPages) {
    header('Location: user_list.php?page=' . $totalPages);
    exit;
}

//提取表單資料
$sql = sprintf("SELECT * FROM user ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$user = $pdo->query($sql)->fetchAll();
?>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light pt-3 shadow ">
        <div class="container-fluid"><i class="fas fa-laptop-house text-warning"></i>
            <a class="navbar text-warning " href="user_list.php" style="text-decoration:none;">所有會員</a>




            <button type="button" class="btn btn-info"><a class="text-dark" href="user_insert.php"
                    style="text-decoration:none;">新增會員</a></button>


        </div>
    </nav>
</div>
<!-- 下方列表 -->
<div class="bd-example p-3">
    <table class="table table-hover text-light">
        <thead>
            <tr class="text-info">
                <th scope="col">#</th>
                <th scope="col">姓名</th>

                <th scope="col">信箱</th>
                <th scope="col">密碼</th>
                <th scope="col">手機</th>
                <th scope="col">生日</th>
                <th scope="col">地址</th>


                <th scope="col">國籍</th>
                <th scope="col">新增時間</th>
                <th scope="col">修改時間</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user as $u) : ?>
            <tr>
                <td><?= $u['sid'] ?></td>
                <td><?= $u['name'] ?></td>

                <td><?= $u['email'] ?></td>
                <td><?= $u['password'] ?></td>
                <td><?= $u['mobile'] ?></td>
                <td><?= $u['birthday'] ?></td>
                <td><?= htmlentities($u['address']) ?></td>


                <td><?= $u['country'] ?></td>
                <td><?= $u['create-date'] ?></td>
                <td><?= $u['update-date'] ?></td>
                <td><i class="fas fa-pencil-alt"></i></td>
                <td><i class="fas fa-trash-alt"></i></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col text-warning d-flex justify-content-end align-items-center">
            <p class="px-2">共有<?= $totalRows ?>筆資料</p>
            <nav aria-label="Page navigation example">
                <ul class="pagination pagination">
                    <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = $page - 2; $i <= $page + 2; $i++)
                        if ($i >= 1 && $i <= $totalPages) :
                    ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endif; ?>
                    <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>
</div>

<?php require __DIR__ . "/__scripts.php"; ?>
<?php require __DIR__ . "/__html_foot.php"; ?>