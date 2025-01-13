<?php include 'db_connect.php'; ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Staff Timetable</h3>
        </div>
        <div class="card-body p-3"><!-- Add padding for spacing -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="timetable">
                    <thead>
                        <tr>
                            <th class="text-center">Staff ID</th>
                            <th class="text-center">Unavailable Dates</th>
                            <th class="text-center">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qry = $conn->query("SELECT DISTINCT staff_id FROM users WHERE type = 3");

                        if (!$qry) {
                            die("Query failed: " . $conn->error);
                        }

                        while ($row = $qry->fetch_assoc()):
                            $staff_id = $row['staff_id'];
                            $unavailable_dates = [];

                            // Fetch schedules for the staff member
                            $schedule_qry = $conn->query("SELECT starteddate, enddate, id, status FROM categories WHERE staff_id = '$staff_id'");
                            if ($schedule_qry) {
                                while ($sched = $schedule_qry->fetch_assoc()) {
                                    // Only include this date range if the status is not 'Finished'
                                    if ($sched['status'] !== 'Finished') {
                                        $start_date = new DateTime($sched['starteddate']);
                                        $end_date = new DateTime($sched['enddate']);
                                        $interval = new DateInterval('P1D');
                                        $date_range = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

                                        foreach ($date_range as $date) {
                                            $unavailable_dates[] = [
                                                'date' => $date->format('Y-m-d'),
                                                'id' => $sched['id']
                                            ];
                                        }
                                    }
                                }
                            }
                        ?>
                        <tr>
                            <td class="text-center"> <?php echo $staff_id; ?> </td>
                            <td class="text-center">
                                <?php
                                if (empty($unavailable_dates)) {
                                    echo "Available";
                                } else {
                                    foreach ($unavailable_dates as $unavailable) {
                                        if ($unavailable['date'] >= date('Y-m-d')) {
                                            echo $unavailable['date'] . "<br>";
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if (empty($unavailable_dates)) {
                                    echo "-";
                                } else {
                                    foreach ($unavailable_dates as $unavailable) {
                                        if ($unavailable['date'] >= date('Y-m-d')) {
                                            echo $unavailable['id'] . "<br>";
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#timetable').DataTable({
            lengthChange: false
        });
    });
</script>

<style>
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 10px; /* Adds spacing between the Show entries dropdown and the table */
        padding: 5px; /* Adds padding inside the dropdown container */
    }

    .calendar-container {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }

    .month {
        width: 100%;
        padding: 5px;
        border: 1px solid #ddd;
        margin: 5px;
        box-sizing: border-box;
        text-align: center;
    }

    .month-name {
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 5px;
    }

    .days {
        display: flex;
        gap: 3px;
        overflow-x: auto;
    }

    .day {
        padding: 5px;
        font-size: 12px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 3px;
        cursor: pointer;
        min-width: 20px;
    }

    .day.unavailable {
        color: #fff;
    }

    .prev-month, .next-month {
        padding: 2px 5px;
        font-size: 12px;
        cursor: pointer;
    }
</style>
