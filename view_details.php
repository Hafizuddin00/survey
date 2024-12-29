<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("
        SELECT c.*, r.recipe_id, r.recipe_ing, r.recipe_step 
        FROM categories c
        LEFT JOIN receipe r ON c.recipe_name = r.recipe_name
        WHERE c.id = " . $_GET['id']
    )->fetch_array();

    foreach ($qry as $k => $v) {
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <table class="table">
        <tr>
            <th>Recipe ID:</th>
            <td><b><?php echo ucwords($recipe_id) ?></b></td>
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
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
    #uni_modal .modal-footer {
        display: none;
    }
    #uni_modal .modal-footer.display {
        display: flex;
    }
</style>
