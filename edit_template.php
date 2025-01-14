<?php
include 'db_connect.php';
include 'includes/dbconnection.php' ;
$stmt = $conn->prepare("SELECT * FROM receipe WHERE recipe_id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    $row = $result->fetch_array();
    foreach ($row as $k => $v) {
        $$k = $v;
    }
} else {
    echo "Error: " . $conn->error;
}

include 'new_templates.php';
?>