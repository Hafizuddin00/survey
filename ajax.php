<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'save_page_img'){
	$save = $crud->save_page_img();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'delete_message'){
	$save = $crud->delete_message();
	if($save)
		echo $save;
}
if($action == "save_categories"){
	$save = $crud->save_categories();
	if($save)
		echo $save;
}
if($action == 'delete_categories'){
	$save = $crud->delete_categories();
	if($save)
		echo $save;
}

if($action == 'update_status'){
	$save = $crud->update_status();
	if($save)
		echo $save;
}

if($action == 'update_quality'){
	$save = $crud->update_quality();
	if($save)
		echo $save;
}

if($action == 'save_comment'){
	$save = $crud->save_comment();
	if($save)
		echo $save;
}

if($action == 'delete_all_data'){
	$save = $crud->delete_all_data();
	if($save)
		echo $save;
}

if($action == 'archive_data'){
	$save = $crud->archive_data();
	if($save)
		echo $save;
}

if($action == "save_survey"){
	$save = $crud->save_survey();
	if($save)
		echo $save;
}

if($action == "save_product"){
	$save = $crud->save_product();
	if($save)
		echo $save;
}
if($action == "delete_survey"){
	$delete = $crud->delete_survey();
	if($delete)
		echo $delete;
}
if($action == "save_question"){
	$save = $crud->save_question();
	if($save)
		echo $save;
}
if($action == "delete_question"){
	$delsete = $crud->delete_question();
	if($delsete)
		echo $delsete;
}

if($action == "action_update_qsort"){
	$save = $crud->action_update_qsort();
	if($save)
		echo $save;
}
if($action == "save_answer"){
	$save = $crud->save_answer();
	if($save)
		echo $save;
}
if($action == "update_user"){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if ($action == 'insert_recipe') {
    // Insert new recipe
    $stmt = $conn->prepare("INSERT INTO receipe (recipe_id, product_id, recipe_name, recipe_ing, recipe_step) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $_POST['recipe_id'], $_POST['product_id'], $_POST['recipe_name'], $_POST['recipe_ing'], $_POST['recipe_step']);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo 0;  // Success
    } else {
        echo 1;  // Failure
    }
} elseif ($action == 'update_recipe') {
    // Update existing recipe
    $stmt = $conn->prepare("UPDATE receipe SET product_id = ?, recipe_name = ?, recipe_ing = ?, recipe_step = ? WHERE recipe_id = ?");
    $stmt->bind_param("ssssi", $_POST['product_id'], $_POST['recipe_name'], $_POST['recipe_ing'], $_POST['recipe_step'], $_POST['recipe_id']);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo 0;  // Success
    } else {
        echo 1;  // Failure
    }
}
ob_end_flush();
?>
