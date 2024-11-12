<?php 
    include 'includes/session.php';

    if(isset($_POST['id'])){
        $id = $_POST['id'];

        // SQL query to fetch the schedule details for a specific teaching load (schedule) ID
        $sql = "SELECT *, schedules.id as schedid, employees.employee_id as empid 
                FROM schedules 
                LEFT JOIN employees ON employees.id = schedules.employee_id 
                WHERE schedules.id = '$id'";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();

        // Return the data as a JSON response
        echo json_encode($row);
    }
?>
