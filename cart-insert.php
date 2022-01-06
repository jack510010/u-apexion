<?php
// 這個是create
include __DIR__ . "/__connect_db.php";
$title = "新增購物車資料";
$pageName = "insert"; // 新增購物車項目
?>

<?php include __DIR__ . "/__html_head.php" ?>
<?php include __DIR__ . "/__navbar.php" ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <form>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">會員編號</label>
                            <input type="text" class="form-control" id="user_id" name="user_id">
                            
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">會員編號</label>
                            <input type="text" class="form-control" id="product_id" name="product_id">
                        </div>
                        <div class="mb-3">
                            <label for="count_number" class="form-label">數量</label>
                            <input type="text" class="form-control" id="count_number" name="count_number">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">加入清單</button>
                    </form>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . "/__scripts.php" ?>
<?php include __DIR__ . "/__html_foot.php" ?>