<?php
include 'includes/dbconnection.php' ;
include 'db_connect.php';
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$qry = $stmt->get_result()->fetch_array();foreach($qry as $k => $v){
	$$k = $v;
}
include 'schedule_production.php';
?>