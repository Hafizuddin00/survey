<?php
include 'includes/dbconnection.php';
include 'db_connect.php';

// Fetch data based on the ID
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM categories WHERE id = ".$_GET['id'])->fetch_array();
    foreach($qry as $k => $v){
        $$k = $v;
    }
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <!-- Display category details and form for editing -->
        

            <form id="editForm">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">

                <div class="form-group">
                    <label for="enddate">End Date *</label>
                    <input type="date" name="enddate" id="enddate" class="form-control form-control-sm" value="<?php echo isset($enddate) ? $enddate : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="hours">Estimated Day *</label>
                    <input type="number" name="hours" id="hours" class="form-control form-control-sm" value="<?php echo isset($hours) ? $hours : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <input type="text" name="status" id="status" class="form-control form-control-sm" value="<?php echo isset($status) ? $status : ''; ?>" required>
                </div>

                <div class="form-group text-right">
                    <button type="button" id="editBtn" class="btn btn-success">Edit</button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='index.php?page=categories'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#editBtn').click(function (e) {
    e.preventDefault(); // Prevent the form from submitting

    // Display a confirmation popup before submitting
    let confirmEdit = confirm("You can only edit End Date, Estimated Day, and Status.");
    
    if (confirmEdit) {
        const categoryData = {
            id: $('input[name="id"]').val(),
            enddate: $('#enddate').val(),
            hours: $('#hours').val(),
            status: $('#status').val(),
        };

        // Send data via AJAX
        $.ajax({
            url: 'ajax.php?action=update_category', // URL following the style from previous code
            data: categoryData,  // Send data as form data
            method: 'POST',
            success: function (resp) {
                if (resp === 'success') {
                    alert('Category updated successfully.');
                    location.href = 'index.php?page=production';// Redirect to production page after success
                } else {
                    alert('Failed to update category.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error occurred. Please try again.');
            }
        });
    }
});
</script>
