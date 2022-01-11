<?php
include __DIR__ . "/__connect_db.php";
if (!isset($_SESSION['admin'])) {
    header('Location: user_login.php');
    exit;
}

$title = "清單資料";

if (!isset($_GET["sid"])) {             // 如果沒有這個值就直接返回列表頁，不讓你繼續往下做。
    // 因為你沒有給參數，我不知道你要改什麼。
    header("location: cart.php");
    exit;
}

$sid = intval($_GET["sid"]);  // 這邊拿到的一定是整數，因為有intval。

$row = $pdo->query("SELECT * FROM `cart` WHERE sid = $sid")->fetch();
// 執行完sql後就拿一筆資料。拿到的是primary key， 因為是sid。
// 執行後的結果就兩種可能，有拿到跟沒拿到，沒拿到就是沒有東西。
// 所以接下來就做if判斷。

if (empty($row)) {                        // 如果$row是空的，就讓你回列表頁。
    header("location: cart.php");
    exit;  // 正常的狀況我連過去會得到一個參數，指定某一筆的參數。
    // 若沒有這個參數就讓你回列表頁。
}
?>
<?php include __DIR__ . "/__html_head.php" ?>

<?php include __DIR__ . "/__navbar.php" ?>

    <div class="container">
        <div class="rol">
            <div class="col-md-12">
                <div class="card-body">
                    <div class="col d-flex justify-content-between">
                        <h5 class="card-title text-warning">修改購物車清單</h5>
                        <a class="btn btn-info" href="cart.php" role="button">返回</a>
                    </div>
                </div>
                <div class="card-body col-md-6">
                    <form name="form1" onsubmit="sendData();return false;">
                        <!--onsubmit 事件會在表單中的確認按鈕被點選時發生。-->
                        <!--不要讓表單用傳統的方式送出，就是指『method="post"』-->
                        <input type="hidden" name="sid" value="<?= $row["sid"] ?>">
                        <div class="mb-3">
                            <label for="user_id" class="form-label text-light">會員編號</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" value="<?= htmlentities($row["user_id"]) ?>">
                            <!--value是為了讓你進去修改頁面的時候，已把值show在該欄位上-->
                            <!--htmlentities 讓姓名可以有『大於小於單引號之類的符號』-->
                            <!--『required』可以讓欄位變成必填-->
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label text-light">商品編號</label>
                            <input type="text" class="form-control" id="product_id" name="product_id" value="<?= htmlentities($row["product_id"]) ?>" placeholder="請輸入國際條碼13碼">
                            <!--value是為了讓你進去修改頁面的時候，已把值show在該欄位上-->
                            <div class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="count_number" class="form-label text-light">數量</label>
                            <input type="text" class="form-control" id="count_number" name="count_number" value="<?= htmlentities($row["count_number"]) ?>">
                            <!--value是為了讓你進去修改頁面的時候，已把值show在該欄位上-->
                            <div class="form-text text-danger"></div>
                        </div>
                        <button type="submit" class="btn btn-outline-warning">修改</button>
                        <!--如果『標籤button』沒有要送出資料的話，裡面的type要下button。就像這樣type="button"-->
                    </form>
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

                </div>
            </div>
        </div>
    </div>
    <!--這條線以上只是在設定bootstrap modal而已，跟要學的php東西無關，就是讓網頁好看這樣子。-->

<?php include __DIR__ . "/__scripts.php" ?>
<script>
    let modal = new bootstrap.Modal(document.querySelector("#exampleModal"));
    //這串只是在設定bootstrap裡面的modal而已，跟要學的php東西無關

    let user_id = document.querySelector("#user_id");
    let product_id = document.querySelector("#product_id");
    let count_number = document.querySelector("#count_number");
    let user_id_re = /^(0|[1-9][0-9]*)$/;
    let product_re = /^471[\d]{10}$/;
    let count_number_re = /^(0|[1-9][0-9]*)$/;

    function sendData() {
        user_id.nextElementSibling.innerHTML = "";
        product_id.nextElementSibling.innerHTML = "";
        count_number.nextElementSibling.innerHTML = "";

        let isPass = true; // 這個變數的用意是說，有沒有通過表單的檢查。
        // 邏輯上的意思是說，我先預設你是通過的。但是！你只要有一個欄位沒通過就算沒通過。
        //todo 檢查表單的資料。 這行以下開始檢查資料。

        if (user_id.value.length < 1 || !user_id_re.test(user_id.value)) {
            isPass = false;
            user_id.nextElementSibling.innerHTML = "請輸入正確的會員編號"
        }

        if (product_id.value.length !== 13 || !product_re.test(product_id.value)) {
            isPass = false;
            product_id.nextElementSibling.innerHTML = "請輸入想修改商品編號"
        }

        if (count_number.value.length < 1 || !count_number_re.test(count_number.value)) {
            isPass = false;
            count_number.nextElementSibling.innerHTML = "請輸入想下單的數量"
        }

        if (isPass) {
            let fd = new FormData(document.form1); //* 『FormData』可以想成是沒有外觀的表單
            //* 就是把頁面上有外觀的表單的資料全部抓下來，放到這個沒有外觀的表單裡面。

            fetch("cart-edit-api.php", {
                    method: "POST",
                    body: fd,
                }).then(r => r.json())
                .then(obj => {
                    console.log(obj);

                    if (obj.success) {
                        alert("修改成功");
                        location.href = "cart.php";
                    } else {
                        document.querySelector(".modal-body").innerHTML = obj.error || "清單修改發生錯誤";
                        modal.show();
                    }
                })
        }
    }
</script>
<?php include __DIR__ . "/__html_foot.php" ?>