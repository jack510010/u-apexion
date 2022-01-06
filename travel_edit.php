<?php require __DIR__ . "/__connect_db.php";
$title = "新增星座行程列表";
$pageName = "travel_edit";

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
</style>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改行程列表</h5>
                    <br>
                    <form name="form1" onsubmit="sendData();return false;">
                    <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">行程名稱</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($row['name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <br>
                        <div class="input-group">
                            <span for="introduction" class="input-group-text">行程介紹填寫</span>
                            <textarea class="form-control" id="introduction" name="introduction" rows="5">
                                <?= $row['introduction'] ?></textarea>
                        </div>
                        <br>
                        <div class="input-group">
                            <span for="attention" class="input-group-text">注意事項填寫</span>
                            <textarea class="form-control" id="attention" name="attention" rows="5">
                                <?= $row['attention'] ?></textarea>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="price" class="form-label">價錢</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?= htmlentities($row['price']) ?>">
                            <div class="form-text"></div>
                            <br>
                            <button type="submit" class="btn btn-primary" onclick="return confirm('注意!!確定修改嗎!?')">修改</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require __DIR__ . "/__scripts.php"; ?>
<script>
    function sendData() {
        const fd = new FormData(document.form1);

        fetch('travel_edit-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
            })
    }
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>