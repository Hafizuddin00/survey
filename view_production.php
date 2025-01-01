<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("
        SELECT c.*, r.recipe_id 
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
			<th>Recipe Name:</th>
			<td><b><?php echo ucwords($recipe_name) ?></b></td>
		</tr>
		<tr>
			<th>Quantity Product:</th>
			<td><b><?php echo $qty_product ?></b></td>
		</tr>
		<tr>
			<th>Staff Id:</th>
			<td><b><?php echo $staff_id ?></b></td>
		</tr>
		<tr>
			<th>Created At:</th>
			<td><b><?php echo $created_at ?></b></td>
		</tr>
		<tr>
			<th>Started Date:</th>
			<td><b><?php echo $starteddate ?></b></td>
		</tr>
		<tr>
			<th>Started Time:</th>
			<td><b><?php echo $estimationduration ?></b></td>
		</tr>
		<tr>
			<th>Duration (Day):</th>
			<td><b><?php echo $hours ?></b></td>
		</tr>
		<tr>
			<th>Product ID:</th>
			<td><b><?php echo $product_id ?></b></td>
		</tr></td>
		<tr>
			<th>Recipe ID:</th>
			<td><b><?php echo $recipe_id ?></b></td>
		</tr>
		<tr>
			<th>Quality (Status):</th>
			<td><b><?php echo $quality_test ?></b></td>
		</tr>
		<tr>
			<th>Commment:</th>
			<td><b><?php echo $comment ?></b></td>
		</tr>
		<tr>
			<th>Status:</th>
			<td><b><?php echo $status ?></b></td>
		</tr>
	</table>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>