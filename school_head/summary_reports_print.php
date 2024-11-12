<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report of Service and Summary of Absences, Tardiness and Undertime</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .header {
            margin-bottom: 5px;
        }
        .header p {
            margin: 2px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .table-container {
            overflow-x: auto;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .footer div {
            text-align: center;
        }
        .footer div span {
            display: block;
            margin-top: 40px;
            border-top: 1px solid black;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .footer p, .footer span {
            font-size: 10px;
        }
        @media print {
            @page {
                size: A4 landscape;
                margin: 10mm;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .header {
                margin-bottom: 5px;
            }
            table {
                page-break-inside: auto;
                width: 100%;
            }
            th, td {
                font-size: 10px;
                padding: 3px;
            }
        }
    </style>
</head>
<body>
<?php
    // Include session file for database connection
    include 'includes/session.php';

    // Get the selected month and year from the GET parameters
    $monthYear = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
    list($year, $month) = explode('-', $monthYear);

    // Fetch employee data sorted by name
    $sql = "SELECT id, employee_id, lastname, middlename, firstname FROM employees ORDER BY lastname ASC, firstname ASC";
    $query = $conn->query($sql);
    // Function to calculate undertime in minutes
function calculateUndertime($time_in, $time_out) {
    // Official work hours: 7:45 AM - 12:00 PM and 12:45 PM - 4:45 PM
    $official_start_am = strtotime('07:45:00');
    $official_end_am = strtotime('12:00:00');
    $official_start_pm = strtotime('12:45:00');
    $official_end_pm = strtotime('16:45:00');

    // Convert time_in and time_out to timestamps
    $time_in_timestamp = strtotime($time_in);
    $time_out_timestamp = strtotime($time_out);

    $undertime_minutes = 0;

    // Calculate undertime for AM shift
    if ($time_in_timestamp > $official_start_am && $time_in_timestamp < $official_end_am) {
        // Late arrival for AM shift
        $undertime_minutes += ($time_in_timestamp - $official_start_am) / 60;
    }

    if ($time_out_timestamp < $official_end_am && $time_out_timestamp > $official_start_am) {
        // Early departure for AM shift
        $undertime_minutes += ($official_end_am - $time_out_timestamp) / 60;
    }

    // Calculate undertime for PM shift
    if ($time_in_timestamp > $official_start_pm && $time_in_timestamp < $official_end_pm) {
        // Late arrival for PM shift
        $undertime_minutes += ($time_in_timestamp - $official_start_pm) / 60;
    }

    if ($time_out_timestamp < $official_end_pm && $time_out_timestamp > $official_start_pm) {
        // Early departure for PM shift
        $undertime_minutes += ($official_end_pm - $time_out_timestamp) / 60;
    }

    return $undertime_minutes;
}
$positions = ['School Head', 'Administrative Officer II'];
$employees = [];

foreach ($positions as $position) {
    $sql = "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname) AS name FROM employees WHERE position = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $position);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $employees[$position] = $employee ? $employee['name'] : 'Not Assigned';
}
?>

     <div class="header">
        <p>DEPARTMENT OF EDUCATION</p>
        <p>REGION VII, CENTRAL VISAYAS</p>
        <p>DIVISION OF CITY OF SCHOOLS</p>
        <p>CITY OF NAGA CEBU</p>
        <p><strong>TUYAN NATIONAL HIGH SCHOOL</strong></p>
        <p><strong>SENIOR HIGH DEPARTMENT</strong></p>
        <p>TUYAN, CITY OF NAGA, CEBU</p>
        <p style="margin: 10px 0;"></p>
        <p><strong>REPORT OF SERVICE AND SUMMARY OF ABSENCES, TARDINESS AND UNDERTIME</strong></p>
        <p><strong>MONTH OF <?php echo strtoupper(date('F Y', strtotime($monthYear))); ?></strong></p>
        <p>REGIONAL PAID</p>
        <p style="margin: 10px 0;"></p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th rowspan="2">NO.</th>
                    <th rowspan="2">EMPLOYEE ID NO.</th> 
                    <th colspan="3">NAME OF EMPLOYEE</th>
                    <th colspan="1"></th>
                    <th colspan="5">WITH PAY</th>
                    <th rowspan="2">DIVISION ACTION</th>
                    <th colspan="5">WITHOUT PAY</th>
                    <th rowspan="2">DIVISION ACTION</th>
                    <th rowspan="2">NO. OF TIMES TARDY</th>
                    <th rowspan="2">NO. OF TIMES UNDERTIME</th>
                    <th rowspan="2">REMARKS</th>
                </tr>
                <tr>
                    <th>LAST</th>
                    <th>FIRST</th>
                    <th>M.I</th>
                    <th>EXT</th>
                    <th>EXCLUSIVE DATES</th>
                    <th>DAY</th>
                    <th>HOUR</th>
                    <th>MINUTES</th>
                    <th>CAUSE OF LEAVE</th>
                    <th>EXCLUSIVE DATES</th>
                    <th>DAY</th>
                    <th>HOUR</th>
                    <th>MINUTES</th>
                    <th>CAUSE OF LEAVE</th>
                </tr>
            </thead>
            <tbody>
            <?php
        // Initialize counter
        $counter = 1;

        // Loop through each employee and display the row
        while ($row = $query->fetch_assoc()) {
            $employee_id = $row['id'];
            // Fetch attendance data for the employee in the selected month and year
            $attendance_sql = "SELECT time_in, time_out FROM attendance WHERE employee_id = '$employee_id' AND 
                               (MONTH(time_in) = '$month' AND YEAR(time_in) = '$year')";
            $attendance_query = $conn->query($attendance_sql);

            $total_undertime_minutes = 0; // Total undertime in minutes

            // Loop through attendance records and calculate total undertime
            while ($attendance_row = $attendance_query->fetch_assoc()) {
                $time_in = $attendance_row['time_in'];
                $time_out = $attendance_row['time_out'];

                $total_undertime_minutes += calculateUndertime($time_in, $time_out); // Add up undertime
            }
            // Fetch approved leaves for the employee in the selected month and year
            $leave_sql = "SELECT date_from, date_to, leave_type FROM leaves WHERE employee_id = '$employee_id' AND status = 'Approved' AND 
                          (MONTH(date_from) = '$month' AND YEAR(date_from) = '$year')";
            $leave_query = $conn->query($leave_sql);

            $exclusive_dates_with_pay = [];
            $exclusive_dates_without_pay = [];
            $total_days_with_pay = null;  // Initialize as null
            $total_days_without_pay = null;  // Initialize as null
            $cause_of_leave_with_pay = '';
            $cause_of_leave_without_pay = '';
            $leave_type_with_pay = '';
            $leave_type_without_pay = '';
            // Check if there are any leaves for this employee
            if ($leave_query->num_rows > 0) {
                while ($leave_row = $leave_query->fetch_assoc()) {
                    $date_from = strtotime($leave_row['date_from']);
                    $date_to = strtotime($leave_row['date_to']);
                    $leave_type = $leave_row['leave_type']; // Assuming 'cause_of_leave' field exists

                    // Calculate the number of leave days
                    $num_days = ($date_to - $date_from) / (60 * 60 * 24) + 1;

                    // Format date as a single day or range
                    $date_range = (date('d', $date_from) == date('d', $date_to)) ? date('d', $date_from) : date('d', $date_from) . '-' . date('d', $date_to);

                    // Add to the appropriate array and total days based on leave type
                    if ($leave_row['leave_type'] == 'Sick Leave') {
                        $exclusive_dates_with_pay[] = $date_range;
                        $total_days_with_pay += $num_days;
                        if ($cause_of_leave_with_pay == '') {
                            $cause_of_leave_with_pay = $leave_type;
                        }
                        $leave_type_with_pay = 'WITH PAY';
                    } elseif ($leave_row['leave_type'] == 'Personal Leave') {
                        $exclusive_dates_without_pay[] = $date_range;
                        $total_days_without_pay += $num_days;
                        if ($cause_of_leave_without_pay == '') {
                            $cause_of_leave_without_pay = $leave_type;
                        }
                        $leave_type_without_pay = 'WITHOUT PAY';
                    }
                }
            }

            // Join dates with commas for each leave type
            $exclusive_dates_with_pay_str = implode(', ', $exclusive_dates_with_pay);
            $exclusive_dates_without_pay_str = implode(', ', $exclusive_dates_without_pay);
            $undertime_hours = floor($total_undertime_minutes / 60);
            $undertime_minutes = $total_undertime_minutes % 60;

            echo "<tr>";
            echo "<td>".$counter++."</td>";
            echo "<td>".$row['employee_id']."</td>";
            echo "<td>".$row['lastname']."</td>";
            echo "<td>".$row['firstname']."</td>";
            echo "<td>".$row['middlename']."</td>";
            echo "<td></td>"; 
            echo "<td>$exclusive_dates_with_pay_str</td>"; // Display Sick Leave dates in WITH PAY
            echo "<td>" . ($total_days_with_pay !== null ? $total_days_with_pay : '') . "</td>"; // Show only if not null
            //echo "<td>$total_days_with_pay</td>"; // Total days for WITH PAY
            echo "<td></td>"; // Placeholder for HOUR column under WITH PAY
            echo "<td></td>"; // Placeholder for MINUTES column under WITH PAY
            echo "<td>$cause_of_leave_with_pay</td>"; 
            echo "<td>$leave_type_with_pay</td>";
            echo "<td>$exclusive_dates_without_pay_str</td>"; // Display Personal Leave dates in WITHOUT PAY
            echo "<td>" . ($total_days_without_pay !== null ? $total_days_without_pay : '') . "</td>"; // Show only if not null
            //echo "<td>$total_days_without_pay</td>"; // Total days for WITHOUT PAY
            echo "<td></td>"; // Placeholder for HOUR column under WITHOUT PAY
            echo "<td></td>"; // Placeholder for HOUR column under WITHOUT PAY
            echo "<td>$cause_of_leave_without_pay</td>";
            echo "<td>$leave_type_without_pay</td>";
            echo "<td></td>"; // Placeholder for NO. OF TIMES TARDY column
            echo "<td></td>"; // Placeholder for NO. OF TIMES UNDERTIME column
            echo "<td>$undertime_hours hrs $undertime_minutes mins late</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
        <div class="footer">
                        <div>
                <p>Prepared by:</p>
                <?php echo $employees['Administrative Officer II']; ?><br>
                <hr style="border: none; border-top: 1px solid black; margin: 0; width: 100%;"> <!-- Horizontal line -->
                <p>ADOF II</p>
            </div>
            <div>
                <p>Certified true and correct:</p>
                <?php echo $employees['School Head']; ?><br>
                <span style="border: none; border-top: 1px solid black; margin: 0; width: 100%;"> <!-- Horizontal line -->
                <p>School Head</p>
            </div>
        </div>
    </div>
</body>
</html>
