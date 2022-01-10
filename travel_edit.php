<?php require __DIR__ . "/__connect_db.php";
$title = "修改星座行程列表";
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
    .te {
        justify-content: center;
        align-items: center;
    }

    .bg_img4 {
        min-height: 100vh;
        background-image: url(./img/0302.jpg);
        background-position: center;
        background-size: cover;
    }
</style>

<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="element.php">回行程表單</a>
    </li>
</ul>
<div class="bg_img4">
    <div class="te d-flex">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">修改行程列表</h5>
                    <br>
                    <form name="form1" onsubmit="sendData();return false;">
                        <input type="hidden" name="sid" value="<?= $row['sid'] ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">行程名稱:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($row['name']) ?>">
                            <div class="form-text"></div>
                        </div>
                        <br>
                        <div class="input-group">
                            <span for="introduction" class="input-group-text">行程介紹填寫:</span>
                            <textarea class="form-control" id="introduction" name="introduction" rows="5"><?= trim($row['introduction']) ?></textarea>
                        </div>
                        <br>
                        <div class="input-group">
                            <span for="attention" class="input-group-text">注意事項填寫:</span>
                            <textarea class="form-control" id="attention" name="attention" rows="5"><?= trim($row['attention'])  ?></textarea>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="price" class="form-label">價錢:</label>
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