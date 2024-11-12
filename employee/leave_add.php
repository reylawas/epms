<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$date = date('Y-m-d');
		$employee = $_POST['employee'];
		$date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
		$leave_type = $_POST['leave_type'];
		$reason = $_POST['reason'];
		$status = $_POST['status'];
		$sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
		$query = $conn->query($sql);
		if($query->num_rows < 1){
			$_SESSION['error'] = 'Employee not found';
		}
		else{
			$row = $query->fetch_assoc();
			$employee_id = $row['id'];

			// Check the number of leaves taken by the employee in the current year
			$current_year = date('Y');
			$sql = "SELECT COUNT(*) AS leave_count FROM leaves WHERE employee_id = '$employee_id' AND YEAR(date_from) = '$current_year'";
			$query = $conn->query($sql);
			$leave_data = $query->fetch_assoc();
			$leave_count = $leave_data['leave_count'];

			if($leave_count >= 20){
				$_SESSION['error'] = 'Leave limit reached for the year';
			}
			else{
				$sql = "INSERT INTO leaves (employee_id, date, date_from, date_to, leave_type, reason, status) VALUES ('$employee_id', '$date', '$date_from', '$date_to', '$leave_type', '$reason', '$status')";
				if($conn->query($sql)){
					$_SESSION['success'] = 'Leave Request sent successfully';
				}
				else{
					$_SESSION['error'] = $conn->error;
				}
			}
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: employee_leave_request.php');
?>