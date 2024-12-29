<?php
include 'db_connect.php';
include 'includes/dbconnection.php' ;
$qry = $conn->query("SELECT * FROM receipe where recipe_id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'stitle';
	$$k = $v;
}
include 'new_recipe.php';
?>
