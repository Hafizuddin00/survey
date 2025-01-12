<?php include 'db_connect.php'; ?>

<?php

header('Content-Type: application/json'); 

if (isset($_GET['recipe_name']) && isset($_GET['qty'])) {
    $recipe_name = $_GET['recipe_name'];
    $qty = intval($_GET['qty']);

    $equipment_html = "";
    $equipment_data = [];

    $query = $conn->prepare("
        SELECT re.spec_id, ed.eq_description, ed.eq_not_used, ed.eq_used 
        FROM recipe_equipment re 
        JOIN equipment_details ed 
        ON re.spec_id = ed.spec_id 
        WHERE re.recipe_id = (SELECT recipe_id FROM receipe WHERE recipe_name = ?)
    ");

    if (!$query) {
        die(json_encode(['error' => "Error in query preparation: " . $conn->error]));
    }

    $query->bind_param("s", $recipe_name);
    if (!$query->execute()) {
        die(json_encode(['error' => "Error in query execution: " . $query->error]));
    }

    $result = $query->get_result();
    if (!$result) {
        die(json_encode(['error' => "Error retrieving result: " . $conn->error]));
    }

    $recipe_query = $conn->prepare("SELECT recipe_id FROM receipe WHERE recipe_name = ?");
    if (!$recipe_query) {
        die(json_encode(['error' => "Error in query preparation: " . $conn->error]));
    }
    $recipe_query->bind_param("s", $recipe_name);
    if (!$recipe_query->execute()) {
        die(json_encode(['error' => "Error in query execution: " . $recipe_query->error]));
    }

    $recipe_result = $recipe_query->get_result();
    if (!$recipe_result) {
        die(json_encode(['error' => "Error retrieving result: " . $conn->error]));
    }

    if ($recipe_result->num_rows > 0) {
        $recipe_row = $recipe_result->fetch_assoc();
        $recipe_id = $recipe_row['recipe_id'];
    } else {
        die(json_encode(['error' => "Recipe not found"]));
    }

    if ($result->num_rows > 0) {
        $equipment_html .= "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Equipment</th>
                        <th>Available Quantity</th>
                        <th>Enter Quantity</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            $max_qty = max(0, floatval($row['eq_not_used']));
            $equipment_html .= "<tr>
                    <td>" . htmlspecialchars($row['eq_description']) . "</td>
                    <td>" . htmlspecialchars($max_qty) . "</td>
                    <td><input type='number' data-spec-id='" . htmlspecialchars($row['spec_id']) . "' data-max-qty='" . htmlspecialchars($max_qty) . "'></td>
                  </tr>";

            $equipment_data[] = [
                'recipe_id' => $recipe_id,
                'spec_id' => $row['spec_id'],
                'eq_description' => $row['eq_description'],
                'eq_not_used' => $row['eq_not_used'],
                'eq_used' => $row['eq_used'],
                'max_qty' => $max_qty,
                'qty' => 0 
            ];
        }

        $equipment_html .= "</tbody></table>";
    } else {
        $equipment_html .= "<div class='alert alert-danger'>No equipment found for the selected recipe.</div>";
    }

    echo json_encode([
        'equipment_html' => $equipment_html,
        'equipment_data' => $equipment_data
    ], JSON_UNESCAPED_SLASHES);
} else {
    echo json_encode([
        'error' => 'Invalid request. Please provide all necessary parameters.'
    ], JSON_UNESCAPED_SLASHES);
}
?>
