<?php require __DIR__ . "/__connect_db.php";

if (!isset($_SESSION['admin'])) {
    header('Location: user_login.php');
    exit;
}

$title = '所有會員';
$pageName = 'user_list';

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
// SELECT t.*, s.name FROM `trans_mainlists` t LEFT JOIN `user` s ON t.user_sid = s.sid;
//提取表單資料
$sql = sprintf("SELECT * FROM user ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$user = $pdo->query($sql)->fetchAll();

$country_sql = sprintf( "SELECT u.*, c.country_name FROM `user` u LEFT JOIN `country` c ON u.country_sid = c.sid ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

$country = $pdo->query($country_sql)->fetchAll();


?>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light pt-3 shadow ">
        <div class="container-fluid"><i class="fas fa-laptop-house text-warning"></i>
            <a class="navbar text-warning " href="#" style="text-decoration:none;">所有會員</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">


                    </li>
                    <li class="nav-item dropdown">


                    </li>
                </ul>



                <button type="button" class="btn btn-info"><a class="text-dark" href="user_insert.php"
                        style="text-decoration:none;">新增會員</a></button>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="user_logout.php">登出</a>

                    </li>

                </ul>


            </div>
        </div>
    </nav>

    <!-- 下方列表 -->
    <div class="bd-example p-3">
        <table class="table table-hover text-light" ;>
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

                    <th scope="col">修改</th>
                    <th scope="col">刪除</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($country as $u) { ?>
                
                <tr>
                    <td><?= $u['sid'] ?></td>
                    <td><?= $u['name'] ?></td>
                    <td><?= $u['email'] ?></td>
                    <td><?= $u['password'] ?></td>
                    <td><?= $u['mobile'] ?></td>
                    <td><?= $u['birthday'] ?></td>
                    <td><?= htmlentities($u['address']) ?></td>
                   
                    <td><?= $u ['country_name'];
                       ?></td>
                    <td><?= $u['create-date'] ?></td>

                    <td>
                        <a href="user_edit.php?sid=<?= $u['sid'] ?>">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </td>
                    <td>
                        <a href="javascript: delete_it(<?= $u['sid'] ?>)">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
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
<script>
function delete_it(sid) {
    if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
        location.href = `user_delete.php?sid=${sid}`;
    }
}
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>