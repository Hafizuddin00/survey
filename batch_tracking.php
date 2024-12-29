<?php
// Include database connection and start session
include 'db_connect.php'; 

// Check if staff_id is set in the session
if (!isset($_SESSION['login_staff_id'])) {
    echo "<tr><td colspan='7' class='text-center text-warning'>No staff ID found in session.</td></tr>";
    exit;
}

$staff_id1 = $_SESSION['login_staff_id'];
?>

<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <a class="btn btn-sm btn-danger btn-flat" href="javascript:void(0)" id="archive-data">
            <i class="fa fa-trash"></i> Delete All Record
            </a>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="list">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Batch ID</th>
                            <th>Started Date</th>
                            <th>Recipe Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qry = $conn->query("SELECT * FROM categories WHERE status != 'Archived' AND staff_id = $staff_id1");
                        if ($qry && $qry->num_rows > 0) {
                            $i = 1;
                            while ($row = $qry->fetch_assoc()):
                                $status = $row['status'];

                                if ($status == 'Finished') {
                                    $btnClass = 'btn-success';
                                    $btnText = 'Finish';
                                    $dropdownDisabled = 'disabled';
                                } elseif ($status == 'In-Progress') {
                                    $btnClass = 'btn-warning';
                                    $btnText = 'In Progress';
                                    $dropdownDisabled = '';
                                } else {
                                    $btnClass = 'btn-danger';
                                    $btnText = 'Update Status';
                                    $dropdownDisabled = '';
                                }
                        ?>
                        <tr>
                            <th class="text-center"><?php echo $i++; ?></th>
                            <td><b><?php echo $row['id']; ?></b></td>
                            <td><b><?php echo $row['starteddate']; ?></b></td>
                            <td><b><?php echo ucwords($row['recipe_name']); ?></b></td>
                            <td class="text-center">
                                <button type="button" class="btn <?php echo $btnClass; ?> btn-sm btn-flat wave-effect dropdown-toggle" 
                                    data-toggle="dropdown" 
                                    aria-expanded="true" 
                                    <?php echo $dropdownDisabled; ?>>
                                    <?php echo $btnText; ?>
                                </button>
                                <?php if (!$dropdownDisabled): ?>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item update-status" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-status="In-Progress">In-Progress</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item update-status" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-status="Finished">Finished</a>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-secondary btn-sm btn-flat wave-effect dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item view_production" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">View Production Details</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item view_details" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">View Recipe</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan='7' class='text-center text-warning'>There are no production schedules for this user.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#list').dataTable();

    // View Production Details Handler
    $(document).on('click', '.view_production', function () {
        var id = $(this).data('id');
        uni_modal("<i class='fa fa-id-card'></i> View Production", "view_production.php?id=" + id);
    });

    // View Recipe Details Handler
    $(document).on('click', '.view_details', function () {
        var id = $(this).data('id');
        uni_modal("<i class='fa fa-id-card'></i> Recipe Details", "view_details.php?id=" + id);
    });

    // Update Status Handler
    $(document).on('click', '.update-status', function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var button = $(this).closest('td').find('button');

        if (!confirm(`Are you sure you want to update the status to "${status}"?`)) {
            return;
        }

        $.ajax({
            url: 'ajax.php?action=update_status',
            method: 'POST',
            data: { id: id, status: status },
            success: function (resp) {
                if (resp != 1) {
                    alert_toast("Status successfully updated", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Failed to update status. Please try again.", 'error');
                }
            },
            error: function () {
                alert_toast("An error occurred. Please try again later.", 'error');
            }
        });
    });

    // Delete All Data Handler
    $(document).on('click', '#archive-data', function () {
        if (!confirm("Are you sure you want to delete all data with status 'Finished'?")) {
            return;
        }

        $.ajax({
            url: 'ajax.php?action=archive_data',
            method: 'POST',
            success: function (resp) {
                if (resp != 1) {
                    alert_toast("All records with 'Finished' status successfully archived", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Failed to archive records. Please try again.", 'error');
                }
            },
            error: function () {
                alert_toast("An error occurred. Please try again later.", 'error');
            }
        });
    });

    // Uni Modal Function
    function uni_modal(title, url) {
        $('#uni_modal .modal-title').html(title);
        $('#uni_modal .modal-body').html("<div class='text-center'><i class='fa fa-spinner fa-spin'></i></div>");
        $('#uni_modal').modal('show');
        $.ajax({
            url: url,
            success: function (resp) {
                $('#uni_modal .modal-body').html(resp);
            },
            error: function () {
                $('#uni_modal .modal-body').html('<p class="text-danger">Failed to load content. Please try again later.</p>');
            }
        });
    }
});
</script>
