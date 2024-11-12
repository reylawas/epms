<?php
function getSchedulesByUserId($conn, $userId) {
    // Prepare and execute the SQL query
    $sql = "SELECT *, schedules.id AS lid, employees.employee_id AS empid
            FROM schedules
            LEFT JOIN employees ON employees.id = schedules.employee_id
            WHERE employees.id = ? ORDER BY schedules.time_in ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $userId); // Bind the user ID to the query
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch and return the schedules
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
    
    return $schedules;
}
?>
