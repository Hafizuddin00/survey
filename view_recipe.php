<?php 
include 'db_connect.php';

if (isset($_GET['id'])) {
    $recipe_id = intval($_GET['id']); // Sanitize input to prevent SQL injection
    
    // Prepare the query to retrieve the recipe, its ingredients, and associated equipment
    $qry = $conn->prepare("
        SELECT r.recipe_id, r.product_id, r.recipe_name, r.recipe_step, 
               i.ing_type, i.ing_mass, 
               re.spec_id AS equip_id, e.eq_description 
        FROM receipe r 
        LEFT JOIN ing_list i ON r.recipe_id = i.recipe_id 
        LEFT JOIN recipe_equipment re ON r.recipe_id = re.recipe_id 
        LEFT JOIN equipment_details e ON re.spec_id = e.spec_id 
        WHERE r.recipe_id = ?
    ");
    
    if ($qry) {
        $qry->bind_param("i", $recipe_id); // Bind parameter for security
        $qry->execute();
        $result = $qry->get_result();

        $recipes = [
            'details' => [],
            'ingredients' => [],
            'equipment' => []
        ]; // Initialize recipes array

        // To ensure uniqueness, use associative arrays
        $unique_ingredients = [];
        $unique_equipment = [];

        // Process the result set
        while ($row = $result->fetch_assoc()) {
            // Populate recipe details only once
            if (empty($recipes['details'])) {
                $recipes['details'] = [
                    'recipe_id' => $row['recipe_id'],
                    'product_id' => $row['product_id'],
                    'recipe_name' => $row['recipe_name'],
                    'recipe_step' => $row['recipe_step']
                ];
            }

            // Add unique equipment details
            if (!empty($row['equip_id']) && !empty($row['eq_description'])) {
                $equip_key = $row['equip_id']; // Use spec_id as key to ensure uniqueness
                if (!isset($unique_equipment[$equip_key])) {
                    $unique_equipment[$equip_key] = [
                        'equip_id' => $row['equip_id'],
                        'eq_description' => $row['eq_description']
                    ];
                }
            }

            // Add unique ingredients
            if (!empty($row['ing_type']) && !empty($row['ing_mass'])) {
                $ing_key = $row['ing_type'] . $row['ing_mass']; // Use a combination of type and mass to ensure uniqueness
                if (!isset($unique_ingredients[$ing_key])) {
                    $unique_ingredients[$ing_key] = [
                        'ing_type' => $row['ing_type'],
                        'ing_mass' => $row['ing_mass']
                    ];
                }
            }
        }

        // Convert unique associative arrays back to indexed arrays for rendering
        $recipes['equipment'] = array_values($unique_equipment);
        $recipes['ingredients'] = array_values($unique_ingredients);

        $qry->close(); // Close the prepared statement
    } else {
        die("Error preparing query: " . $conn->error);
    }
} else {
    die("No recipe ID provided.");
}
?>

<div class="container-fluid">
    <table class="table">
        <tr>
            <th>No Product ID:</th>
            <td><b><?php echo isset($recipes['details']['product_id']) ? htmlspecialchars($recipes['details']['product_id']) : 'N/A'; ?></b></td>
        </tr>
        <tr>
            <th>Recipe ID:</th>
            <td><b><?php echo isset($recipes['details']['recipe_id']) ? htmlspecialchars($recipes['details']['recipe_id']) : 'N/A'; ?></b></td>
        </tr>
        <tr>
            <th>Recipe Name:</th>
            <td><b><?php echo isset($recipes['details']['recipe_name']) ? htmlspecialchars($recipes['details']['recipe_name']) : 'N/A'; ?></b></td>
        </tr>
        <tr>
            <th>Equipment:</th>
            <td>
                <?php if (!empty($recipes['equipment'])): ?>
                    <ul>
                        <?php foreach ($recipes['equipment'] as $equip): ?>
                            <li>
                                <?php echo htmlspecialchars($equip['equip_id']); ?> - 
                                <?php echo htmlspecialchars($equip['eq_description']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <span>No equipment available.</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Recipe Ingredients:</th>
            <td>
                <?php if (!empty($recipes['ingredients'])): ?>
                    <ul>
                        <?php foreach ($recipes['ingredients'] as $ingredient): ?>
                            <li>
                                <?php echo htmlspecialchars($ingredient['ing_type']) . ': ' . htmlspecialchars($ingredient['ing_mass']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <span>No ingredients available.</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Step to Bake:</th>
            <td><b><?php echo isset($recipes['details']['recipe_step']) ? htmlspecialchars($recipes['details']['recipe_step']) : 'N/A'; ?></b></td>
        </tr>
    </table>
</div>

<div class="modal-footer display p-0 m-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeAndRedirect()">Close</button>

    <script>
        function closeAndRedirect() {
            // Close the modal
            $('#uni_modal').modal('hide');
            
            // Redirect to the manage_recipe page after the modal is closed
            setTimeout(function() {
                window.location.href = 'index.php?page=manage_recipe';
            }, 300); // Delay to ensure modal closes before redirection
        }
    </script>
</div>

<style>
    #uni_modal .modal-footer {
        display: none;
    }
    #uni_modal .modal-footer.display {
        display: flex;
    }
</style>
