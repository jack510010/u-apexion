<?php
require __DIR__. '/__connect_db.php';

// if(!isset($_SESSION['admin'])){
//     // 要再變更！！
//     header('Location: index_.php');
//     exit;
// }

$title = '新增貼文';
$pageName = 'insert';

date_default_timezone_set('Asia/Taipei');
?>

<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>


<style>
    body {
            /* background: linear-gradient(to right, #021943 0%, #023f74 100%); */
            font-family: 'Noto Sans HK', sans-serif;
            font-family: 'Noto Sans TC', sans-serif;
        }
    form .form-text {
        color: red;
    }
    .forum-card{
        background: linear-gradient(to right, #021943 0%, #023f74 100%);
        color:#fff;
    }
    .post-form{
        /* border:1px solid red; */
        margin:15px;
    }
    .profile-photo{
        margin-bottom:10px;
    }
    .member-group{
        display:flex;
        justify-content:space-between;
    }
    .post-btn-group{
        /* border:1px solid red; */
        display:flex;
        justify-content:flex-end;
    }
    .post-btn-group .btn{
        background-color: #05f2f2;
        color:#023f74;
        border:0;
    }
    .post-btn-group .btn:hover{
        background-color: #fff;
        color:#023f74;
    }
    .post-btn-group .btn-cancel{
        margin-right:10px;
    }
    .post-title{
        margin-left:15px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card forum-card" >
                <div class="card-body">
                    <div class="member-group">
                        <div class="profile-photo">
                        <i class="fas fa-user-circle"></i>
                        <!-- 到時候要寫程式放照片 -->
                        </div>
                        <div class="edit-time"><?=date('m-d-Y h:i:s a', time()); ?></div>
                        <!-- 要寫程式放時間 -->
                        </div>
                    </div>
                    
                    <h5 class="card-title post-title">新增貼文</h5>

                    <form name="form1" class="post-form" onsubmit="sendData(); return false;">
                        <div class="mb-3">
                            <label for="title" class="form-label">標題 *</label>
                            <input type="text" class="form-control" id="title" name="title">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">分類</label>
                            <input type="text" class="form-control" id="category" name="category">
                            <div class="form-text"></div>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">內文</label>
                            <textarea class="form-control" name="content" id="content"
                                      cols="30"
                                      rows="15"></textarea>

                            <div class="form-text"></div>
                        </div>
                        <div class="post-btn-group">
                            <button type="submit" class="btn btn-primary btn-cancel">取消</button>
                            <button type="submit" class="btn btn-primary">新增</button>
                        </div>
                        

                    </form>

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

<?php include __DIR__. '/__scripts.php' ?>
<script>
    const title = document.querySelector('#title');
    const category = document.querySelector('#category');
    const content = document.querySelector('#content');

    const modal = new bootstrap.Modal(document.querySelector('#exampleModal'));

    // const email_re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    // const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;

    function sendData(){

        title.nextElementSibling.innerHTML = '';
        category.nextElementSibling.innerHTML = '';
        content.nextElementSibling.innerHTML = '';

        let isPass = true;
        // 檢查表單的資料
         






        if(isPass) {
            const fd = new FormData(document.form1);

            fetch('forum-insert-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if(obj.success){
                        alert('新增成功');
                        location.href = 'forum-list copy.php';
                    } else {

                        document.querySelector('.modal-body').innerHTML = obj.error || '資料新增發生錯誤';
                        modal.show();
                    }
                })
        }

    }



</script>
<?php include __DIR__. '/__html_foot.php' ?>