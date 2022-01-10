<?php require __DIR__. "/__connect_db.php";?>
<?php require __DIR__. "/__html_head.php";?>
<?php require __DIR__. "/__navbar.php";?>

<style>
    .index{
       min-height:100vh;
       background-color: #00002D;
       display:flex;
       align-items:center;
       position:relative;
    }
    .index img{
        width:100%;
        align-items:center;
    }
    .index-words{
        position:absolute;
        top:65%;
    }
    .index-words .title{
        font-weight:500;
        color:#00002D;
        font-size:40px;
        left:8%;
        margin-left:8%;
        margin-right:8%;
    }
    .index-words .content{
        width:30%;
        color:#00002D;
        font-size:18px;
        font-weight:100;
        left:40%;
    }

</style>


<div class="index">
    <img src="./img/index-06.png" alt="">
</div>

<div class="index-words d-flex">
   <h5 class="title">WHY WE GO</h5>
    <p class="content">"I really hope that there will be millions of kids all over the world who will be captivated and inspired about the possibility of them going to space one day."</p>
    <div class="login-here"></div> 
</div>



<?php require __DIR__. "/__scripts.php";?>
<?php require __DIR__. "/__html_foot.php";?>
