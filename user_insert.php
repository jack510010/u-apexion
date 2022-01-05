<?php
require __DIR__ . '/__connect_db.php';
$title = '新增通訊資料';
$pageName = 'insert';


?>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">新增通訊資料</h5>
                    <form name="form1" onsubmit="sendData(); return false;">
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="name" class="form-control" id="name" name="name">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="text" class="form-control" id="password" name="password">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">mobile</label>
                            <input type="mobile" class="form-control" id="mobile" name="mobile"
                                data-pattern="09\d{2}-?\d{3}-?\d{3}">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">address</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>

                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">country</label>
                            <input type="country" class="form-control" id="country" name="country">
                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
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
</div>

<?php require __DIR__ . "/__scripts.php"; ?>
<script>
const name = document.querySelector('#name');
const email = document.querySelector('#email');
const mobile = document.querySelector('#mobile');


const email_re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

function sendData() {

    name.nextElementSibling.innerHTML = '';
    email.nextElementSibling.innerHTML = '';
    mobile.nextElementSibling.innerHTML = '';

    let isPass = true;
    // 檢查表單的資料
    if (name.value.length < 2) {
        isPass = false;
        name.nextElementSibling.innerHTML = '請輸入正確的姓名';
    }
    if (!email_re.test(email.value)) {
        isPass = false;
        email.nextElementSibling.innerHTML = '請輸入正確的email';
    }
    if (mobile.value && !mobile_re.test(mobile.value)) {
        isPass = false;
        mobile.nextElementSibling.innerHTML = '請輸入正確的手機號碼';
    }



    if (isPass) {
        const fd = new FormData(document.form1);

        fetch('user_insert_api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
            .then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('新增成功');
                    location.href = 'user_list.php';
                } else {
                    document.querySelector('.modal-body').innerHTML = obj.error || '資料新增發生錯誤';
                    modal.show();
                }
            })
    }


}
</script>

<?php require __DIR__ . "/__html_foot.php"; ?>