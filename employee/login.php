<?php
session_start();
include 'includes/conn.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM employees WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        $_SESSION['error'] = 'Cannot find account with the username';
    } else {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['id'];
            
            // Check if the logged-in user has the position of Admin
            if ($row['position'] === 'Administrative Officer II') {
                echo "Redirecting to: /admin/home.php";
header('Location: /admin/home.php');
exit();
            } 
            // Check if the logged-in user has the position of School Head
            else if ($row['position'] === 'School Head') {
                echo "Redirecting to: /school_head/home.php";
header('Location: /school_head/home.php');
exit();
            } 
            else {
                header('Location: index.php'); // Redirect non-admin users to the main page
                exit();
            }
        } else {
            $_SESSION['error'] = 'Incorrect password';
        }
    }

    // Clean up
    $stmt->close();
} else {
    $_SESSION['error'] = 'Input employee credentials first';
}

// If not logged in or failed, redirect back to login page
header('Location: index.php');
exit();
?>
