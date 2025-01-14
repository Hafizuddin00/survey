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

       // Use prepared statement instead of direct query
       $stmt = $conn->prepare("DELETE FROM typeproduct WHERE product_id = ?");
       if ($stmt) {
           $stmt->bind_param("s", $product_id);
           $success = $stmt->execute();
           $stmt->close();
           
           echo $success ? 1 : 0;
    } else {
        echo 0; // Failed
    }
    exit();
}
// Corrected PHP code for saving ingredients and equipment
if ($_GET['action'] == 'save_recipe') {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'];
    $recipe_id = $data['recipe_id'];
    $product_id = $data['product_id'];
    $recipe_name = $data['recipe_name'];
    $equipment = $data['equipment'];
    $recipe_step = $data['recipe_step'];
    $ingredients = $data['ingredients'];

    // Use a prepared statement for UPDATE or INSERT
    if ($id) {
        $stmt = $conn->prepare("UPDATE receipe SET product_id = ?, recipe_name = ?, equipment = ?, recipe_step = ? WHERE recipe_id = ?");
        if ($stmt) {
            $stmt->bind_param("ssssi", $product_id, $recipe_name, json_encode($equipment), $recipe_step, $id);
            if (!$stmt->execute()) {
                die(json_encode(['error' => $stmt->error]));
            }
            $stmt->close();
        } else {
            die(json_encode(['error' => $conn->error]));
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO receipe (recipe_id, product_id, recipe_name, equipment, recipe_step) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("issss", $recipe_id, $product_id, $recipe_name, json_encode($equipment), $recipe_step);
            if (!$stmt->execute()) {
                die(json_encode(['error' => $stmt->error]));
            }
            $id = $stmt->insert_id;
            $stmt->close();
        } else {
            die(json_encode(['error' => $conn->error]));
        }
    }

    // Clear existing ingredients and equipment for the recipe
    $stmt = $conn->prepare("DELETE FROM ing_list WHERE recipe_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $recipe_id);
        if (!$stmt->execute()) {
            die(json_encode(['error' => $stmt->error]));
        }
        $stmt->close();
    } else {
        die(json_encode(['error' => $conn->error]));
    }

    $stmt = $conn->prepare("DELETE FROM recipe_equipment WHERE recipe_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $recipe_id);
        if (!$stmt->execute()) {
            die(json_encode(['error' => $stmt->error]));
        }
        $stmt->close();
    } else {
        die(json_encode(['error' => $conn->error]));
    }

    // Insert the equipment
    $stmt = $conn->prepare("INSERT INTO recipe_equipment (recipe_id, spec_id, eq_description) VALUES (?, ?, ?)");
    if ($stmt) {
        foreach ($equipment as $eq) {
            $spec_id = $eq['specId'];
            $eq_description = $eq['description'];

            $stmt->bind_param("iss", $recipe_id, $spec_id, $eq_description);
            if (!$stmt->execute()) {
                die(json_encode(['error' => $stmt->error]));
            }
        }
        $stmt->close();
    } else {
        die(json_encode(['error' => $conn->error]));
    }

    // Insert the ingredients
    $stmt = $conn->prepare("INSERT INTO ing_list (recipe_id, ing_type, ing_mass, Unit) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        foreach ($ingredients as $ingredient) {
            $ing_type = $ingredient['ingredient'];
            $ing_mass = $ingredient['qty'];
            $unit = $ingredient['unit'];

            $stmt->bind_param("isss", $recipe_id, $ing_type, $ing_mass, $unit);
            if (!$stmt->execute()) {
                die(json_encode(['error' => $stmt->error]));
            }
        }
        $stmt->close();
    } else {
        die(json_encode(['error' => $conn->error]));
    }

    echo json_encode(['success' => true]);
}




ob_end_flush();
?>
