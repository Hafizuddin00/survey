<?php include 'db_connect.php'; ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <a class="btn btn-sm btn-primary btn-flat" href="./index.php?page=new_recipe"><i class="fa fa-plus"></i> Add New Recipe</a>
            <a class="btn btn-sm btn-warning btn-flat" href="./index.php?page=new_product"><i class="fa fa-plus"></i> Add New Product</a>
            <a class="btn btn-sm btn-danger btn-flat" href="./index.php?page=delete_product"><i class="fa fa-minus"></i> Delete product</a>
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
                            <th>Recipe Ingredients</th>
                            <th>Equipment</th>
                            <th>Step to Bake</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        // Query to get recipes and their corresponding ingredients
                        $qry = $conn->query("SELECT r.*, i.ing_type, i.ing_mass FROM receipe r LEFT JOIN ing_list i ON r.recipe_id = i.recipe_id");
                        $recipes = []; // To store grouped recipes

                        // Loop through all results and group by recipe_id
                        while ($row = $qry->fetch_assoc()) {
                            // Ensure we are grouping the ingredients by recipe_id
                            if (!isset($recipes[$row['recipe_id']])) {
                                $recipes[$row['recipe_id']] = [
                                    'product_id' => $row['product_id'],
                                    'recipe_name' => $row['recipe_name'],
                                    'equipment' => $row['equipment'],
                                    'recipe_step' => $row['recipe_step'],
                                    'ingredients' => [] // Initialize an empty array for ingredients
                                ];
                            }

                            // Add ingredient to the corresponding recipe_id
                            if (!empty($row['ing_type']) && !empty($row['ing_mass'])) {
                                $recipes[$row['recipe_id']]['ingredients'][] = $row['ing_type'] . " - " . $row['ing_mass'];
                            }
                        }

                        // Now loop through the grouped recipes
                        foreach ($recipes as $recipe_id => $recipe) :
                            $ingredient_list = implode("<br>", $recipe['ingredients']); // Concatenate all ingredients with <br> separator
                        ?>
                            <tr>
                                <th class="text-center"><?php echo $i++; ?></th>
                                <td><b><?php echo $recipe['product_id']; ?></b></td>
                                <td><b><?php echo $recipe_id; ?></b></td>
                                <td><b><?php echo $recipe['recipe_name']; ?></b></td>
                                <td><b><?php echo $ingredient_list ? $ingredient_list : "No ingredients"; ?></b></td>
                                <td><b><?php echo $recipe['equipment']; ?></b></td>
                                <td><b><?php echo $recipe['recipe_step']; ?></b></td>
                                <td class='text-center'>
                                    <div class='btn-group'>
                                        <a href='./index.php?page=edit_recipe&id=<?php echo $recipe_id; ?>' class='btn btn-primary btn-flat' title='Edit Recipe'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                        <a href='./index.php?page=view_recipe&id=<?php echo $recipe_id; ?>' class='btn btn-info btn-flat' title='View Recipe'>
                                            <i class='fas fa-eye'></i>
                                        </a>
                                        <button type='button' class='btn btn-danger btn-flat delete_survey' data-id='<?php echo $recipe_id; ?>' title='Delete Recipe'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#list').dataTable();

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
                    alert_toast("Failed to delete recipe. Please try again.", 'error');
                }
            }
        });
    }
</script>
