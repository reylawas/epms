<?php
include 'includes/session.php';

if(isset($_POST['add'])){
    $employee = $_POST['employee']; // Retrieve employee ID from the form
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $monday = $_POST['monday'];
    $tuesday = $_POST['tuesday'];
    $wednesday = $_POST['wednesday'];
    $thursday = $_POST['thursday'];
    $friday = $_POST['friday'];

    $sql = "SELECT * FROM employees WHERE employee_id = '$employee'";
    $query = $conn->query($sql);
    if($query->num_rows < 1){
        $_SESSION['error'] = 'Employee not found';
    } else {
        $row = $query->fetch_assoc();
        $employee_id = $row['id'];

        // Removed leave count check logic

        // Insert leave request directly without checking leave count
        $sql = "INSERT INTO schedules (employee_id, time_in, time_out, monday, tuesday, wednesday, thursday, friday, status) VALUES ('$employee_id', '$time_in', '$time_out', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday', 'Active')"; // Assuming 'Active' as a default status
        if($conn->query($sql)){
            $_SESSION['success'] = 'Schedules added successfully';
        } else {
            $_SESSION['error'] = $conn->error;
        }
        header('Location: teaching_load.php?employee_id=' . $employee_id);
        exit();
    }
} else {
    $_SESSION['error'] = 'Fill up add form first';
}

header('location: teaching_load.php');
?>