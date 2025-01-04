<?php 
if (!isset($conn)) {
    include 'includes/dbconnection.php'; 
    include 'db_connect.php'; 
}

// Fetch the recipe details if in edit mode
$recipe_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($recipe_id) {
    $qry = $conn->query("SELECT * FROM receipe WHERE recipe_id = $recipe_id");
    $row = $qry->fetch_array();
    if ($row) {
        $recipe_name = htmlspecialchars($row['recipe_name']);
        $recipe_step = htmlspecialchars($row['recipe_step']);
        $equipment = htmlspecialchars($row['equipment']);
        $product_id = htmlspecialchars($row['product_id']);
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_recipe">
                <input type="hidden" name="id" value="<?php echo isset($recipe_id) ? $recipe_id : ''; ?>">

                <div class="row">
                    <div class="col-md-6 border-right">
                        <b class="text-muted">Recipe Information</b>
                        
                        <div class="form-group">
                            <label for="recipe_id">Recipe ID *</label>
                            <input type="text" name="recipe_id" id="recipe_id" class="form-control form-control-sm" required value="<?php echo isset($recipe_id) ? $recipe_id : ''; ?>" <?php echo isset($recipe_id) ? 'readonly' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label for="product_id">Product ID *</label>
                            <select name="product_id" id="product_id" class="form-control form-control-sm" required>
                                <option value="">Select Product ID</option>
                                <?php
                                $sql2 = "SELECT * FROM typeproduct";
                                $query2 = $dbh->prepare($sql2);
                                $query2->execute();
                                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($result2 as $row1) {
                                    $selected = ($row1->product_id == $product_id) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row1->product_id); ?>" <?php echo $selected; ?>>
                                        <?php echo htmlspecialchars($row1->product_id); ?> - <?php echo htmlspecialchars($row1->product_name); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipe_name">Recipe Name *</label>
                            <input type="text" name="recipe_name" id="recipe_name" class="form-control form-control-sm" required value="<?php echo isset($recipe_name) ? $recipe_name : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="recipe_step">Steps *</label>
                            <textarea name="recipe_step" id="recipe_step" cols="30" rows="5" class="form-control" required><?php echo isset($recipe_step) ? $recipe_step : ''; ?></textarea>
                        </div>
                        </div>
                        <div class = col-md-6 >
                        <div class="form-group">
                            <label for="equipment">Equipment *</label>
                            <textarea name="equipment" id="equipment" cols="30" rows="3" class="form-control" required><?php echo isset($equipment) ? $equipment : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="ingredients">Add Ingredients</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="ingredient" class="form-control form-control-sm" placeholder="Ingredient">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" step="0.01" id="quantity" class="form-control form-control-sm" placeholder="Quantity">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="add_ingredient" class="btn btn-sm btn-primary">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ingredients_list">Ingredients List</label>
                            <textarea id="ingredients_list" class="form-control form-control-sm" rows="8" readonly></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button type="submit" class="btn btn-success mr-2">Save Recipe</button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='index.php?page=manage_recipe'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {
    let ingredients = [];

    $('#add_ingredient').click(function () {
        const ingredient = $('#ingredient').val().trim();
        const qty = parseFloat($('#quantity').val());
        if (ingredient && !isNaN(qty) && qty > 0) {
            ingredients.push({ ingredient, qty });
            $('#ingredients_list').val(ingredients.map(i => `${i.ingredient} - ${i.qty}`).join('\n'));
            $('#ingredient').val('');
            $('#quantity').val('');
        } else {
            alert('Please provide valid ingredient and quantity.');
        }
    });

    $('#manage_recipe').submit(function (e) {
        e.preventDefault();
        const recipeData = {
            id: $('input[name="id"]').val(),
            recipe_id: $('#recipe_id').val(),
            product_id: $('#product_id').val(),
            recipe_name: $('#recipe_name').val(),
            equipment: $('#equipment').val(),
            recipe_step: $('#recipe_step').val(),
            ingredients: ingredients,
        };

        $.ajax({
            url: 'ajax.php?action=save_recipe',
            data: JSON.stringify(recipeData),
            contentType: 'application/json',
            processData: false,
            method: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    alert('Recipe successfully saved.');
                    location.href = 'index.php?page=manage_recipe';
                } else {
                    alert('Failed to save the recipe.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
