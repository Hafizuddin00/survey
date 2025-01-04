<?php
if(!isset($conn)){
	include 'includes/dbconnection.php' ;
	include 'db_connect.php' ;
}
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_product">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
				<div class="col-md-6 border-right">						
						<b class="text-muted">New Product</b>
						<?php
						?>
                        <div class="form-group">
							<label for="" class="control-label">Insert New Product ID *</label>
							<input type="number" name="product_id" class="form-control form-control-sm" required value="<?php echo isset($product_id) ? $product_id : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Product Name *</label>
							<input type="text" name="product_name" class="form-control form-control-sm" required value="<?php echo isset($product_name) ? $product_name : '' ?>">
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-success mr-2">Create Product</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=manage_recipe'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('#manage_product').submit(function(e){
		e.preventDefault();
		$('input').removeClass("border-danger");
		start_load();
		$('#msg').html('');
		$.ajax({
			url:'ajax.php?action=save_product',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
			success:function(resp){

				if(resp != 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=manage_recipe')
					},1500)
				} else {
                // If there's an error, log it for debugging
                console.log('Error: ', resp);  
                $('#response-message').html('Failed to save the category.');  // Display error message on page
            }
        },
        error: function(xhr, status, error){
            console.log('AJAX Error: ', status, error);  // Log any AJAX errors
            $('#response-message').html('An error occurred while saving the category.');
        }
		})
	})
</script>