<?php 
if (!isset($conn)) {
    include 'includes/dbconnection.php'; 
    include 'db_connect.php'; 
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="delete_product">
                <div class="form-group">
                    <label for="product_id">Product ID *</label>
                    <select name="product_id" id="product_id" class="form-control form-control-sm" style = "width : 500px" required="true">
                        <option value="">Select Product ID</option>
                        <?php
                        // Fetch Product IDs from the typeproduct table
                        $sql2 = "SELECT * FROM typeproduct";
                        $query2 = $dbh->prepare($sql2);
                        $query2->execute();
                        $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                        foreach ($result2 as $row1) { ?>
                            <option value="<?php echo htmlentities($row1->product_id); ?>">
                                <?php echo htmlentities($row1->product_id); ?> - <?php echo htmlentities($row1->product_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <hr>
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-danger mr-2" type="submit">Delete Product</button>
                    <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=manage_recipe'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#delete_product').submit(function(e) {
    e.preventDefault();

    let product_id = $('#product_id').val();
    if (!product_id) {
        alert_toast('Please select a product to delete.', 'error');
        return;
    }

    // Confirmation dialog
    if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        return;
    }

    start_load();

    $.ajax({
        url: 'ajax.php?action=delete_product',
        method: 'POST',
        data: { product_id: product_id },
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Product successfully deleted.', 'success');
                setTimeout(function() {
                    location.replace('index.php?page=manage_recipe');
                }, 1500);
            } else {
                alert_toast('Failed to delete the product.', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error: ', status, error);
            alert_toast('An error occurred while deleting the product.', 'error');
        },
        complete: function() {
            end_load();
        }
    });
});
</script>
