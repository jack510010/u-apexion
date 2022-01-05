<?php
require __DIR__. '/__connect_db.php';

$output = '';



if(isset($_POST['query']))
{
	// ???????這樣寫對嗎?????
	$search = $_POST["query"];
	$query = "
    SELECT * FROM `forum_article` LEFT JOIN `forum_category` ON `forum_category`.cat_sid=`forum_article`.art_category_sid 
	WHERE `art_title` Like ? 
	OR `for_category` Like ? 
	OR `art_content` Like ? 
	;";
	
	$stmt = $pdo -> prepare($query);
	$stmt -> execute(['%'.$search.'%','%'.$search.'%','%'.$search.'%']);

	$rows = $stmt->fetchAll();
	// echo $rows["for_category"];
}
else
{
	$query = "
	SELECT * FROM forum_article ORDER BY sid";
	$stmt = $pdo -> prepare($query);
	$stmt -> execute();

	$rows = $stmt->fetchAll();
	// echo 'fff';
}



if($stmt->rowCount()){

	$output .='
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">分類</th>
				<th scope="col">標題</th>
				<th scope="col">內文</th>
				<th scope="col">發布時間</th><th scope="col"><i class="fas fa-edit"></i></th>
				<th scope="col"><i class="fas fa-trash-alt"></i></th>
			</tr>
		</thead>
	';
	foreach ($rows as $r){
		$output .='
		<tr>
			<td>'.$r["sid"]. '</td>
			<td>'.$r["art_category_sid"].'</td>
			<td>'.$r["art_title"]. '</td>
			<td>'.$r["art_content"]. '</td>
			<td>'.$r["art_create_time"]. '</td>
			<td>
                <a href="forum-edit.php?sid=<?= $r["sid"] ?>
                    <i class="fas fa-edit"></i>
                </a>
            </td>
			<td>
                <a href="javascript: delete_it(<?= $r["sid"] )
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
		</tr>
		';
	}
	echo $output;
}
else{
echo 'Data Not Found';
}
	
	?>