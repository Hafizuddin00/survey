<?php include'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <a class="btn btn-sm btn-primary btn-flat" href="./index.php?page=new_recipe"><i class="fa fa-plus"></i> Add New Recipe</a>
            <a class="btn btn-sm btn-warning btn-flat" href="./index.php?page=new_product"><i class="fa fa-plus"></i> Add New Product</a>
            <div class="card-tools"></div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="list">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Product ID</th>
                            <th>Recipe ID</th>
                            <th>Recipe Name</th>
                            <th>Recipe Ingredient</th>
                            <th>Equipment</th>
                            <th>Step to Bake</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM receipe");
                        while ($row = $qry->fetch_assoc()) : ?>
                            <tr>
                                <th class="text-center"><?php echo $i++; ?></th>
                                <td><b><?php echo $row['product_id']; ?></b></td>
                                <td><b><?php echo $row['recipe_id']; ?></b></td>
                                <td><b><?php echo $row['recipe_name']; ?></b></td>
                                <td><b><?php echo $row['recipe_ing']; ?></b></td>
                                <td><b><?php echo $row['equipment']; ?></b></td>
                                <td><b><?php echo $row['recipe_step']; ?></b></td>
                                <td class='text-center'>
                                    <div class='btn-group'>
                                        <a href='./index.php?page=edit_recipe&id=<?php echo $row['recipe_id']; ?>' class='btn btn-primary btn-flat' title='Edit Recipe'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <a href='./index.php?page=view_recipe&id=<?php echo $row['recipe_id']; ?>' class='btn btn-info btn-flat' title='View Recipe'>
                                            <i class='fas fa-eye'></i>
                                        </a>
                                        <button type='button' class='btn btn-danger btn-flat delete_survey' data-id='<?php echo $row['recipe_id']; ?>' title='Delete Recipe'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#list').dataTable();

        // Event delegation for the view_templates button
        $('.view_templates').click(function() {
            uni_modal("<i class='fa fa-id-card'></i> Category Details", "view_templates.php?id=" + $(this).attr('data-id'))
        });

        // Event delegation for the delete_survey button
        $(document).on('click', '.delete_survey', function() {
            _conf("Are you sure to delete this recipe?", "delete_survey", [$(this).attr('data-id')]);
        });
    });

    // Function to handle the deletion of a survey
    function delete_survey($id) {
        $.ajax({
            url: 'ajax.php?action=delete_survey',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast('Data successfully deleted', 'success');
                    setTimeout(function() {
                        location.reload(); // Reload the page after successful deletion
                    }, 1500);
                    $('.modal').modal('hide');
                } else {
                    alert_toast("Failed to delete category. Please try again.", 'error');
                }
            }
        });
    }
</script>

