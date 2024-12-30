<?php 

require __DIR__ . "/includes/dbconnection.php";
    $conn = null;
    // Avoid showing error message to end user using die()
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
    } catch (Exception $e) {
        // Log the error for debugging (avoid exposing sensitive details)
        error_log($e->getMessage());
        // Show a user-friendly message
        die("We are experiencing technical difficulties. Please try again later.");
    }
?>
