<?php
// Include database connection
if(!isset($conn)){
	include 'includes/dbconnection.php' ;
	include 'db_connect.php' ;
}  // Adjust the path based on your project structure

if (isset($_GET['product_id1'])) {
    $product_id1 = $_GET['product_id1'];  // Get the product ID from the GET request

    $sql = "SELECT recipe_name FROM receipe WHERE product_id = :product_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':product_id', $product_id1, PDO::PARAM_INT);

    try {
        $query->execute();
        $recipes = $query->fetchAll(PDO::FETCH_OBJ);  // Fetch all recipe names
        echo json_encode($recipes);  // Send the result as JSON
    } catch (PDOException $e) {
        error_log("Database query failed: " . $e->getMessage()); // Log the detailed error
        echo json_encode(['error' => 'An internal error occurred. Please try again later.']); // Generic error message
    }
} else {
    echo json_encode(['error' => 'Product ID not provided.']);
}
?>
