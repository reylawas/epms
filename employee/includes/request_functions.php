<?php
function getLeavesByUserId($conn, $userId) {
    $sql = "SELECT *, leaves.id AS lid, employees.employee_id AS empid 
            FROM leaves 
            LEFT JOIN employees ON employees.id = leaves.employee_id 
            WHERE employees.id = ? AND leaves.status IN ('Pending', 'Approved', 'Declined') 
            ORDER BY leaves.date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $leaves = [];
    while($row = $result->fetch_assoc()){
        $leaves[] = $row;
    }
    $stmt->close();
    return $leaves;
}
?>
