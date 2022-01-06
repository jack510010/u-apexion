<?php
session_start();

?>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<nav class="navbar navbar-expand-lg navbar-light pt-3 shadow ">
    <div class="container-fluid"><i class="fas fa-laptop-house text-warning"></i>
        <a class="navbar text-warning " href="user_list.php" style="text-decoration:none;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">


                </li>
                <li class="nav-item dropdown">


                </li>
            </ul>
            <button type="button" class="btn btn-info"><a class="text-dark" href="user_insert.php"
                    style="text-decoration:none;">註冊會員</a></button>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="user_login.php">登入</a>

                </li>

            </ul>


        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">

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
function doLogin() {
    const fd = new FormData(document.form1);

    fetch('user_login_api.php', {
        method: 'POST',
        body: fd,
    }).then(r => r.json()).then(obj => {
        console.log(obj);
        if (obj.success) {
            location.href = 'user_list.php';
        } else {
            alert(obj.error);
        }

    });
}
</script>
<?php require __DIR__ . "/__html_foot.php"; ?>