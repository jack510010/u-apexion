<?php require __DIR__ . "/__connect_db.php";
$title = "新增星座行程列表";
$pageName = "travel_select";

if (!isset($_GET['sid'])) {
    header('Location:element.php');
    exit;
}

$sid = intval($_GET['sid']);
$row = $pdo->query("SELECT * FROM `travel` WHERE sid=$sid")->fetch();
if (empty($row)) {
    header('Location:element.php');
    exit;
}





?>




<style>
    .row {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .next{
        margin-top: 10px;
    }
</style>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">行程清單:</h1>
                    <br>
                    <form name="form1" onsubmit="sendData();return false;">
                    <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="mb-3">
                            <label for="name" class="input-group-text">行程名稱</label>
                            <td><br><?= $row["name"] ?></td>
                            <div class="form-text"></div>
                        </div>
                        <br>
                        <div class="mb-3">
                            <span for="introduction" class="input-group-text">行程介紹填寫</span>
                            <td><?= $row["introduction"] ?></td>
                        </div>
                        <br>
                        <div class="mb-3">
                            <span for="attention" class="input-group-text">注意事項</span>
                            <td><?= $row["attention"] ?></td>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="price" class="input-group-text">價位</label>
                            <td style="font-size:30px;"><br>$<?= $row["price"] ?></td>
                            <div class="form-text"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="d-grid gap-2 col-6 mx-auto" href="ticket_insert.php"><button class="next btn btn-primary" type="button">Next</button></a>




<?php require __DIR__ . "/__scripts.php"; ?>
<script>
    function sendData() {
        const fd = new FormData(document.form1);

        fetch('travel_select-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
            })
    }
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>