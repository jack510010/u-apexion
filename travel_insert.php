<?php require __DIR__ . "/__connect_db.php";
$title = "新增星座行程列表";
$pageName = "travel_insert";
?>

<style>
    .ti {
        justify-content: center;
        align-items: center;
    }

    .bg_img3 {
        min-height: 100vh;
        background-image: url(./img/0300.jpg);
        background-position: center;
        background-size: cover;
    }
</style>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link text-warning" href="element.php">行程表單</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active text-warning" href="travel_insert.php">新增行程</a>
        </li>
    </ul>
<div class="bg_img3">
    <div class="ti d-flex">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">新增行程列表</h5>
                    <br>
                    <form name="form1" onsubmit="sendData();return false;">
                        <div class="mb-3">
                            <label for="name" class="form-label">行程名稱:</label>
                            <input type="text" class="form-control" id="name" name="name">
                            <div class="form-text"></div>
                        </div>
                        <br>
                        <div class="input-group">
                            <span for="introduction" class="input-group-text">行程介紹填寫:</span>
                            <textarea class="form-control" id="introduction" name="introduction" rows="5"></textarea>
                        </div>
                        <br>
                        <div class="input-group">
                            <span for="attention" class="input-group-text">注意事項填寫:</span>
                            <textarea class="form-control" id="attention" name="attention" rows="5"></textarea>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="price" class="form-label">價位:</label>
                            <input type="text" class="form-control" id="price" name="price">
                            <div class="form-text"></div>
                            <br>
                            <button type="submit" class="btn btn-primary" onclick="return confirm('確定要新增嗎?')">新增</button>
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

        fetch('travel_insert-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
            })
    }
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>