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
if ($_GET['action'] == 'delete_product') {
    include 'db_connect.php'; // Ensure database connection

    $product_id = $_POST['product_id'];

    // Perform the deletion
    $delete = $conn->query("DELETE FROM typeproduct WHERE product_id = '$product_id'");
    if ($delete) {
        echo 1; // Success
    } else {
        echo 0; // Failed
    }
    exit();
}
if ($_GET['action'] == 'save_recipe') {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'];
    $recipe_id = $data['recipe_id'];
    $product_id = $data['product_id'];
    $recipe_name = $data['recipe_name'];
    $equipment = $data['equipment'];
    $recipe_step = $data['recipe_step'];
    $ingredients = $data['ingredients'];

    if ($id) {
        $update = $conn->query("UPDATE receipe SET recipe_id='$recipe_id', product_id='$product_id', recipe_name='$recipe_name', equipment='$equipment', recipe_step='$recipe_step' WHERE id='$id'");
        if (!$update) die(json_encode(['error' => $conn->error]));
    } else {
        $insert = $conn->query("INSERT INTO receipe (recipe_id, product_id, recipe_name, equipment, recipe_step) VALUES ('$recipe_id', '$product_id', '$recipe_name', '$equipment', '$recipe_step')");
        if (!$insert) die(json_encode(['error' => $conn->error]));
        $id = $conn->insert_id;
    }

    $conn->query("DELETE FROM ing_list WHERE recipe_id='$recipe_id'");
    foreach ($ingredients as $ingredient) {
        $ing_type = $conn->real_escape_string($ingredient['ingredient']);
        $ing_mass = $conn->real_escape_string($ingredient['qty']);
        $conn->query("INSERT INTO ing_list (recipe_id, ing_type, ing_mass) VALUES ('$recipe_id', '$ing_type', '$ing_mass')");
    }

    echo 1;
}


ob_end_flush();
?>
