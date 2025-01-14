<?php include 'db_connect.php'; ?>
<?php 

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the id parameter from the URL

    // Prepare the SQL query to fetch the main record
    $query = "
        SELECT c.*, r.recipe_id, e.spec_id, e.eq_used
        FROM categories c
        LEFT JOIN receipe r ON c.recipe_name = r.recipe_name
        LEFT JOIN equipment_record e ON c.id = e.id
        WHERE c.id = ?
    ";

    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter to the prepared statement
        $stmt->bind_param("i", $id); // "i" means the parameter is an integer

        // Execute the prepared statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_array(MYSQLI_ASSOC); // Fetch the data as an associative array
            foreach ($data as $k => $v) {
                $$k = $v; // Assign the values to variables
            }
        } else {
            echo "No results found for the given ID.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Query failed: " . $conn->error;
    }

    // Get all equipment records for this id
    $equipmentQuery = "
        SELECT spec_id, eq_used FROM equipment_record WHERE id = ?
    ";

    if ($equipmentStmt = $conn->prepare($equipmentQuery)) {
        $equipmentStmt->bind_param("i", $id); // Bind the id to the query
        $equipmentStmt->execute();
        $equipmentResult = $equipmentStmt->get_result();
    }
}
?>

<div class="container-fluid">
    <table class="table">
        <tr>
            <th>Recipe Name:</th>
            <td><b><?php echo ucwords($recipe_name) ?></b></td>
        </tr>
        <tr>
            <th>Quantity Product:</th>
            <td><b><?php echo $qty_product ?></b></td>
        </tr>
        <tr>
            <th>Staff Id:</th>
            <td><b><?php echo $staff_id ?></b></td>
        </tr>
        <tr>
            <th>Created At:</th>
            <td><b><?php echo $created_at ?></b></td>
        </tr>
        <tr>
            <th>Started Date:</th>
            <td><b><?php echo $starteddate ?></b></td>
        </tr>
        <tr>
            <th>End Date:</th>
            <td><b><?php echo $enddate ?></b></td>
        </tr>
        <tr>
            <th>Duration (Day):</th>
            <td><b><?php echo $hours ?></b></td>
        </tr>
        <tr>
            <th>Product ID:</th>
            <td><b><?php echo $product_id ?></b></td>
        </tr>
        <tr>
            <th>Recipe ID:</th>
            <td><b><?php echo $recipe_id ?></b></td>
        </tr>
        <tr>
            <th>Recipe Ingredients:</th>
            <td><b><?php echo $ingredients_data ?></b></td>
        </tr>

        <tr>
            <th>Equipment Used:</th>
            <td>
                <b>
                    <?php 
                    if ($equipmentResult->num_rows > 0) {
                        // Loop through all equipment records
                        while ($equipment = $equipmentResult->fetch_assoc()) {
                            echo "Spec ID: " . $equipment['spec_id'] . " -> " . $equipment['eq_used'] . "<br>";
                        }
                    } else {
                        echo "No equipment data found.";
                    }
                    ?>
                </b>
            </td>
        </tr>

        <tr>
            <th>Quality (Status):</th>
            <td><b><?php echo $quality_test ?></b></td>
        </tr>
        <tr>
            <th>Comment:</th>
            <td><b><?php echo $comment ?></b></td>
        </tr>
        <tr>
            <th>Status:</th>
            <td><b><?php echo $status ?></b></td>
        </tr>
    </table>
</div>

<div class="modal-footer display p-0 m-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>

<style>
    #uni_modal .modal-footer{
        display: none
    }
    #uni_modal .modal-footer.display{
        display: flex
    }
</style>
