<?php
require __DIR__. '/__connect_db.php';

// if(! isset($_SESSION['user'])){
//     header('Location: index_.php');
//     exit;
// }


$title = '論壇列表';
$pageName = 'forum-list';

$perPage = 5;
$page= isset($_GET['page'])? intval($_GET['page']) : 1;

if($page<1){
    header('Location:list3-求總比數＆做分頁.php');
    exit;
} 

$t_sql = "SELECT COUNT(1) FROM forum_article";

// 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows/$perPage);
if($page>$totalPages){
    header('Location:forum-list.php.$totalPages');
    exit;
} 


$sql = sprintf("SELECT * FROM forum_article LEFT JOIN forum_category ON forum_category.cat_sid=forum_article.art_category_sid WHERE art_category_sid=2 ORDER BY forum_article.sid DESC LIMIT %s, %s", ($page-1)*$perPage, $perPage);

$rows = $pdo->query($sql)->fetchAll();

?>

<?php include __DIR__. '/__html_head.php' ?>
<?php include __DIR__. '/__navbar.php' ?>

<style>
    body {
            background: linear-gradient(to right, #021943 0%, #023f74 100%);
            color:#fff;
    }

    .forum-top{
        margin-top:20px;
        margin-bottom:20px;

    }
    /* .pagination.page-item.active .page-link{
        background-color: #023E73;
        color:#05F2F2;
        /* border:1px solid #05F2F2; */

    .pagination{
        justify-content:flex-end;
        margin-top:20px;
    }
    .page-item.active .page-link {
        background-color: #023E73;
        border-color: #023E73;
        color:#fff;
    }
    .page-item.disabled .page-link {
        border-color: #023E73;
    }
    
    
    .page-link{
        color:#023E73;
        border-color: #023E73;
        /* border:1px solid #023E73; */
    }
    .page-link:hover{
        color:#023E73;
        border-color: #023E73;
        background-color: #F8FAFF;
        /* border:1px solid #023E73; */
    }

    .table{
        /* border:10px; */
        /* border:3px solid #fff; */
        background: linear-gradient(to right, #021943 0%, #023f74 100%);
        /* border-radius:10px; */
        color:#fff;
    }
    .table-bordered > :not(caption) > * > * {
        border:1px;
    }
    .table-bordered > :not(caption) > * {
        border-width:0px;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        /* background-color: #F8FAFF; */
        /* background: linear-gradient(to right, #021943 0%, #023f74 100%); */
        /* opacity:0; */
        color:#fff;
    }

    table .fas{
        color:#fff;
    }
    table th .fas{
        color:#05F2F2;
    }
    table .fas:hover{
        color:#00002D;
    }

    table th{
        color:#05F2F2;
    }

    .list-table h5{
        color:#FFD700;
        /* border:1px solid #023E73; */
        width:130px;
        padding:10px;
        border-radius:10px;
    }

    .forum-search{
        width:200px;
        height:45px;
        border:2px solid #fff;
        color:#023E73;
    }
    .forum-search-btn{
        height:45px;
        border:2px solid #FFD700;
        /* background-color: #023E73; */
        color:#FFD700;
    }
    .forum-search-btn:hover{
        border:2px solid #023E73;
        background-color: #FFD700;
        color:#fff;
    }

    .forum-title{
        justify-content:space-between;
        /* border:1px solid red; */
        margin-bottom:20px;
    }

    .search i{
        font-size:30px;
        line-height:45px;
        margin-right:20px;
        /* margin-right:10px; */
        color:#05F2F2;
    }
    .search i:hover{
        font-size:30px;
        line-height:45px;
        margin-right:20px;
        /* margin-right:10px; */
        color:#00002D;
    }

    .forum-choose-category button{
        color:#FFD700;
        line-height:40px;
    }
    .forum-choose-category button:hover{
        color:#FFD700;
        line-height:40px;

    }

    .category-list .dropdown-item{
        color:#FFD700;
        /* border-bottom:1px solid #FFD700; */
        padding-right:10px;
    }
    .category-list .dropdown-item:hover{
        background-color: #00002D;
        /* border-bottom:1px solid #FFD700; */
        padding-right:10px;
    }
    .category-list{
        background-color: #021943;
    }
    .forum-list-title{
        text-decoration:none;
        color:#FFD700;
    }
    .forum-list-title:hover{
        text-decoration:none;
        color:#05F2F2;
    }
    



</style>

<div class="container forum-top">
    <div class="row">
        <div class="col list-table">
        <h5>太空小論壇</h5>
        <i class="fas fa-rocket"></i>
            <div class="forum-title d-flex">
                <div class="forum-title-dropdown">
                  <div class="dropdown forum-choose-category">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            文章分類
                        </button>
                        <ul class="category-list dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="forum-list copy.php">全部文章</a></li>
                            <li><a class="dropdown-item" href="forum-list copy.php">事前準備</a></li>
                            <li><a class="dropdown-item" href="forum-list-cat2.php">旅遊心得</a></li>
                            <li><a class="dropdown-item" href="#">太空冷知識</a></li>
                            <li><a class="dropdown-item" href="#">音樂推薦</a></li>
                            <li><a class="dropdown-item" href="#">星座</a></li>
                            <li><a class="dropdown-item" href="#">太空美食</a></li>

                        </ul>
                    </div>
                </div>
                
                <div class="search d-flex">
                    <a href="forum-insert.php"><i class="far fa-file-alt"></i></a>
                    <input class="form-control me-2 forum-search" type="search" placeholder="Type Here" aria-label="Search" name="search_text" id="search_text">
                    <button class="btn btn-outline-success forum-search-btn" type="submit">Search</button>
                </div>
                
                <!-- ?????try --> 
            </div>
            <div id="result"></div>
            
            <table class="table table-striped table-bordered" id="result">
                <thead>
                <tr>
                    <th scope="col">編號</th>
                    <th scope="col">分類</th>
                    <th scope="col">標題</th>
                    <th scope="col">內文</th>
                    <th scope="col">發布時間</th>
                    <th scope="col"><i class="fas fa-edit"></i></th>
                    <!-- edit -->
                    <th scope="col"><i class="fas fa-trash-alt"></i></th>
                    <!-- trash -->
                </tr>
                </thead>
                <tbody>
                <?php foreach($rows as $r): ?>
                    <tr>
                        <td><?= $r['sid'] ?></td>
                        <td><?= $r['for_category'] ?></td>
                        <td>
                            <a href="forum-article-response.php" class="forum-list-title">
                               <?= $r['art_title'] ?> 
                            </a>
                        </td> 
                        <td><?= $r['art_content'] ?></td>
                        <td><?= $r['art_create_time'] ?></td>
                        <td>
                            <a href="forum-edit.php?sid=<?= $r['sid'] ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                            <!-- 假連結 -->
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach;  ?>

                </tbody>

            </table>
        </div>
    </div>

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


</div>

<?php include __DIR__. '/__scripts.php' ?>

<script>
    function delete_it(sid){
        if(confirm(`確定要刪除編號為${sid}的資料嗎?`)){
            location.href= `forum-delete.php?sid=${sid}`;
        }
    }
</script>

<?php include __DIR__. '/__html_foot.php' ?>