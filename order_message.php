<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Order ID</th>
						<th>Recipe Name</th>
						<th>Customer Name</th>
						<th>Quantity</th>
                        <th>Order Date</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM order_customer");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $row['order_id'] ?></b></td>
						<td><b><?php echo $row['recipe_name'] ?></b></td>
						<td><b><?php echo $row['customer_name'] ?></b></td>
						<td><b><?php echo $row['quantity']?></b></td>
                        <td><b><?php echo $row['order_date']?></b></td>
						<td><b><?php echo $row['status']?></b></td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	})
</script>