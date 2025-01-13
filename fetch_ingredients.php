<?php include 'db_connect.php'; ?>
<?php

if (isset($_GET['recipe_name']) && isset($_GET['qty'])) {
    $recipe_name = $_GET['recipe_name'];
    $qty = $_GET['qty'];

    $query = $conn->prepare("SELECT ing_type, ing_mass, Unit FROM ing_list WHERE recipe_id = (SELECT recipe_id FROM receipe WHERE recipe_name = ?)");
    if (!$query) {
        die("Error in query preparation: " . $conn->error);
    }

    $query->bind_param("s", $recipe_name);
    if (!$query->execute()) {
        die("Error in query execution: " . $query->error);
    }

    $result = $query->get_result();
    if (!$result) {
        die("Error retrieving result: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Calculated Mass</th>
                        <th>Unit</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            $calculated_mass = ($qty / 10) * floatval($row['ing_mass']);
            echo "<tr>
                    <td>" . htmlspecialchars($row['ing_type'], ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($calculated_mass, ENT_QUOTES, 'UTF-8') . "</td>
                    <td>" . htmlspecialchars($row['Unit'], ENT_QUOTES, 'UTF-8') . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-danger'>No ingredients found for the selected recipe.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request. Please provide all necessary parameters.</div>";
}
?>
