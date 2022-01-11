<?php
require __DIR__. '/__connect_db.php';

$title = '論壇文章';
$pageName = 'forum-article';



$perPage = 20;
$page= isset($_GET['page'])? intval($_GET['page']) : 1;

$t_sql = "SELECT COUNT(1) FROM forum_response";

$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows/$perPage);
if($page>$totalPages){
    header('Location:forum-list.php.$totalPages');
    exit;
} 

//抓會員
$sql3 = sprintf("SELECT * FROM user WHERE `sid` = %s" , $_SESSION['admin']['sid']);

$row3= $pdo->query($sql3)->fetch();


$sql = sprintf("SELECT * FROM forum_response LEFT JOIN user ON forum_response.user_sid=user.sid ORDER BY forum_response.sid DESC LIMIT %s, %s", ($page-1)*$perPage, $perPage);

$rows = $pdo->query($sql)->fetchAll();

$sql2 = sprintf("SELECT * FROM forum_article LEFT JOIN forum_category ON forum_category.cat_sid=forum_article.art_category_sid WHERE sid=13 ");
// 變數目前先寫死

$row2=$pdo->query($sql2)->fetch();







date_default_timezone_set('Asia/Taipei');

?>

<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>

<style>
    body{
        color:#fff;
    }
    .forum-card{
        margin-top:30px;
        border-radius:0;
        background: linear-gradient(to right, #021943 0%, #023f74 100%);
        border:2px solid #FFD700;
        border-radius:10px 10px 0 0;
    }
    .forum-card .card-header{
        border-bottom:1px solid #FFD700;
        color:#05f2f2;
    }
    .forum-card .card-header p{
        margin-left:12px;
    }
    .forum-list-group{
        border-radius:0;
        /* margin-bottom:30px; */
        /* background: linear-gradient(to right, #021943 0%, #023f74 100%); */
    }
    .forum-list-group li{
        background: linear-gradient(to right, #021943 0%, #023f74 100%);
        border-left:2px solid #FFD700;
        border-right:2px solid #FFD700;
        border-bottom:0.5px solid #021943;
    }
    .forum-card .card-title{
        margin-top:20px;
    }
    .forum-card-top a{
        margin-top:15px;
    }
    .forum-card-top a i{
        color:#fff;
        font-size:25px;
        margin-right:10px;
    }
    .forum-card .card-text{
        margin-top:20px;
    }
    .article_emoji .article_emoji-left i{
        color:#FFD700;
        font-size:20px;
    }
    .article_emoji .article_emoji-left p {
        color:#fff;
        font-size:13px;
    }
    .article_emoji .article_emoji-right i{
        color:#fff;
        font-size:20px;
    }
    .article_emoji a{
        text-decoration:none;
    }
    .article_emoji{
        margin-top:80px;
        margin-left:10px;
        margin-right:10px;
    }

    .forum-list-group-title{
        padding-top:30px;
    }
    .list-group-item .fa-user{
        color:#C0C0C0;
    }

    .user-resopnse-space .user-title{
        font-size:12px;
        margin-bottom:10px;
        color:#fff;
    }
    .response-space-left .fa-user{
        margin-right:20px;
        font-size:12px;
        color:#C0C0C0;
    }
    .user-resopnse-space .response-time{
        font-size:12px;
        margin-top:15px;
        color:#C0C0C0;
    }
    .user-resopnse-space .response-words{
        color:#C0C0C0;
    }

    .response-space-right .fa-heart{
        color:#C0C0C0;
    }
    .pagination{
        justify-content:center;
    }
    .fix-response{
        /* border:1px solid red; */
        position:sticky;
        bottom:0;
        /* width:64.8%; */
        z-index:999;
    }
    .respose-fix{
        border-radius:0px;
        bottom:0; 
    }
    .respose-fix input{
        border:0;
        width:87%;
        margin-left:15px;
        background: linear-gradient(to right, #021943 0%, #023f74 100%);
    }
    .respose-fix button{
       background-color: #FFD700;
       border:0;
       color:#023E73;
       padding:8px 15px;
       border-radius:10px;
    }
    .respose-fix button:hover{
       background-color: #FFD700;
       color:#fff;
       padding:8px 15px;
       border-radius:10px;
    }
    .respose-fix{
        border:0;
    }

    .pagination li{
        border:0px;
        border-radius:10px;
        /* width:30px; */
    }
    .pagination .disabled .page-link{
        background-color: #021943;
        border:0;
    }
    .pagination .active .page-link{
        background-color: #05f2f2;
        border:0;
        color:#021943;
    }
    .pagination .page-link{
        background-color: #021943;
        border:0;
        color:grey;
    }
    .forum-title-dropdown button{
        color:#fff;
    }
    .forum-title-dropdown{
        margin-left:auto;
    }
    





</style>

<div class="container">
    <div class="row">
        <div class="col-10 m-auto ">
            <div class="forum-card card">
                <!-- 文章分類下拉選單 -->
                <div class="card-header-flex">

                    <div class="card-header">

                    <div class="forum-title-dropdown">
                        <div class="dropdown forum-choose-category">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    文章分類
                            </button>
                            <ul class="category-list dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="forum-list copy.php">全部文章</a></li>
                                <li><a class="dropdown-item" href="forum-list-cat1.php">事前準備</a></li>
                                <li><a class="dropdown-item" href="forum-list-cat2.php">旅遊心得</a></li>
                                <li><a class="dropdown-item" href="#">太空冷知識</a></li>
                                <li><a class="dropdown-item" href="#">音樂推薦</a></li>
                                <li><a class="dropdown-item" href="#">星座</a></li>
                                <li><a class="dropdown-item" href="#">太空美食</a></li>
                            </ul>
                    </div>
                </div>
                    <!-- 文章分類下拉選單 -->
                    <p>
                        <?=$row2['for_category']?>
                    </p>
                </div>
                    
                <div class="card-body">
                    <div class="forum-card-top d-flex justify-content-between">
                       <h5 class="card-title"><?= $row2['art_title'] ?></h5>
                        <a href="forum-list copy.php">
                            <i class="fas fa-times"></i>
                        </a> 
                    </div>
                    
                    <p class="card-text">
                        <?= $row2['art_content'] ?>
                        <div class="forum-photo" >
                            <img src="./img/<?= $row2['art_photo']?>" alt="" style="width:50%;">
                        </div>
                        
                    </p>
                    <div class="article_emoji d-flex justify-content-between">
                        <div class="article_emoji-left d-flex">
                            <a href="">
                            <i class="far fa-laugh" style="margin-right:8px;"></i>
                            </a>
                            <a href="#">
                                <i class="fab fa-gratipay" style="margin-right:10px;"></i>
                            </a>
                            <a href="#list-group-item">
                               <p>回應<?= $totalRows ?>則</p> 
                            </a>
                            
                        </div>
                        <div class="article_emoji-right">
                            <a href="#">
                            <i class="fas fa-heart"></i>
                            </a>
                            <a href="#">
                                <i class="fas fa-tag" style="margin-left:10px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <ul class="forum-list-group list-group">
                <li class="forum-list-group-title list-group-item disabled" aria-disabled="true">共<?= $totalRows ?>則留言</li>

            <?php foreach($rows as $r): ?>
                <li class="list-group-item" id="list-group-item">
                    <div class="response-space d-flex justify-content-between">
                        <div class="response-space-left d-flex">
                            <div class="user-img">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-resopnse-space">  
                                <div class="user-title"><?= $r['name'] ?></div>
                                <div class="response-words"><?= $r['res_content'] ?></div>
                                <div class="response-time"><?= $r['res_time'] ?></div>
                            </div>
                        </div>
                        <div class="response-space-right d-flex">
                            <a href="#">
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                    </div>
                </li>
                <?php endforeach;  ?>

                <li class="list-group-item disabled">
                <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= 1==$page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page-1 ?>">
                            <i class="fas fa-arrow-circle-left"></i>
                        </a></li>
                        <?php for($i=$page-2; $i<=$page+2; $i++)
                        if($i>=1 && $i<=$totalPages):
                            ?>
                        <li class="page-item <?= $i==$page? 'active': '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                        </li>
                        <?php endif; ?>


                    <li class="page-item <?= $totalPages==$page ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page+1 ?>">
                            <i class="fas fa-arrow-circle-right"></i>
                    </a></li>
                </ul>
            </nav>
        </div>
    </div>
                </li>

                <!-- <li class="forum-list-group-title list-group-item disabled" aria-disabled="true"></li> -->

                <!-- fix-response -->

                <div class="fix-response">
                    <ul class="respose-fix list-group">
                        <form name="form2" class="post-form" onsubmit="sendData(); return false;">
                           <li class="list-group-item respose-fix">
                                <i class="fas fa-user"></i>
                                <input id="response" name="response" type="text" placeholder="留言..." style="color:#fff">
                                <button>送出</button>
                            </li> 
                        </form>
                    </ul>
                </div>
                
            </ul>
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
</div>
<?php include __DIR__. '/__scripts.php' ?>

<script>

    const response = document.querySelector('#response');

    const modal = new bootstrap.Modal(document.querySelector('#exampleModal'));

    function sendData(){

        response.nextElementSibling.innerHTML = '';

        let isPass = true;

        if(isPass) {
            const fd = new FormData(document.form2);

            fetch('forum-article-response-api.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json())
                .then(obj => {
                    console.log(obj);
                    if(obj.success){
                        alert('回應成功');
                        location.href = 'forum-article-response.php';
                    } else {
                        document.querySelector('.modal-body').innerHTML = obj.error || '資料新增發生錯誤';
                        modal.show();
                    }
                })
        }

    }

</script>

<?php include __DIR__. '/__html_foot.php' ?>

