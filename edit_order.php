<?php
include 'includes/dbconnection.php';
include 'db_connect.php';

// Fetch data based on the order ID
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $qry = $conn->query("SELECT * FROM order_customer WHERE order_id = " . intval($_GET['order_id']));
    if ($qry) {
        $data = $qry->fetch_assoc();
        foreach ($data as $k => $v) {
            $$k = $v;
        }
    } else {
        die("Error fetching order details: " . $conn->error);
    }
} else {
    die("Invalid order ID.");
}
?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <!-- Display category details and form for editing -->

            <form id="editForm">
                <input type="hidden" name="order_id" value="<?php echo isset($order_id) ? $order_id : ''; ?>">

                <div class="form-group">
                <small class="text-danger">Change status to 'Altered' if mis-entering input while scheduling the production.</small>
                <br>
                    <label for="status">Status *</label>
                    <input type="text" name="status" id="status" class="form-control form-control-sm" value="<?php echo isset($status) ? htmlspecialchars($status) : ''; ?>" required>
                </div>

                <div class="form-group text-right">
                    <button type="button" id="editBtn" class="btn btn-success">Edit</button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='index.php?page=order_message'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#editBtn').click(function (e) {
        e.preventDefault(); // Prevent the form from submitting

        // Get the entered status value
        let enteredStatus = $('#status').val().trim();

        // Validate if the status is "Finished" or "finished"
        if (enteredStatus.toLowerCase() === 'finished') {
            alert('The status "Finished" can only be edited automatically.');
            return; // Stop further execution
        }

        // Display a confirmation popup before submitting
        let confirmEdit = confirm("You can only edit the status.");
        if (confirmEdit) {
            // Gather form data
            const formData = {
                order_id: $('input[name="order_id"]').val(),
                status: enteredStatus,
            };

            // Send data via AJAX
            $.ajax({
                url: 'ajax.php?action=update_status_order', // Backend URL
                method: 'POST',
                data: formData,
                success: function (resp) {
                    if (resp.trim() === 'success') {
                        alert('Status updated successfully.');
                        location.href = 'index.php?page=order_message'; // Redirect after success
                    } else {
                        alert('Failed to update status. Please try again.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
});
</script>
