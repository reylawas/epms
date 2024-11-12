<?php
include 'includes/session.php';

// Automatically determine the current school year
$current_year = date('Y');
$next_year = date('Y', strtotime('+1 year'));
$school_year = "$current_year-$next_year";

// Retrieve the necessary data from the GET request or set default values
$date = isset($_GET['date']) ? $_GET['date'] : date('F d, Y');
$designation = isset($_GET['designation']) ? $_GET['designation'] : '____________________________________';
$purpose = isset($_GET['purpose']) ? $_GET['purpose'] : '________________________________________________';
$destination = isset($_GET['destination']) ? $_GET['destination'] : '___________________________________________';
$time_of_departure = isset($_GET['time_of_departure']) ? $_GET['time_of_departure'] : '__________________';
$time_of_arrival = isset($_GET['time_of_arrival']) ? $_GET['time_of_arrival'] : '__________________';
$exact_time_of_departure = isset($_GET['exact_time_of_departure']) ? $_GET['exact_time_of_departure'] : '__________________';
$exact_time_of_arrival = isset($_GET['exact_time_of_arrival']) ? $_GET['exact_time_of_arrival'] : '__________________';

// Get Administrative Officer II and Approver names
$positions = ['School Head', 'Administrative Officer II'];
$employees = [];

foreach ($positions as $position) {
    $sql = "SELECT CONCAT(firstname, ' ', lastname) AS name FROM employees WHERE position = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $position);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $employees[$position] = $employee ? $employee['name'] : 'Not Assigned';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pass Slip</title>
    <style>
        @page {
            size: 8.5in 11in; /* Bond paper size */
            margin: 0.5in; /* Margins */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.4;
            text-align: center;
            font-size: 12px; /* Adjust font size */
        }
        .header {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        .content {
            text-align: left;
            font-size: 12px;
            margin: 0 auto;
            width: 100%;
            max-width: 800px; /* Adjust to fit the page */
        }
        .content p {
            margin: 5px 0;
        }
        .approval {
            text-align: left;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .sign {
            display: inline-block;
            width: 45%;
            text-align: left;
        }
        .certification {
            text-align: center;
            margin-top: 20px;
        }
        .certification-line {
            border-top: 1px solid black;
            margin: 20px 0;
        }
        .bold-line {
            border: 1px solid black; /* Thicker line */
            margin: 10px 0; /* Margin around the line */
        }
        @media print {
            button {
                display: none;
            }
        }
        .signature-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            font-family: Arial, sans-serif; /* Optional: to control font style */
        }
        .signature-item {
            text-align: center;
            position: relative;
            flex: 1;
            margin: 0;
        }
        .signature-item::before {
            content: '';
            display: block;
            border-top: 1px solid black;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .signature-item.left::before {
            width: 60%; /* Adjust width as needed */
            top: 0;
        }
        .signature-item.center::before {
            width: 80%; /* Adjust width as needed */
            top: 0;
        }
        .signature-item.right::before {
            width: 70%; /* Adjust width as needed */
            top: 0;
        }
        .signature-item p {
            position: relative;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="header">
    <p style="margin: 0;">Republic of the Philippines</p>
    <p style="margin: 0;">Department of Education</p>
    <p style="margin: 0;">Region VII</p>
    <h3 style="margin: 5px 0;">SCHOOLS DIVISION OF CITY OF NAGA</h3>
    <h3 style="margin: 5px 0;">TUYAN NATIONAL HIGH SCHOOL SENIOR HIGH DEPARTMENT</h3>
    <p style="margin: 0;">TABTUY, TUYAN, CITY OF NAGA, CEBU</p>
    <p style="margin: 0;">School Year <?php echo $school_year; ?></p>
    <hr class="bold-line" style="margin: 5px 0;"> <!-- Bold line above PASS SLIP -->
</div>

<div class="title">
    PASS SLIP
</div>

<div class="content">
    <p>Date: <?php echo $date; ?></p>
    <p>Name of Employee: <?php echo $user['firstname'].' '.$user['lastname']; ?></p>
    <p>Designation: <?php echo $designation; ?></p>

    <p>Requesting permission to leave the Office during office hours</p>
    <p>On: ( ) Official Business &nbsp; ( ) Official Time &nbsp; ( ) Personal</p>
    <p>Purpose: <?php echo $purpose; ?></p>
    <p>Destination: <?php echo $destination; ?></p>
    <p>Time of Departure: <?php echo $time_of_departure; ?></p>
    <p>Time of Arrival: <?php echo $time_of_arrival; ?></p>
</div>

<div class="approval">
    <p style="text-align: center; margin-top: 0;">Approved by:</p>
    <p style="text-align: center; margin-top: 0;">
        <strong><?php echo $employees['School Head']; ?></strong><br>School Head
    </p>
</div>


<div class="content">

    <p>Exact time of Departure: <?php echo $exact_time_of_departure; ?></p>
    <p>Signed by:</p>
    <p class="sign"><strong><?php echo $employees['Administrative Officer II']; ?></strong><br>Administrative Officer II</p>
    <br></br>
    <div style="text-align: center; margin-top: 0;">
    <hr style="border: none; border-top: 1px solid black; margin: 0 auto; width: 80px;"/>
    <p style="margin-top: 0;">Guard on Duty</p>
</div>
    <p>Exact time of Arrival: <?php echo $exact_time_of_arrival; ?></p>
    <p>Signed by:</p>
    <p class="sign"><strong><?php echo $employees['Administrative Officer II']; ?></strong><br>Administrative Officer II</p>
    <br></br>
    <div style="text-align: center; margin-top: 0;">
    <hr style="border: none; border-top: 1px solid black; margin: 0 auto; width: 80px;"/>
    <p style="margin-top: 0;">Guard on Duty</p>
</div>


</div>

<div class="certification">
    <div class="certification-line"></div> <!-- Line above certification -->
    <p><strong>CERTIFICATION</strong></p>
    <p>This is to certify that the above employee appeared in this Office for the above purpose.</p>
    <br><br>
    <div class="signature-container">
        <div class="signature-item left">
            <p>Signature over printed</p>
        </div>
        <div class="signature-item center">
            <p>Position</p>
        </div>
        <div class="signature-item right">
            <p>Date</p>
        </div>
    </div>
    <br></br>
    <hr class="bold-line" style="margin: 5px 0;">

<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>
