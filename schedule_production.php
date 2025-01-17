<?php
if (!isset($conn)) {
    include 'includes/dbconnection.php';
    include 'db_connect.php';
    $id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) {
    $sql = "SELECT * FROM categories WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
}
}
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_categories" method="post">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6 border-right">                        
                        <b class="text-muted">Production Information</b>



                        <div class="form-group">
                            <label for="order_id">Order ID *</label>
                            <select name="order_id" id="order_id" class="form-control form-control-sm">
                                <option value="">Select Order ID</option>
                                <?php 
                                $sql2 = "SELECT * FROM order_customer WHERE status != 'Finished'";
                                $query2 = $dbh->prepare($sql2);
                                $query2->execute();
                                $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($result2 as $row1) {          
                                ?>  
                                <option value="<?php echo htmlentities($row1->order_id); ?>">
                                    <?php echo htmlentities($row1->order_id); ?> - <?php echo htmlentities($row1->customer_name); ?>
                                </option>
                                <?php } ?> 
                            </select>
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
                                ?>  
                                <option value="<?php echo htmlentities($row1->product_id); ?>">
                                    <?php echo htmlentities($row1->product_id); ?> - <?php echo htmlentities($row1->product_name); ?>
                                </option>
                                <?php } ?> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipe_name">Recipe Name *</label>
                            <select name="recipe_name" id="recipe_name" class="form-control form-control-sm" required>
                                <option value="">Select Recipe Name</option>
                            </select>
                        </div>

                        <script>
                            document.getElementById("product_id").addEventListener("change", function () {
                                var product_id = this.value;
                                var recipeSelect = document.getElementById("recipe_name");
                                recipeSelect.innerHTML = "<option value=''>Select Recipe Name</option>";

                                if (product_id !== "") {
                                    var xhr = new XMLHttpRequest();
                                    xhr.open("GET", "get_recipes.php?product_id1=" + product_id, true);
                                    xhr.onload = function () {
                                        if (xhr.status === 200) {
                                            try {
                                                var recipes = JSON.parse(xhr.responseText);
                                                recipes.forEach(function (recipe) {
                                                    var option = document.createElement("option");
                                                    option.value = recipe.recipe_name;
                                                    option.textContent = recipe.recipe_name;
                                                    recipeSelect.appendChild(option);
                                                });
                                            } catch (e) {
                                                console.error("Error parsing JSON response:", e);
                                            }
                                        } else {
                                            console.error("Error fetching recipes:", xhr.status, xhr.responseText);
                                        }
                                    };
                                    xhr.onerror = function () {
                                        console.error("AJAX request failed.");
                                    };
                                    xhr.send();
                                }
                            });
                        </script>




                        <div class="form-group">
                            <label class="control-label">Quantity Product *</label>
                            <input type="number" name="qty_product" id="qty_product" class="form-control" required placeholder="Enter Quantity Product">
							<small class="text-danger">-- Please add quantity more than user need for backup!</small>
                            <br>
							<b class="text-muted">Apply for resource allocation from Inventory System</b>
                        </div>

                        <div id="ingredients_table_container" class="mt-4">
                            <!-- Ingredients table will be displayed here -->
                        </div>
						<div id="equipment_table_container" class="mt-4">
							<!-- Equipment table will be displayed here -->
						</div>

                        <script>
                            document.getElementById("recipe_name").addEventListener("change", function () {
                                var recipeName = this.value;
                                var qtyProduct = document.getElementById("qty_product").value;

                                if (recipeName !== "" && qtyProduct > 0) {
                                    var xhr = new XMLHttpRequest();
                                    xhr.open("GET", `fetch_ingredients.php?recipe_name=${recipeName}&qty=${qtyProduct}`, true);
                                    xhr.onload = function () {
                                        if (xhr.status === 200) {
                                            document.getElementById("ingredients_table_container").innerHTML = xhr.responseText;

                                            // Collect the ingredients from the table
                                            var ingredientsData = [];
                                            var rows = document.querySelectorAll('#ingredients_table_container table tbody tr');
                                            rows.forEach(function(row) {
                                                var ingredient = row.cells[0].textContent;
                                                var mass = row.cells[1].textContent;
                                                var unit = row.cells[2].textContent;

                                                ingredientsData.push({ ingredient, mass, unit });
                                            });

                                            // Set the ingredients data as a hidden field
                                            var ingredientsInput = document.createElement('input');
                                            ingredientsInput.type = 'hidden';
                                            ingredientsInput.name = 'ingredients_data';
                                            ingredientsInput.value = JSON.stringify(ingredientsData);
                                            document.getElementById('manage_categories').appendChild(ingredientsInput);
                                        } else {
                                            console.error("Error fetching ingredients:", xhr.status, xhr.responseText);
                                        }
                                    };
                                    xhr.onerror = function () {
                                        console.error("AJAX request failed.");
                                    };
                                    xhr.send();
                                }
                            });

                            document.getElementById("qty_product").addEventListener("change", function () {
                                var recipeName = document.getElementById("recipe_name").value;
                                var qtyProduct = this.value;

                                if (recipeName !== "" && qtyProduct > 0) {
                                    var xhr = new XMLHttpRequest();
                                    xhr.open("GET", `fetch_ingredients.php?recipe_name=${recipeName}&qty=${qtyProduct}`, true);
                                    xhr.onload = function () {
                                        if (xhr.status === 200) {
                                            document.getElementById("ingredients_table_container").innerHTML = xhr.responseText;

                                            // Collect the ingredients from the table
                                            var ingredientsData = [];
                                            var rows = document.querySelectorAll('#ingredients_table_container table tbody tr');
                                            rows.forEach(function(row) {
                                                var ingredient = row.cells[0].textContent;
                                                var mass = row.cells[1].textContent;
                                                var unit = row.cells[2].textContent;

												var formattedIngredient = `${ingredient} - ${mass} ${unit}`;
												ingredientsData.push(formattedIngredient);
                                            });

                                            // Set the ingredients data as a hidden field
                                            var ingredientsInput = document.createElement('input');
                                            ingredientsInput.type = 'hidden';
                                            ingredientsInput.name = 'ingredients_data';
                                            ingredientsInput.value = JSON.stringify(ingredientsData);
                                            document.getElementById('manage_categories').appendChild(ingredientsInput);
                                        } else {
                                            console.error("Error fetching ingredients:", xhr.status, xhr.responseText);
                                        }
                                    };
                                    xhr.onerror = function () {
                                        console.error("AJAX request failed.");
                                    };
                                    xhr.send();
                                }
                            });

                            document.addEventListener('DOMContentLoaded', () => {
    document.getElementById("recipe_name").addEventListener("change", updateEquipmentData);
    document.getElementById("qty_product").addEventListener("change", updateEquipmentData);
});

