<?php
if (isset($_POST['employee'])) {
    $output = array('error' => false);

    include 'conn.php';
    include 'timezone.php';

    $employee = $_POST['employee'];
    $status = $_POST['status'];

    $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
    $query = $conn->query($sql);

    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $id = $row['id'];
        $date_now = date('Y-m-d');

        if ($status == 'in') {
            // Check the count of time_in entries for today, excluding time_in = '00:00:00'
            $sql = "SELECT COUNT(*) AS time_in_count 
                    FROM attendance 
                    WHERE employee_id = '$id' AND date = '$date_now' 
                    AND time_in IS NOT NULL AND time_in != '00:00:00'";
            $query = $conn->query($sql);
            $time_in_count = $query->fetch_assoc()['time_in_count'];

            if ($time_in_count >= 2) {
                $output['error'] = true;
                $output['message'] = 'You have already timed in twice today.';
            } else {
                // Check if last record has a time_out before allowing another time_in
                $sql = "SELECT * FROM attendance 
                        WHERE employee_id = '$id' AND date = '$date_now' 
                        ORDER BY id DESC LIMIT 1";
                $query = $conn->query($sql);

                if ($query->num_rows > 0) {
                    $last_record = $query->fetch_assoc();
                    if ($last_record['time_out'] == '00:00:00' || $last_record['time_out'] == null) {
                        $output['error'] = true;
                        $output['message'] = 'Please time out before timing in again.';
                    } else {
                        // Allow time in
                        $sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', NOW(), '1')";
                        if ($conn->query($sql)) {
                            $output['message'] = 'Time in: ' . $row['firstname'] . ' ' . $row['lastname'];
                        } else {
                            $output['error'] = true;
                            $output['message'] = $conn->error;
                        }
                    }
                } else {
                    // First time in for the day
                    $sql = "INSERT INTO attendance (employee_id, date, time_in, status) VALUES ('$id', '$date_now', NOW(), '1')";
                    if ($conn->query($sql)) {
                        $output['message'] = 'Time in: ' . $row['firstname'] . ' ' . $row['lastname'];
                    } else {
                        $output['error'] = true;
                        $output['message'] = $conn->error;
                    }
                }
            }
        } else {
            // Time out logic
            $sql = "SELECT COUNT(*) AS time_out_count 
                    FROM attendance 
                    WHERE employee_id = '$id' AND date = '$date_now' 
                    AND time_out IS NOT NULL";
            $query = $conn->query($sql);
            $time_out_count = $query->fetch_assoc()['time_out_count'];

            if ($time_out_count >= 2) {
                $output['error'] = true;
                $output['message'] = 'You have already timed out twice today.';
            } else {
                $sql = "SELECT *, attendance.id AS uid 
                        FROM attendance 
                        LEFT JOIN employees ON employees.id = attendance.employee_id 
                        WHERE attendance.employee_id = '$id' AND date = '$date_now' 
                        ORDER BY attendance.id DESC LIMIT 1";
                $query = $conn->query($sql);

                if ($query->num_rows < 1) {
                    $output['error'] = true;
                    $output['message'] = 'Cannot timeout. No time in.';
                } else {
                    $row = $query->fetch_assoc();
                    if ($row['time_out'] != '00:00:00' && $row['time_out'] != null) {
                        $output['error'] = true;
                        $output['message'] = 'You have already timed out for this record.';
                    } else {
                        // Update time_out
                        $sql = "UPDATE attendance SET time_out = NOW(), status = '2' WHERE id = '" . $row['uid'] . "'";
                        if ($conn->query($sql)) {
                            $output['message'] = 'Time out: ' . $row['firstname'] . ' ' . $row['lastname'];

                            $sql = "SELECT * FROM attendance WHERE id = '" . $row['uid'] . "'";
                            $query = $conn->query($sql);
                            $urow = $query->fetch_assoc();

                            $time_in = new DateTime($urow['time_in']);
                            $time_out = new DateTime($urow['time_out']);
                            $interval = $time_in->diff($time_out);
                            $hrs = $interval->format('%h');
                            $mins = $interval->format('%i') / 60;
                            $int = $hrs + $mins;
                            if ($int > 4) {
                                $int -= 1; // Deduct 1 hour for break
                            }

                            $sql = "UPDATE attendance SET num_hr = '$int' WHERE id = '" . $row['uid'] . "'";
                            $conn->query($sql);
                        } else {
                            $output['error'] = true;
                            $output['message'] = $conn->error;
                        }
                    }
                }
            }
        }
    } else {
        $output['error'] = true;
        $output['message'] = 'Employee ID not found';
    }
} else {
    $output['error'] = true;
    $output['message'] = 'Invalid request';
}

echo json_encode($output);
?>
