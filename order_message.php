<?php
include 'db_connect.php';

// Enable exception mode for MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Update status in order_message table from categories table
    $stmt_select = $conn->prepare("SELECT o.order_id, c.status AS category_status 
                                   FROM order_customer o 
                                   JOIN categories c ON o.order_id = c.order_id");

    $stmt_select->execute();
    $result = $stmt_select->get_result();

    $stmt_update = $conn->prepare("UPDATE order_customer SET status = ? WHERE order_id = ?");
    
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['order_id'];
        $status = $row['category_status'];
        $stmt_update->bind_param('si', $status, $order_id);
        $stmt_update->execute();
    }

    $stmt_update->close();
    $stmt_select->close();

} catch (mysqli_sql_exception $e) {
    // Catch MySQLi exceptions and display the error message
    die("Database Error: " . $e->getMessage());
}

?>

<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Order ID</th>
                        <th>Recipe Name</th>
                        <th>Customer Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Status</th>
						<th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $i = 1;
                        $stmt_list = $conn->prepare("SELECT * FROM order_customer");
                        $stmt_list->execute();
                        $result_list = $stmt_list->get_result();

                        while ($row = $result_list->fetch_assoc()): 
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo $row['order_id'] ?></b></td>
                        <td><b><?php echo $row['recipe_name'] ?></b></td>
                        <td><b><?php echo $row['customer_name'] ?></b></td>
                        <td><b><?php echo $row['quantity']?></b></td>
                        <td><b><?php echo $row['order_date']?></b></td>
                        <td><b><?php echo $row['status']?></b></td>
						<td class="text-center" style="width: 10px;">
   						 <a class="btn btn-primary btn-sm btn-flat wave-effect" href="./index.php?page=edit_order&order_id=<?php echo $row['order_id'] ?>">
      						  Edit
   						 </a>
						</td>

                    </tr>    
                    <?php endwhile; 
                        $stmt_list->close();
                    } catch (mysqli_sql_exception $e) {
                        die("Error fetching data: " . $e->getMessage());
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#list').dataTable()
    })
</script>
