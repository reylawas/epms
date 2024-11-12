<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM employees WHERE username = '$username'";
    $query = $conn->query($sql);

    if ($query->num_rows < 1) {
        $_SESSION['error'] = 'Cannot find account with the username';
    } else {
        $row = $query->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['id'];
            
            // Check if the logged-in user has the position of Admin
            if ($row['position'] === 'Administrative Officer II') {
                header('Location: c084kw48cwow40ccoggkkg8k.143.198.91.47.sslip.io/admin/home.php');
            } 
            // Check if the logged-in user has the position of School Head
            else if ($row['position'] === 'School Head') {
                header('Location: c084kw48cwow40ccoggkkg8k.143.198.91.47.sslip.io/school_head/home.php');
            } 
            else {
                header('Location: index.php'); // Redirect non-admin users to the main page
            }
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password';
        }
    }
} else {
    $_SESSION['error'] = 'Input employee credentials first';
}

header('Location: index.php');
?>
