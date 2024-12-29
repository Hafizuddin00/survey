<?php
include 'db_connect.php';
include 'includes/dbconnection.php' ;
$qry = $conn->query("SELECT * FROM receipe WHERE recipe_id = " . $_GET['id']);
if ($qry) {
    $row = $qry->fetch_array();
    foreach ($row as $k => $v) {
        $$k = $v;
    }
} else {
    echo "Error: " . $conn->error;
}

include 'new_templates.php';
?>