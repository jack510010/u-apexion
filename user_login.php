<?php
session_start();

if (isset($_SESSION['admin'])) {
    header('Location: user_list.php');
    exit;
}

if( isset($_GET['pagefrom']) ){
    $_SESSION['page_from'] = "user_list.php";
};

?>

<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>

<style>
/* .container{ */
/* border:1px solid red; */
/* height:500px; */
/* align-items:center; */
/* } */
/* .center-container{
        display:flex;
        justify-content:center; */
/* margin-top:; */
/* } */

.row {
    margin-top: 50px;
}
</style>

<nav class="navbar navbar-expand-lg navbar-light pt-3 shadow ">

    <div class="container-fluid"><i class="fas fa-laptop-house text-warning"></i>

    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">


                </li>
                <li class="nav-item dropdown">


                </li>
            </ul>
            <button type="button" class="btn btn-info"><a class="text-dark" href="user_insert.php"
                    style="text-decoration:none;">註冊會員</a></button>



        </div>
    </div>
</nav>

<div class="container">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg-6">
            <div class="card">
            <!-- /* $_SESSION['page_from']  */ -->
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <form name="form1" onsubmit="doLogin(); return false;">
                        <div class="mb-3">
                            <label for="email" class="form-label">Account(email)</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">登入</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
<?php require __DIR__ . "/__scripts.php"; ?>

<script>
     previous = "javascript:history.go(-1)";
     console.log('previous',previous);

function doLogin() {
    const fd = new FormData(document.form1);

    fetch('user_login_api.php', {
        method: 'POST',
        body: fd,
    }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (obj.success) {
            location.href = "<?= $_SESSION['page_from']; ?> ";

        } else {
            alert(obj.error);
        }

    });
}
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>