<?php
// fetch_order_details.php

// Include database connection
include('db_connection.php'); 

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Prepare SQL query to fetch order details
    $sql = "SELECT * FROM order_customer WHERE order_id = :order_id LIMIT 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the result
    $order = $stmt->fetch(PDO::FETCH_OBJ);

    // Check if order is found
    if ($order) {
        // Return the order details as JSON
        echo json_encode([
            'success' => true,
            'order_id' => $order->order_id,
            'recipe_name' => $order->recipe_name,
            'quantity' => $order->quantity,
            'order_date' => $order->order_date
        ]);
    } else {
        // Return an error response if the order was not found
        echo json_encode(['success' => false]);
    }
} else {
    // If no order_id is provided, return error
    echo json_encode(['success' => false]);
}
?>
