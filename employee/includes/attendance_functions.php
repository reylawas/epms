<?php
function getAttendanceByUserId($conn, $userId) {
    $sql = "SELECT *, attendance.id AS aid, employees.employee_id AS empid 
            FROM attendance 
            LEFT JOIN employees ON employees.id = attendance.employee_id 
            WHERE employees.id = ?
            ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $attendance = [];
    while($row = $result->fetch_assoc()){
        $attendance[] = $row;
    }
    $stmt->close();
    return $attendance;
}
?>
