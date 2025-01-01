<?php 
if (!isset($conn)) {
    include 'includes/dbconnection.php'; 
    include 'db_connect.php'; 
}

// Fetch the recipe details if we are in edit mode
$recipe_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($recipe_id) {
    // Fetch recipe from the database for editing
    $qry = $conn->query("SELECT * FROM receipe WHERE recipe_id = $recipe_id");
    $row = $qry->fetch_array();  // Get the recipe data
    
    // Set the recipe data for use in the form
    if ($row) {
        $recipe_name = $row['recipe_name'];
        $recipe_ing = $row['recipe_ing'];
        $recipe_step = $row['recipe_step'];
        $equipment = $row['equipment'];
        $product_id = $row['product_id'];

    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_recipe">
                <!-- Hidden field for existing recipe ID -->
                <input type="hidden" name="id" value="<?php echo isset($recipe_id) ? $recipe_id : ''; ?>">

                <div class="row">
                    <div class="col-md-6 border-right">
                        <b class="text-muted">Recipe Information</b>
                        <div class="form-group">
                            <label for="product_id">Product ID *</label>
                            <select name="product_id" id="product_id" class="form-control form-control-sm" required="true">
                                <option value="">Select Product ID</option>
                                <?php
                                // Fetch Product IDs from the typeproduct table
                                $sql2 = "SELECT * FROM typeproduct";
                                $query2 = $dbh->prepare($sql2);
                                $query2->execute();
                                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($result2 as $row1) {
                                    $selected = ($row1->product_id == $product_id) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo htmlentities($row1->product_id); ?>" <?php echo $selected; ?>>
                                        <?php echo htmlentities($row1->product_id); ?> - <?php echo htmlentities($row1->product_name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipe_id">Recipe ID *</label>
                            <?php if ($recipe_id): ?>
                                <input type="number" name="recipe_id" class="form-control form-control-sm" required value="<?php echo $recipe_id; ?>" readonly>
                            <?php else: ?>
                                <input type="number" name="recipe_id" class="form-control form-control-sm" required>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="recipe_name">Recipe Name *</label>
                            <input type="text" name="recipe_name" class="form-control form-control-sm" required value="<?php echo isset($recipe_name) ? $recipe_name : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="recipe_ing">Recipe Ingredients *</label>
							<textarea name="recipe_ing" id="" cols="30" rows="6" class="form-control" required><?php echo isset($recipe_ing) ? $recipe_ing : '' ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="equipment">Equipment to use *</label>
							<textarea name="equipment" id="" cols="30" rows="5" class="form-control" required><?php echo isset($equipment) ? $equipment : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="recipe_step">Steps to Bake *</label>
							<textarea name="recipe_step" id="" cols="30" rows="10" class="form-control" required><?php echo isset($recipe_step) ? $recipe_step : '' ?></textarea>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-success mr-2">Save Recipe</button>
                    <button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=manage_recipe'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#manage_recipe').submit(function(e) {
    e.preventDefault();
    $('input').removeClass("border-danger");
    start_load();
    $('#msg').html('');

    // Determine if it's an update or a new recipe based on the presence of a recipe ID
    var action = "<?php echo isset($recipe_id) ? 'update' : 'insert'; ?>";
    
    $.ajax({
        url: 'ajax.php?action=' + action + '_recipe',  // Adjust the action based on whether it's insert or update
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Failed to save the recipe.', "error");
            } else {
                alert_toast('Recipe successfully saved.', "success");
                setTimeout(function() {
                    location.replace('index.php?page=manage_recipe');
                }, 1500);
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error: ', status, error);
            $('#response-message').html('An error occurred while saving the recipe.');
        }
    });
});
</script>
