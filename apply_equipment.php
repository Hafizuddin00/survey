<?php
include 'db_connect.php';

header('Content-Type: application/json'); // Ensure correct JSON response header

$data = json_decode(file_get_contents("php://input"), true);
$recipe_name = $data['recipe_name'];
$equipment_data = $data['equipment_data'];

// Fetch recipe_id
$query = $conn->prepare("SELECT recipe_id FROM receipe WHERE recipe_name = ?");
$query->bind_param("s", $recipe_name);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $recipe_id = $row['recipe_id'];
} else {
    die(json_encode(['error' => 'Recipe not found.']));
}

foreach ($equipment_data as $equipment) {
    $spec_id = $equipment['spec_id'];
    $qty = $equipment['qty'];

    // Skip if no quantity is provided
    if ($qty <= 0) continue;

    // Update equipment_details
    $update = $conn->prepare("UPDATE equipment_details SET eq_used = eq_used + ?, eq_not_used = eq_not_used - ? WHERE spec_id = ?");
    $update->bind_param("dds", $qty, $qty, $spec_id);
    if (!$update->execute()) {
        die(json_encode(['error' => "Error updating equipment_details: " . $update->error]));
    }

    // Check if equipment already exists in recipe_equipment
    $check = $conn->prepare("SELECT eq_used FROM recipe_equipment WHERE recipe_id = ? AND spec_id = ?");
    $check->bind_param("is", $recipe_id, $spec_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        // Update existing equipment in recipe_equipment
        $save = $conn->prepare("UPDATE recipe_equipment SET eq_used = eq_used + ? WHERE recipe_id = ? AND spec_id = ?");
        $save->bind_param("dis", $qty, $recipe_id, $spec_id);
    } else {
        // Insert new equipment in recipe_equipment
        $save = $conn->prepare("INSERT INTO recipe_equipment (recipe_id, spec_id, eq_used) VALUES (?, ?, ?)");
        $save->bind_param("isd", $recipe_id, $spec_id, $qty);
    }

    if (!$save->execute()) {
        die(json_encode(['error' => "Error updating/inserting recipe_equipment: " . $save->error]));
    }
}

// Return success response
echo json_encode(['success' => true]);
?>
