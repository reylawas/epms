<?php
include 'includes/session.php';
include 'includes/conn.php';


$userId = $_SESSION['admin'];

$sql = "SELECT employee_id FROM employees WHERE id = '$userId'";
$query = $conn->query($sql);

if ($query->num_rows > 0) {
    $row = $query->fetch_assoc();
    echo $row['employee_id']; 
} else {
    echo '';
}
?>
