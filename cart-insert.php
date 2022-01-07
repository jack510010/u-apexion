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
                    <h5 class="card-title">新增購物車資料</h5>
                    <form name="form1" onsubmit="sendData(); return false;">
                        <!--onsubmit 事件會在表單中的確認按鈕被點選時發生。-->
                        <!--不要讓表單用傳統的方式送出，就是指『method="post"』-->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">會員編號</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" >
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">商品編號</label>
                            <input type="text" class="form-control" id="product_id" name="product_id">
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="count_number" class="form-label">數量</label>
                            <input type="text" class="form-control" id="count_number" name="count_number">
                            <div class="form-text text-danger"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">加入清單</button>
                        <!--如果『標籤button』沒有要送出資料的話，裡面的type要下button。就像這樣type="button"-->
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!--這條線以下只是在設定bootstrap modal而已，跟要學的php東西無關，就是讓網頁好看這樣子。-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">資料錯誤</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--這條線以上只是在設定bootstrap modal而已，跟要學的php東西無關，就是讓網頁好看這樣子。-->
<?php include __DIR__ . "/__scripts.php" ?>
<script>
    let user_id = document.querySelector("#user_id");
    let product_id = document.querySelector("#product_id");
    let count_number = document.querySelector("#count_number");

    function sendData() {
        user_id.nextElementSibling.innerHTML = "";
        product_id.nextElementSibling.innerHTML = "";
        count_number.nextElementSibling.innerHTML = "";

        let isPass = true; // 這個變數的用意是說，有沒有通過表單的檢查。
        // 邏輯上的意思是說，我先預設你是通過的。但是！你只要有一個欄位沒通過就算沒通過。
        //todo 檢查表單的資料。 這行以下開始檢查資料。

        if (user_id.value.length < 1 && user_id.value > 0) {
            isPass = false;
            user_id.nextElementSibling.innerHTML = "請輸入正確的會員編號"
        }

        if (product_id.value.length < 1 && product_id.value > 0) {
            isPass = false;
            product_id.nextElementSibling.innerHTML = "請輸入正確的商品編號"
        }
        if (count_number.value.length < 1 && count_number.value > 0) {
            isPass = false;
            count_number.nextElementSibling.innerHTML = "請輸入想下單的數量"
        }
        if (isPass) { // 如果這個值是true的話，我才要發送表單，用AJAX的方式發送。

            let fd = new FormData(document.form1);
            //* 『FormData』可以想成是沒有外觀的表單
            //* 就是把頁面上有外觀的表單的資料全部抓下來，放到這個沒有外觀的表單裡面。

            fetch("cart-insert-api.php", {
                    method: "POST",
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if (obj.success) {
                        alert("商品新增成功");
                        location.href = "cart.php";
                    } else {
                        document.querySelector(".modal-body").innerHTML = obj.error || "商品新增發生錯誤";
                        modal.show();
                    }
                })
        }
    }
</script>
<?php include __DIR__ . "/__html_foot.php" ?>