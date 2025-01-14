<?php include 'db_connect.php'; ?>

<div class="container my-4">
    <div class="card card-outline card-success">
        <div class="card-header d-flex justify-content-between align-items-center">
            <b><?php echo date('Y-m-d'); ?> <span id="current_time"><?php echo date('H:i:s'); ?></span></b>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form method="POST" action="" id="filter_form">
                <div class="form-row mb-3">
                    <div class="col-md-4">
                        <label for="filter_date">Select Date:</label>
                        <input type="date" id="filter_date" name="filter_date" class="form-control" value="<?php echo isset($_POST['filter_date']) ? $_POST['filter_date'] : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="staff_id">Select Staff ID:</label>
                        <select id="staff_id" name="staff_id" class="form-control">
                            <option value="">--Select--</option>
                            <?php
                            $staff_query = $conn->query("SELECT staff_id FROM users WHERE staff_id NOT IN (0,100005)");
                            while ($staff_row = $staff_query->fetch_assoc()) {
                                echo "<option value='{$staff_row['staff_id']}' " . (isset($_POST['staff_id']) && $_POST['staff_id'] == $staff_row['staff_id'] ? 'selected' : '') . ">{$staff_row['staff_id']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success">Filter</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="clear_filter" class="btn btn-secondary">Clear Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th class="text-center" width="10px">Recipe ID</th>
                        <th>Recipe Name</th>
                        <th>Quantity Produced (qty_product)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : '';
                    $staff_id = isset($_POST['staff_id']) ? $_POST['staff_id'] : '';

                    $query = "SELECT r.recipe_id, r.recipe_name, SUM(c.qty_product) AS total_quantity FROM receipe r LEFT JOIN categories c ON r.recipe_name = c.recipe_name WHERE 1";

                    if ($filter_date) {
                        $query .= " AND c.starteddate = ?";
                    }
                    if ($staff_id) {
                        $query .= " AND c.staff_id = ?";
                    }
                    $query .= " GROUP BY r.recipe_id, r.recipe_name";

                    $stmt = $conn->prepare($query);
                    if ($filter_date && $staff_id) {
                        $stmt->bind_param("ss", $filter_date, $staff_id);
                    } elseif ($filter_date) {
                        $stmt->bind_param("s", $filter_date);
                    } elseif ($staff_id) {
                        $stmt->bind_param("s", $staff_id);
                    }
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><b><?php echo $row['recipe_id']; ?></b></td>
                            <td><b><?php echo $row['recipe_name']; ?></b></td>
                            <td class="text-right"><b><?php echo $row['total_quantity']; ?></b></td>
                        </tr>
                    <?php
                        endwhile;
                    } else {
                        echo "Error: " . $conn->error;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#list').dataTable();

        setInterval(() => {
            const now = new Date();
            $('#current_time').text(now.toTimeString().split(' ')[0]);
        }, 1000);

        $('#clear_filter').click(function(){
            $('#filter_date').val('');
            $('#staff_id').val('');
            $('#filter_form').submit();
        });
    });
</script>
