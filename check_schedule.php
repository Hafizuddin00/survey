<?php
include 'includes/dbconnection.php';

/**
 * Check if the staff (baker) is available for the given date range.
 *
 * @param int $staff_id
 * @param string $start_date
 * @param string $end_date
 * @param PDO $dbh
 * @return bool
 */
function isStaffAvailable($staff_id, $start_date, $end_date, $dbh) {
    $sql = "
        SELECT 1 
        FROM categories
        WHERE staff_id = :staff_id
        AND (
            (:start_date BETWEEN starteddate AND enddate)
            OR (:end_date BETWEEN starteddate AND enddate)
            OR (starteddate BETWEEN :start_date AND :end_date)
        )
        AND status != 'Finished'
    ";

    $query = $dbh->prepare($sql);
    $query->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
    $query->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    $query->execute();

    return $query->rowCount() === 0;
}

if (isset($_GET['staff_id'], $_GET['start_date'], $_GET['end_date'])) {
    $staff_id = intval($_GET['staff_id']);
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    try {
        // Check if the staff is available
        $available = isStaffAvailable($staff_id, $start_date, $end_date, $dbh);

        // Send JSON response
        echo json_encode(['available' => $available]);
    } catch (Exception $e) {
        // Handle errors gracefully
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'An error occurred while checking availability.', 'details' => $e->getMessage()]);
    }
} else {
    // Invalid request response
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing required parameters.']);
}
?>