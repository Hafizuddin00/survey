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
                            <th class="text-center">Availability Calendar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qry = $conn->query("SELECT DISTINCT staff_id FROM users WHERE type = 3");

                        if (!$qry) {
                            die("Query failed: " . $conn->error);
                        }

                        $staff_colors = []; // Array to store unique colors for each ID under each staff
                        while ($row = $qry->fetch_assoc()):
                            $staff_id = $row['staff_id'];
                            $unavailable_dates = [];

                            // Assign unique colors for each id
                            if (!isset($staff_colors[$staff_id])) {
                                $staff_colors[$staff_id] = [];
                            }

                            $schedule_qry = $conn->query("SELECT starteddate, enddate, id, status FROM categories WHERE staff_id = '$staff_id'");
                            if ($schedule_qry) {
                                while ($sched = $schedule_qry->fetch_assoc()) {
                                    // Only include this date range if the status is not 'finished'
                                    if ($sched['status'] !== 'Finished') {
                                        $start_date = new DateTime($sched['starteddate']);
                                        $end_date = new DateTime($sched['enddate']);
                                        $interval = new DateInterval('P1D');
                                        $date_range = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));

                                        // Assign a unique color for each id
                                        $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF)); // Random color for each ID
                                        if (!in_array($color, $staff_colors[$staff_id])) {
                                            $staff_colors[$staff_id][$sched['id']] = $color;
                                        }

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
                                <div class="calendar" data-staff-id="<?php echo $staff_id; ?>" data-unavailable-dates='<?php echo json_encode($unavailable_dates); ?>' data-staff-colors='<?php echo json_encode($staff_colors[$staff_id]); ?>'>
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

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#timetable').DataTable({
            lengthChange : false 
        });


        // Generate dynamic calendars
        $('.calendar').each(function() {
            const unavailableDates = JSON.parse($(this).attr('data-unavailable-dates'));
            const staffColors = JSON.parse($(this).attr('data-staff-colors'));
            const staffId = $(this).attr('data-staff-id');
            const calendar = $('<div class="calendar-container"></div>');
            let currentMonth = 0;

            function renderMonth(monthOffset) {
                calendar.empty();
                const today = new Date();
                const year = today.getFullYear();
                const month = today.getMonth() + monthOffset;

                const currentMonthDate = new Date(year, month, 1);
                const calendarMonth = $('<div class="month"></div>').append(
                    `<div class="month-name">${currentMonthDate.toLocaleString('default', { month: 'long' })} ${currentMonthDate.getFullYear()}</div>`
                );

                const daysContainer = $('<div class="days"></div>');
                const daysInMonth = new Date(currentMonthDate.getFullYear(), currentMonthDate.getMonth() + 1, 0).getDate();

                // Loop through all the days of the month
                for (let d = 1; d <= daysInMonth; d++) {
                    const dateStr = `${currentMonthDate.getFullYear()}-${String(currentMonthDate.getMonth() + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                    const day = $(`<span class="day">${d}</span>`);

                    // Check if the day is unavailable
                    const unavailable = unavailableDates.find(u => u.date === dateStr);
                    if (unavailable) {
                        const color = staffColors[unavailable.id];
                        day.addClass('unavailable').css('background-color', color).attr('title', `Unavailable (ID: ${unavailable.id})`);
                    }

                    daysContainer.append(day);
                }

                calendarMonth.append(daysContainer);
                calendar.append(calendarMonth);

                // Add navigation buttons
                const prevButton = $('<button class="prev-month">&lt;</button>').click(function() {
                    renderMonth(--currentMonth);
                });
                const nextButton = $('<button class="next-month">&gt;</button>').click(function() {
                    renderMonth(++currentMonth);
                });

                calendar.prepend(prevButton);
                calendar.append(nextButton);
            }

            renderMonth(currentMonth);
            $(this).append(calendar);
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
