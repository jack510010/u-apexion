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

$sql = sprintf("SELECT * FROM forum_response LEFT JOIN forum_user ON forum_response.user_sid=forum_user.sid ORDER BY forum_response.sid DESC LIMIT %s, %s", ($page-1)*$perPage, $perPage);

$rows = $pdo->query($sql)->fetchAll();

date_default_timezone_set('Asia/Taipei');

?>

<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>

<style>

    .forum-card{
        margin-top:30px;
        border-radius:0;
    }
    .forum-list-group{
        border-radius:0;
        margin-bottom:30px;
    }
    .forum-card .card-title{
        margin-top:20px;
    }
    .forum-card .card-text{
        margin-top:20px;
    }
    .article_emoji .article_emoji-left i{
        color:#FFD700;
        font-size:20px;
    }
    .article_emoji .article_emoji-left p {
        color:grey;
        font-size:13px;
    }
    .article_emoji .article_emoji-right i{
        color:grey;
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

    .user-resopnse-space .user-title{
        font-size:12px;
        margin-bottom:10px;
    }
    .response-space-left .fa-user{
        margin-right:20px;
        font-size:12px;
        color:grey;
    }
    .user-resopnse-space .response-time{
        font-size:12px;
        margin-top:15px;
        color:grey;
    }
    .user-resopnse-space .response-words{
        color:grey;
    }

    .response-space-right .fa-heart{
        color:grey;
    }
    .pagination{
        justify-content:center;
    }
    .fix-response{
        /* border:1px solid red; */
        position:fixed;
        bottom:0;
        width:64.8%;
        z-index:999;
        /* aj4 */
    }
    .respose-fix{
        border-radius:0px;
        bottom:0; 
    }
    .respose-fix input{
        border:0;
        width:87%;
        margin-left:15px;
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





</style>

<div class="container">
    <div class="row">
        <div class="col-10 m-auto ">
            <div class="forum-card card">
                <div class="card-header">
                    $分類
                </div>
                <div class="card-body">
                    <h5 class="card-title">＄標題</h5>
                    <p class="card-text">$內文
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat fuga voluptatem at repudiandae incidunt? Nam voluptas odio perspiciatis veritatis non quia magni ipsa itaque aliquid dolorum omnis, eius at ipsam, rerum voluptatum repellat iure eos. Ab dolores natus, quasi maxime obcaecati ducimus inventore in, quas quae hic molestiae praesentium earum tenetur, quod velit neque a! Labore ratione delectus repellat ducimus totam. Fugit, sapiente in suscipit eligendi nam exercitationem doloribus modi voluptates ratione! Tempore obcaecati ea fugiat in aut. Totam deserunt quo, veritatis ratione, distinctio ut placeat consequatur, nisi esse atque tenetur minus voluptatibus vel quam aspernatur veniam minima quis mollitia.</p>
                    <div class="article_emoji d-flex justify-content-between">
                        <div class="article_emoji-left d-flex">
                            <a href="">
                            <i class="far fa-laugh" style="margin-right:8px;"></i>
                            </a>
                            <a href="#">
                                <i class="fab fa-gratipay" style="margin-right:10px;"></i>
                            </a>
                            <p>回應$則</p>
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
                <li class="forum-list-group-title list-group-item disabled" aria-disabled="true">共$則留言</li>

                <?php foreach($rows as $r): ?>
                <li class="list-group-item">
                    <div class="response-space d-flex justify-content-between">
                        <div class="response-space-left d-flex">
                            <div class="user-img">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-resopnse-space">
                                <div class="user-title">Amanda Chiu</div>
                                <div class="response-words"><?= $r['res_content'] ?></div>
                                <div class="response-time"><?=date('m-d-Y h:i:s a', time()); ?></div>
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

                <li class="forum-list-group-title list-group-item disabled" aria-disabled="true"></li>

                <!-- fix-response -->
                <div class="fix-response">
                    <ul class="respose-fix list-group">
                        <form name="form2" class="post-form" onsubmit="sendData(); return false;">
                           <li class="list-group-item respose-fix">
                                <i class="fas fa-user"></i>
                                <input id="response" name="response" type="text" placeholder="留言...">
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