function updateEquipmentData() {
    const recipeName = document.getElementById("recipe_name").value;
    const qtyProduct = document.getElementById("qty_product").value;

    if (recipeName !== "" && qtyProduct > 0) {
        fetch(`fetch_equipment.php?recipe_name=${recipeName}&qty=${qtyProduct}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                document.getElementById("equipment_table_container").innerHTML = data.equipment_html;
                const equipmentData = data.equipment_data;
                const rows = document.querySelectorAll('#equipment_table_container table tbody tr');
                
                rows.forEach((row, index) => {
                    const input = row.cells[2].querySelector('input');
                    if (input) {
                        // Attach id and order_id to the equipmentData objects
                        const equipmentId = row.dataset.id || null; // Assuming data-id is set on the row
                        const orderId = row.dataset.orderId || null; // Assuming data-order-id is set on the row

                        equipmentData[index] = {
                            ...equipmentData[index],
                            id: equipmentId,
                            order_id: orderId
                        };

                        input.value = equipmentData[index].qty;
                        console.log(`Initial qty for equipment ${index}:`, equipmentData[index].qty);

                        input.addEventListener('input', function() {
                            let qtyValue = parseInt(this.value, 10) || 0;
                            if (qtyValue > equipmentData[index].max_qty) {
                                alert('Quantity exceeds available equipment.');
                                qtyValue = equipmentData[index].max_qty;
                                this.value = qtyValue;
                            }
                            equipmentData[index].qty = qtyValue;
                            console.log(`Updated equipmentData[${index}].qty:`, equipmentData[index].qty);

                            // Update hidden input field with the latest equipment data
                            document.getElementById('equipment_data_input').value = JSON.stringify(equipmentData);
                        });
                    }
                });

                const equipmentInput = document.getElementById('equipment_data_input');
                if (!equipmentInput) {
                    const newEquipmentInput = document.createElement('input');
                    newEquipmentInput.type = 'hidden';
                    newEquipmentInput.name = 'equipment_data';
                    newEquipmentInput.id = 'equipment_data_input';
                    document.getElementById('manage_categories').appendChild(newEquipmentInput);
                }
                document.getElementById('equipment_data_input').value = JSON.stringify(equipmentData);

                console.log("Final equipmentData:", JSON.stringify(equipmentData, null, 2));
            })
            .catch(error => {
                console.error('Error fetching equipment:', error);
            });
    }
}







</script>						

					
						</div>	
						<div class ="col-md-6">
						<b class="text-muted">Staf Allocation</b>
						<b></b>
						<div class="form-group">
							<label for="staff_id">Assigned to Staff ID *</label>
							<select name="staff_id" id="staff_id" class="form-control form-control-sm" required="true">
								<option value="">Select Staff ID</option>
								<?php 
								// Fetch Product IDs from the typeproduct table
								$sql2 = "SELECT staff_id FROM users WHERE staff_id NOT IN (0,100005)";
								$query2 = $dbh->prepare($sql2);
								$query2->execute();
								$result2 = $query2->fetchAll(PDO::FETCH_OBJ);

								foreach ($result2 as $row1) {          
								?>  
									<option value="<?php echo htmlentities($row1->staff_id); ?>">
										<?php echo htmlentities($row1->staff_id); ?>
									</option>
								<?php } ?> 
							</select>
						</div>

                        <div class="form-group">
    <label class="control-label">Started Date *</label>
    <input type="date" name="starteddate" class="form-control" required value="<?php echo date('Y-m-d'); ?>" onkeydown="return false" readonly>
</div>


							<div class="form-group">
								<label class="control-label">End Date *</label>
								<input type="date" name="enddate" class="form-control" required value="<?php echo isset($enddate) ? $enddate : '' ?>">
							</div>
							<div class = "form-group">
								<label class="control-label">Estimated Day*</label>
								<input type="number" name="hours" class="form-control" required placeholder="Enter duration in " value="<?php echo isset($hours) ? $hours : '' ?>">
							</div>
							<div class="form-group">
    						<label for="status">Status (Baker will update the status)</label>
							<input type="text" name="status" class="form-control" required value="Unfinished" readonly>
							</div>

							
						</div>
					</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button type="submit" name="submit" class="btn btn-success mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=production'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>

    document.addEventListener("DOMContentLoaded", function () {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const minDate = `${year}-${month}-${day}`;

        // Get the date input fields
        const startedDateInput = document.querySelector("input[name='starteddate']");
        const endDateInput = document.querySelector("input[name='enddate']");
        const staffIdInput = document.querySelector("select[name='staff_id']");
        const submitButton = document.querySelector("button[name='submit']");

        // Set the 'starteddate' to the current date
        startedDateInput.value = minDate;

        // Set the minimum date attributes
        startedDateInput.setAttribute("min", minDate);
        endDateInput.setAttribute("min", minDate);

        // Additional validation: Ensure end date is not earlier than start date
        startedDateInput.addEventListener("change", function () {
            endDateInput.setAttribute("min", startedDateInput.value);
        });

        function checkAvailability() {
            const staffId = staffIdInput.value;
            const startDate = startedDateInput.value;
            const endDate = endDateInput.value;

            if (staffId && startDate && endDate) {
                fetch(`check_schedule.php?staff_id=${staffId}&start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.available) {
                            alert('The selected dates are available. You can proceed with the schedule.');
                            submitButton.disabled = false;
                        } else {
                            alert('The selected dates overlap with an existing schedule. Please reenter the scheduling date!');
                            submitButton.disabled = true;
                        }
                    })
                    .catch(error => {
                        alert('An error occurred while checking availability. Please try again later.');
                        console.error('Error:', error);
                    });
            }
        }

        [staffIdInput, startedDateInput, endDateInput].forEach(input => {
            input.addEventListener('change', checkAvailability);
        });
    });
    
    $('#manage_categories').submit(function(e) {
    e.preventDefault();
    $('input').removeClass("border-danger");
    $('#response-message').html(''); // Clear previous message

    const qtyProductInput = document.getElementById("qty_product");
    let qtyProductValue = 0;

    // Use try-catch for validation
    try {
        qtyProductValue = parseInt(qtyProductInput.value, 10);
        if (isNaN(qtyProductValue) || qtyProductValue <= 0) {
            throw new Error("Quantity Product cannot be 0 or less. Please enter a valid quantity.");
        }
    } catch (error) {
        alert(error.message); // Show the error message from the exception
        qtyProductInput.classList.add("border-danger"); // Highlight the invalid input
        qtyProductInput.value = ""; // Reset the value
        return; // Exit the submit handler
    }

    // Initialize validation status
    let isValid = true;

    // Validate equipmentData
    const equipmentDataInput = document.getElementById('equipment_data_input');
    try {
        if (equipmentDataInput) {
            const equipmentData = JSON.parse(equipmentDataInput.value);

            // Check if there is no equipment
            if (!equipmentData || equipmentData.length === 0) {
                throw new Error("No equipment data available. Please choose another product.");
            }

            // Validate each equipment's quantity
            for (let equipment of equipmentData) {
                if (equipment.qty <= 0) {
                    throw new Error(
                        `Equipment with ID ${equipment.id || 'unknown'} has an invalid quantity (0 or less). Please adjust the quantity.`
                    );
                }
            }
        } else {
            throw new Error("Equipment data input is missing. Please ensure the form is filled out correctly.");
        }
    } catch (error) {
        alert(error.message); // Show the error message from the exception
        isValid = false; // Set validation status to false
    }

    // If validation passes, submit the form
    if (isValid) {
        submitForm();
    } else {
        alert("Validation failed. Please correct the errors and try again.");
    }
});

// Function to handle form submission
function submitForm() {
    start_load();

    $.ajax({
        url: 'ajax.php?action=save_categories',
        data: new FormData($('#manage_categories')[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Data successfully saved.', "success");
                setTimeout(function() {
                    location.replace('index.php?page=production');
                }, 1500);
            } else {
                console.log('Error: ', resp);
                $('#response-message').html('Failed to save the category.');
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX Error: ', status, error);
            $('#response-message').html('An error occurred while saving the category.');
        }
    });
}



</script>
