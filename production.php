<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
        <a class="btn btn btn-sm btn-danger btn-flat" href="./index.php?page=present_timetable"><i class="fa fa-timetable"></i> Timetable</a>
		<a class="btn btn btn-sm btn-primary btn-flat" href="./index.php?page=schedule_production"><i class="fa fa-plus"></i> Schedule Production</a>
        <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" id="delete_all_data">
        <i class="fa fa-trash"></i> Delete All Record
    </a>
			<div class="card-tools">
			</div>
		</div>
		<div class="card-body p-3"> <!-- Add padding for spacing -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="list">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Batch ID</th>
                            <th>Production Type</th>
                            <th>Qty Product</th>
                            <th>Staff ID (PIC)</th>
                            <th>Started Date</th>
                            <th>End Date</th>
                            <th>Duration (Day)</th>
                            <th>Status</th>
                            <th>Action</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * FROM categories");
                        while($row= $qry->fetch_assoc()):
                        ?>
                        <tr>
                            <th class="text-center"><?php echo $i++ ?></th>
                            <td><b><?php echo $row['id'] ?></b></td>
                            <td><b><?php echo ucwords($row['recipe_name']) ?></b></td>
                            <td><b><?php echo $row['qty_product'] ?></b></td>
                            <td><b><?php echo $row['staff_id'] ?></b></td>
                            <td><b><?php echo $row['starteddate'] ?></b></td>
                            <td><b><?php echo $row['enddate'] ?></b></td>
                            <td><b><?php echo $row['hours'] ?></b></td>
                            <td>
                            <b class="<?php echo ($row['status'] == 'Finished') ? 'text-success' : (($row['status'] == 'Archived') ? 'text-blue' : (($row['status'] == 'In-Progress') ? 'text-warning' : '')); ?>">
                                <?php echo $row['status'] ?>
                            </b>

                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm btn-flat wave-effect dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item view_production" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="./index.php?page=edit_production&id=<?php echo $row['id'] ?>">Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_categories" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                                </div>
                            </td>
                        </tr>    
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable();
	
    $(document).on('click', '.view_production', function() {
            var id = $(this).attr('data-id'); // Get the ID from the button
            uni_modal("<i class='fa fa-id-card'></i> Production Details", "view_production.php?id=" +$(this).attr('data-id'));
        });
	$(document).on('click','.delete_categories',function() {
	_conf("Are you sure to delete this production?","delete_categories",[$(this).attr('data-id')])
	});
	});

	function delete_categories($id){
		$.ajax({
			url:'ajax.php?action=delete_categories',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp!=1){
					alert_toast("Categories successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
					$('.modal').modal('hide'); // Adjust based on your modal library
            } else {
                alert_toast("Failed to delete category. Please try again.", 'error');
            }
			}
		})
	}
        $(document).on('click', '#delete_all_data', function () {
            _conf("Are you sure you want to delete all records with 'Finished' status permanently?", delete_all_data);
        

        function _conf(message, callback) {
            if (confirm(message)) {
                callback();
            }
        }

        function delete_all_data() {
            $.ajax({
                url: 'ajax.php?action=delete_all_data',
                method: 'POST',
                
                success: function (resp) {
                    if (resp != 1) {
                        alert_toast("All records with 'Finished' status successfully deleted", 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast("Failed to delete records. Please try again.", 'error');
                    }
                },
                error: function () {
                    alert_toast("An error occurred. Please try again later.", 'error');
                }
            });
        }
        });
    function uni_modal(title, url) {
        // Display the modal with the specified title and content loaded via AJAX
        $('#uni_modal .modal-title').html(title);
        $('#uni_modal .modal-body').html("<div class='text-center'><i class='fa fa-spinner fa-spin'></i></div>");
        $('#uni_modal').modal('show');
        $.ajax({
            url: url,
            success: function(resp) {
                $('#uni_modal .modal-body').html(resp);
            },
            error: function() {
                $('#uni_modal .modal-body').html('<p class="text-danger">Failed to load content. Please try again later.</p>');
            }
        });
    }
    
</script>

<style>
    .text-danger {
        color: red; /* Red for Finished */
    }
    .text-warning {
        color: orange; /* Orange for Archived */
    }
    .text-blue{
        color:blue
    }
</style>
