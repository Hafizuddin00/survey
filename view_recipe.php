<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    // Modify the query to only access the 'recipe' table
    $qry = $conn->query("
        SELECT * 
        FROM receipe 
        WHERE recipe_id = " . $_GET['id']
    )->fetch_array();

    // Assign the result to variables
    foreach ($qry as $k => $v) {
        $$k = $v;
    }
}
?>

<div class="container-fluid">
    <table class="table">
        <tr>
            <th>No Product ID:</th>
            <td><b><?php echo ucwords($product_id) ?></b></td>
        </tr>
        <tr>
            <th>Recipe ID:</th>
            <td><b><?php echo $recipe_id?></b></td>
        </tr>
        <tr>
            <th>Recipe Name:</th>
            <td><b><?php echo $recipe_name ?></b></td>
        </tr>
        <tr>
            <th>Recipe Ingredient:</th>
            <td><b><?php echo $recipe_ing ?></b></td>
        </tr>
        <tr>
            <th>Step to Bake:</th>
            <td><b><?php echo $recipe_step ?></b></td>
        </tr>
    </table>
</div>

<div class="modal-footer display p-0 m-0">
    <!-- Added JavaScript for redirecting to survey_template after closing -->
	<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeAndRedirect()">Close</button>

<script>
    function closeAndRedirect() {
        // Close the modal
        $('#uni_modal').modal('hide');
        
        // Redirect to the survey_template page after the modal is closed
        setTimeout(function() {
            window.location.href = 'index.php?page=manage_recipe';
        }, 300); // delay to ensure modal closes before redirection
    }
</script>

</div>

<style>
    #uni_modal .modal-footer{
        display: none;
    }
    #uni_modal .modal-footer.display{
        display: flex;
    }
</style>


