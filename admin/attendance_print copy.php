<?php
include 'includes/session.php';

// Retrieve employee ID and month/year from query parameters
$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';

if (!$employee_id || !$month) {
    die("Invalid parameters.");
}

// Define the start and end dates for the month
$start_date = $month . "-01";
$end_date = date("Y-m-t", strtotime($start_date));

// Generate all dates for the month
$dates = [];
$current_date = $start_date;
while ($current_date <= $end_date) {
    $dates[] = $current_date;
    $current_date = date("Y-m-d", strtotime($current_date . ' +1 day'));
}

// Query to get employee name
$employee_sql = "SELECT firstname, lastname FROM employees WHERE id = ?";
$employee_stmt = $conn->prepare($employee_sql);
$employee_stmt->bind_param("i", $employee_id);
$employee_stmt->execute();
$employee_result = $employee_stmt->get_result();
$employee = $employee_result->fetch_assoc();
$employee_name = $employee ? $employee['firstname'] . ' ' . $employee['lastname'] : 'Unknown Employee';

// Query to get all attendance logs for the selected employee and month
$attendance_sql = "SELECT DATE(attendance.date) AS date, attendance.time_in, attendance.time_out 
                    FROM attendance 
                    WHERE attendance.employee_id = ? 
                    AND DATE(attendance.date) BETWEEN ? AND ? 
                    ORDER BY attendance.date ASC, attendance.time_in ASC";
$attendance_stmt = $conn->prepare($attendance_sql);
$attendance_stmt->bind_param("sss", $employee_id, $start_date, $end_date);
$attendance_stmt->execute();
$attendance_result = $attendance_stmt->get_result();

// Prepare attendance data for each date
$attendance_data = [];
while ($row = $attendance_result->fetch_assoc()) {
    $date = $row['date'];
    if (!isset($attendance_data[$date])) {
        $attendance_data[$date] = [];
    }
    $attendance_data[$date][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            margin: 10px;
            background-color: #f4f4f4;
            font-size: 12px; /* Adjust font size */
        }
        h2, h3 {
            text-align: center;
            color: #333;
            margin: 5px; /* Reduce margin */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0; /* Reduce margin */
            background-color: #ffffff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 2px; /* Reduce padding */
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        @media print {
            body {
                margin: 0;
                background-color: #ffffff;
            }
            button {
                display: none;
            }
            h2, h3 {
                margin: 0; /* No margin for print */
            }
        }
    </style>
</head>
<body>
    <h2>DAILY TIME RECORD</h2>
    <h3><?php echo htmlspecialchars($employee_name); ?></h3>
    <hr style="width: 50%; margin: 0 auto;">
    <p style="text-align: center; margin: 5px 0;">(Name)</p>

    <p>For the month of <span style="display: inline-block; border-bottom: 1px solid #000;"><?php echo date('F Y', strtotime($start_date)); ?></span></p>
    <p>Official hours arrival and departure <span style="display: inline-block; border-bottom: 1px solid #000;"> 7:45-12:00 ; 12:45-4:45</span></p>
    <p>Regular Days <span style="display: inline-block; border-bottom: 1px solid #000;"> Monday-Friday</span></p>
    <p>Saturdays <span style="display: inline-block; border-bottom: 1px solid #000;"> As Required</span></p>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Date</th>
                <th colspan="2">AM</th>
                <th colspan="2">PM</th>
                <th colspan="2">Undertime</th>
            </tr>
            <tr>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Hours</th>
                <th>Minutes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dates as $date): ?>
                <?php
                    // Initialize time-in and time-out variables for AM and PM
                    $time_in_am = '';
                    $time_out_am = '';
                    $time_in_pm = '';
                    $time_out_pm = '';
                    $undertime_hours = '';
                    $undertime_minutes = '';

                    if (isset($attendance_data[$date])) {
                        // Get the first two logs for AM and the next two for PM
                        $logs = $attendance_data[$date];
                        if (isset($logs[0])) {
                            $time_in_am = date('h:i A', strtotime($logs[0]['time_in']));
                            $time_out_am = date('h:i A', strtotime($logs[0]['time_out']));
                        }
                        if (isset($logs[1])) {
                            $time_in_pm = date('h:i A', strtotime($logs[1]['time_in']));
                            $time_out_pm = date('h:i A', strtotime($logs[1]['time_out']));
                        }

                        // Calculate undertime (if any)
                        $official_time_in_am = strtotime("$date 07:45:00");
                        $official_time_out_pm = strtotime("$date 16:45:00");

                        $actual_time_in_am = isset($logs[0]) ? strtotime($logs[0]['time_in']) : null;
                        $actual_time_out_pm = isset($logs[1]) ? strtotime($logs[1]['time_out']) : null;

                        if ($actual_time_out_pm && $actual_time_out_pm < $official_time_out_pm) {
                            $undertime = $official_time_out_pm - $actual_time_out_pm;
                            $undertime_hours = floor($undertime / 3600);
                            $undertime_minutes = floor(($undertime % 3600) / 60);
                        }
                    }
                ?>
                <tr>
                    <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                    <td><?php echo $time_in_am ?: ''; ?></td>
                    <td><?php echo $time_out_am ?: ''; ?></td>
                    <td><?php echo $time_in_pm ?: ''; ?></td>
                    <td><?php echo $time_out_pm ?: ''; ?></td>
                    <td><?php echo $undertime_hours; ?></td>
                    <td><?php echo $undertime_minutes; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p style="text-align: center;">I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.</p>
    <h3><?php echo htmlspecialchars($employee_name); ?></h3>
    <hr style="width: 50%; margin: 0 auto; border: 1px solid black;">
    <p style="text-align: center;">VERIFIED as to the prescribed office hours:</p>
    <h3><?php echo htmlspecialchars($employee_name); ?></h3>
    <hr style="width: 50%; margin: 0 auto; border: 1px solid black;">
    <p style="text-align: center;">In charge</p>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
