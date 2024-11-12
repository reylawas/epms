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
$employee_sql = "SELECT firstname, middlename, lastname FROM employees WHERE id = ?";
$employee_stmt = $conn->prepare($employee_sql);
$employee_stmt->bind_param("i", $employee_id);
$employee_stmt->execute();
$employee_result = $employee_stmt->get_result();
$employee = $employee_result->fetch_assoc();
$employee_name = $employee ? $employee['firstname'] . ' ' . $employee['middlename'] . ' ' . $employee['lastname'] : 'Unknown Employee';

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

// Function to calculate undertime in minutes
function calculateUndertime($time_in, $time_out, $official_in, $official_out) {
    $undertime = 0;

    if ($time_in && strtotime($time_in) > strtotime($official_in)) {
        $undertime += (strtotime($time_in) - strtotime($official_in)) / 60;
    }
    if ($time_out && strtotime($time_out) < strtotime($official_out)) {
        $undertime += (strtotime($official_out) - strtotime($time_out)) / 60;
    }

    return $undertime;
}

// Function to convert undertime from minutes to whole hours and reset minutes if 60 or more
function convertUndertimeToWholeHours($undertime_minutes) {
    $undertime_hours = floor($undertime_minutes / 60);
    $remaining_minutes = $undertime_minutes % 60;
    return [$undertime_hours, $remaining_minutes];
}

// Initialize total undertime
$total_undertime_minutes = 0;
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
            font-size: 12px;
        }
        h2, h3 {
            text-align: center;
            color: #333;
            margin: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            background-color: #ffffff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 2px;
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
                margin: 0;
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
            <th rowspan="2">Day</th>
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
$time_in_am = '';
$time_out_am = '';
$time_in_pm = '';
$time_out_pm = '';
$undertime_am = 0;
$undertime_pm = 0;
$day_of_week = date('l', strtotime($date)); 

// If it's Saturday, set "No class"
if ($day_of_week == 'Saturday') {
    $time_in_am = "Saturday";
    $time_out_am = "Saturday";
    $time_in_pm = "Saturday";
    $time_out_pm = "Saturday";
}

// If it's Sunday, set "No class"
if ($day_of_week == 'Sunday') {
    $time_in_am = "Sunday";
    $time_out_am = "Sunday";
    $time_in_pm = "Sunday";
    $time_out_pm = "Sunday";
}

// Process attendance data if it's a weekday (Monday to Friday)
if (isset($attendance_data[$date])) {
    $logs = $attendance_data[$date];
    if (isset($logs[0])) {
        $time_in_am = date('h:i A', strtotime($logs[0]['time_in']));
        // Check if time_out is 00:00:00 (or empty) and exclude it from undertime calculation
        $time_out_am = ($logs[0]['time_out'] == '00:00:00' || empty($logs[0]['time_out'])) ? null : date('h:i A', strtotime($logs[0]['time_out']));
        
        // Calculate undertime for AM, using time_in for undertime calculation if time_out is not available
        $undertime_am = calculateUndertime($logs[0]['time_in'], $time_out_am, '07:45 AM', '12:00 PM');
    }
    if (isset($logs[1])) {
        $time_in_pm = date('h:i A', strtotime($logs[1]['time_in']));
        // Check if time_out is 00:00:00 (or empty) and exclude it from undertime calculation
        $time_out_pm = ($logs[1]['time_out'] == '00:00:00' || empty($logs[1]['time_out'])) ? null : date('h:i A', strtotime($logs[1]['time_out']));
        
        // Calculate undertime for PM, using time_in for undertime calculation if time_out is not available
        $undertime_pm = calculateUndertime($logs[1]['time_in'], $time_out_pm, '12:45 PM', '04:45 PM');
    }
}

// Convert undertime to whole hours and minutes
list($day_undertime_hours, $day_undertime_minutes) = convertUndertimeToWholeHours($undertime_am + $undertime_pm);

// Add daily undertime to the total
$total_undertime_minutes += $undertime_am + $undertime_pm;
?>

            <tr>
                <td><?php echo date('j', strtotime($date)); ?></td>
                <td><?php echo $time_in_am ?: '-'; ?></td>
                <td><?php echo $time_out_am ?: '-'; ?></td>
                <td><?php echo $time_in_pm ?: '-'; ?></td>
                <td><?php echo $time_out_pm ?: '-'; ?></td>
                <td><?php echo $day_undertime_hours ?: '-'; ?></td>
                <td><?php echo $day_undertime_minutes ?: '-'; ?></td>
            </tr>
        <?php endforeach; ?>

        <?php
            // Convert total undertime from minutes to hours and minutes
            list($total_undertime_hours, $total_undertime_remaining_minutes) = convertUndertimeToWholeHours($total_undertime_minutes);
        ?>

        <!-- Display total undertime as a row within the table -->
        <tr style="font-weight: bold;">
    <td colspan="5" style="text-align: right;">Total</td>
    <td><?php echo $total_undertime_hours; ?></td>
    <td><?php echo $total_undertime_remaining_minutes; ?></td>
</tr>
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
