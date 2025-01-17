<?php include 'db_connect.php'; ?>
<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Query for category and recipe details
    $stmt = $conn->prepare("SELECT c.*, r.recipe_id, c.ingredients_data, r.recipe_step FROM categories c LEFT JOIN receipe r ON c.recipe_name = r.recipe_name WHERE c.id = ?");

    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_array();
            foreach ($data as $k => $v) {
                $$k = $v;
            }
        } else {
            echo "<div class='alert alert-danger'>No record found for ID: $id</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>Failed to prepare statement: " . $conn->error . "</div>";
        exit;
    }

    // Query for equipment details
    $equipment_stmt = $conn->prepare("SELECT er.spec_id, er.eq_used FROM equipment_record er WHERE er.id = ?");

    $equipment_list = [];
    if ($equipment_stmt) {
        $equipment_stmt->bind_param('i', $id);
        $equipment_stmt->execute();
        $equipment_result = $equipment_stmt->get_result();

        if ($equipment_result && $equipment_result->num_rows > 0) {
            while ($equipment = $equipment_result->fetch_assoc()) {
                $equipment_list[] = $equipment;
            }
        }
    }
}
?>
<div class="container-fluid">
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th colspan="2" class="text-center">Recipe Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Recipe ID:</th>
                <td><b><?php echo isset($recipe_id) ? ucwords($recipe_id) : 'N/A'; ?></b></td>
            </tr>
            <tr>
                <th>Recipe Name:</th>
                <td><b><?php echo isset($recipe_name) ? $recipe_name : 'N/A'; ?></b></td>
            </tr>
            <tr>
                <th>Ingredients:</th>
                <td><b><?php echo isset($ingredients_data) ? $ingredients_data : 'N/A'; ?></b></td>
            </tr>
            <tr>
                <th>Steps to Bake:</th>
                <td><b><?php echo isset($recipe_step) ? $recipe_step : 'N/A'; ?></b></td>
            </tr>
            <tr>
                <th>Equipment Details:</th>
                <td>
                    <?php if (!empty($equipment_list)) : ?>
                        <ul>
                            <?php foreach ($equipment_list as $equipment) : ?>
                                <li><b>Spec ID:</b> <?php echo $equipment['spec_id']; ?> - <b>Used:</b> <?php echo $equipment['eq_used']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <b>No equipment records found.</b>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer display p-0 m-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
    #uni_modal .modal-footer {
        display: none;
    }

    #uni_modal .modal-footer.display {
        display: flex;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table th {
        background-color: #343a40;
        color: #fff;
    }

    .text-center {
        text-align: center;
    }
</style>
