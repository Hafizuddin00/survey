<?php
if (!isset($conn)) {
    include 'includes/dbconnection.php';
    include 'db_connect.php';
}

// Fetch the recipe details if in edit mode
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if ($recipe_id) {
    $stmt = $conn->prepare("SELECT * FROM receipe WHERE recipe_id = ?");
    $stmt->bind_param("i", $recipe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $recipe_name = htmlspecialchars($row['recipe_name']);
        $recipe_step = htmlspecialchars($row['recipe_step']);
        $equipment = htmlspecialchars($row['equipment']);
        $product_id = htmlspecialchars($row['product_id']);
    }

    $stmt->close();
}

$query = $conn->query("SELECT MAX(recipe_id) AS max_id FROM receipe");
$row = $query->fetch_assoc();
$new_recipe_id = $row['max_id'] + 1;
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
                            <input type="text" name="recipe_id" id="recipe_id" class="form-control form-control-sm" required 
                            value="<?php echo isset($recipe_id) ? $recipe_id : $new_recipe_id; ?>" readonly>
                            <small class="text-blue">The recipe id has automatically been created for you. You just need to fill all the blank fields.</small>
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
                            <textarea name="recipe_step" id="recipe_step" cols="30" rows="15" class="form-control" required><?php echo isset($recipe_step) ? $recipe_step : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="equipment_details">Add Equipment</label>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <select id="equipment_details" class="form-control form-control-sm">
                                        <option value="" disabled selected>Select Equipment</option>
                                        <?php
                                        $sql3 = "SELECT * FROM equipment_details";
                                        $query3 = $dbh->prepare($sql3);
                                        $query3->execute();
                                        $result3 = $query3->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($result3 as $row2) {
                                            ?>
                                            <option value="<?php echo htmlspecialchars($row2->spec_id); ?>">
                                                <?php echo htmlspecialchars($row2->spec_id); ?> - <?php echo htmlspecialchars($row2->eq_description); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" id="add_equipment" class="btn btn-sm btn-primary">Add</button>
                                </div>
                            </div>
                            <small class="text-danger">-- Add equipment with specific quantity.</small>
                        </div>

                        <!-- Equipment Table -->
                        <div class="form-group mt-3">
                            <label for="equipment_table">Equipment List</label>
                            <table class="table table-bordered table-sm" id="equipment_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic content -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Ingredients Section -->
                        <div class="form-group">
                            <label for="ingredients">Add Ingredients</label>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <input type="text" id="ingredient" class="form-control form-control-sm" placeholder="Ingredient">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" id="quantity" class="form-control form-control-sm" placeholder="Quantity">
                                </div>
                                <div class="col-md-3">
                                    <select id="unit" class="form-control form-control-sm">
                                        <option value="" disabled selected>Select Unit</option>
                                        <option value="unit">Unit</option>
                                        <option value="kg">KG</option>
                                        <option value="g">Gram</option>
                                        <option value="ml">ML</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="add_ingredient" class="btn btn-sm btn-primary">Add</button>
                                </div>
                            </div>
                            <small class="text-danger">-- (e.g., Flour 2 kg where 2 is the quantity and kg is the unit)</small>
                        </div>
                        <div class="form-group">
                            <label for="qty">Enter Quantity ( recipe ) *</label>
                            <input type="text" name="qty" id="qty" class="form-control form-control-sm" required value="<?php echo isset($qty) ? $qty : ''; ?>">
                        </div>

                        <!-- Ingredients Table -->
                        <div class="form-group mt-3">
                            <label for="ingredients_table">Ingredients List</label>
                            <table class="table table-bordered table-sm" id="ingredients_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ingredient</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic content -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="col-lg-12 text-right justify-content-center d-flex flex-column align-items-center">
                    
                    <div>
                        <button type="submit" class="btn btn-success mr-2">Save Recipe</button>
                        <button type="button" class="btn btn-secondary" onclick="location.href='index.php?page=manage_recipe'">Cancel</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
let equipment = [];
let ingredients = [];

// Handle adding equipment
$('#add_equipment').click(function () {
    const specId = $('#equipment_details').val().trim();
    const description = $("#equipment_details option:selected").text().trim();

    if (specId) {
        // Add to the equipment array
        equipment.push({ specId, description });

        // Update the equipment table
        $('#equipment_table tbody').append(`
            <tr>
                <td>${equipment.length}</td>
                <td>${description}</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-equipment">Delete</button></td>
            </tr>
        `);

        // Clear the input fields
        $('#equipment_details').val('');
    } else {
        alert('Please select valid equipment.');
    }
});

// Handle equipment removal
$('#equipment_table').on('click', '.remove-equipment', function () {
    const index = $(this).closest('tr').index();
    equipment.splice(index, 1); // Remove from equipment array
    $(this).closest('tr').remove(); // Remove from table
    // Reindex the table
    $('#equipment_table tbody tr').each(function (i) {
        $(this).find('td:first').text(i + 1);
    });
});

// Handle adding ingredients
$('#add_ingredient').click(function () {
    const ingredient = $('#ingredient').val().trim();
    const qty = parseFloat($('#quantity').val());
    const unit = $('#unit').val();

    if (ingredient && !isNaN(qty) && qty > 0 && unit) {
        // Add to the ingredients array
        ingredients.push({ ingredient, qty, unit });

        // Update the ingredients table
        $('#ingredients_table tbody').append(`
            <tr>
                <td>${ingredients.length}</td>
                <td>${ingredient}</td>
                <td>${qty}</td>
                <td>${unit}</td>
                <td><button type="button" class="btn btn-danger btn-sm remove-ingredient">Delete</button></td>
            </tr>
        `);

        // Clear the input fields
        $('#ingredient').val('');
        $('#quantity').val('');
        $('#unit').val('');
    } else {
        alert('Please provide valid ingredient, quantity, and unit.');
    }
});

// Handle ingredient removal
$('#ingredients_table').on('click', '.remove-ingredient', function () {
    const index = $(this).closest('tr').index();
    ingredients.splice(index, 1); // Remove from ingredients array
    $(this).closest('tr').remove(); // Remove from table
    // Reindex the table
    $('#ingredients_table tbody tr').each(function (i) {
        $(this).find('td:first').text(i + 1);
    });
});

// Handle form submission
$('#manage_recipe').submit(function (e) {
    e.preventDefault();

    const recipeData = {
        id: $('input[name="id"]').val(),
        recipe_id: $('#recipe_id').val(),
        product_id: $('#product_id').val(),
        recipe_name: $('#recipe_name').val(),
        recipe_step: $('#recipe_step').val(),
        equipment: equipment, // Pass the equipment array
        qty: $('#qty').val(),
        ingredients: ingredients, // Pass the ingredients array
    };

    $.ajax({
        url: 'ajax.php?action=save_recipe',
        data: JSON.stringify(recipeData),
        contentType: 'application/json',
        processData: false,
        method: 'POST',
        success: function (resp) {
            if (resp != 1) {
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
</script>
