<?php 
include 'db_connect.php';

try {
    // Validate database connection
    if (!$conn) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute a statement to retrieve "Finished" records
    $stmt_finished = $conn->prepare("SELECT * FROM categories WHERE status = ?");
    if (!$stmt_finished) {
        throw new Exception("Error preparing statement for retrieving finished records: " . $conn->error);
    }

    $status = 'Finished';
    $stmt_finished->bind_param('s', $status);
    $stmt_finished->execute();
    $result_finished = $stmt_finished->get_result();

    // Process each "Finished" record
    while ($row = $result_finished->fetch_assoc()) {
        $batch_id = $row['id'];

        // Prepare and execute a statement to fetch equipment records for the batch
        $stmt_equipment = $conn->prepare("SELECT * FROM equipment_record WHERE id = ?");
        if (!$stmt_equipment) {
            throw new Exception("Error preparing statement for fetching equipment records: " . $conn->error);
        }

        $stmt_equipment->bind_param('i', $batch_id);
        $stmt_equipment->execute();
        $result_equipment = $stmt_equipment->get_result();

        while ($equipment = $result_equipment->fetch_assoc()) {
            $spec_id = $equipment['spec_id'];
            $eq_used = $equipment['eq_used'];

            // Prepare and execute a statement to update equipment_details
            $stmt_update = $conn->prepare("
                UPDATE equipment_details 
                SET 
                    eq_not_used = eq_not_used + ?, 
                    eq_used = eq_used - ? 
                WHERE spec_id = ?
            ");
            if (!$stmt_update) {
                throw new Exception("Error preparing statement for updating equipment details: " . $conn->error);
            }

            $stmt_update->bind_param('iis', $eq_used, $eq_used, $spec_id);
            $stmt_update->execute();
            $stmt_update->close();
        }

        $stmt_equipment->close();

        // Prepare and execute a statement to delete equipment records for the batch
        $stmt_delete = $conn->prepare("DELETE FROM equipment_record WHERE id = ?");
        if (!$stmt_delete) {
            throw new Exception("Error preparing statement for deleting equipment records: " . $conn->error);
        }

        $stmt_delete->bind_param('i', $batch_id);
        $stmt_delete->execute();
        $stmt_delete->close();
    }

    $stmt_finished->close();
} catch (Exception $e) {
    // Log the error and display a generic message
    echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
    echo "An error occurred while processing the records. Please try again later.";
}

// Close the database connection if no further queries are needed
// $conn->close();
?>
