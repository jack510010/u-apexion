<?php
require __DIR__ . "/__connect_db.php";

$pageName = "element";
?>

<style>
    h1, h2 {
        color: White;
        text-align: center;
    }

    .bg_img{
        min-height: 100vh;
        background-image: url(./img/123.jpg);
        background-position: center;
        background-size: cover;
        

    }
</style>
<?php require __DIR__ . "/__html_head.php"; ?>
<?php require __DIR__ . "/__navbar.php"; ?>
<!-- Example single danger button -->
<div class="bg_img">
    <div class="box_1" style="padding-top: 10px;">
        <h1></h1>
        <div class="row ">
            <div class="col mb-5"><a href="element.php"><img src="./img/74635.png" alt=""></a><h2>星座之旅(Twelve Constellations)</h2></div>
            <div class="col mb-5"><a href="https://youtu.be/072tU1tamd0"><img src="./img/28473.png" alt=""></a><h2>星球之旅(Planet)</h2></div>
        </div>
    </div>
</div>








<?php require __DIR__ . "/__scripts.php"; ?>
<?php require __DIR__ . "/__html_foot.php"; ?>