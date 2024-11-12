<?php
// Load environment variables (if using php dotenv)
require_once 'vendor/autoload.php';  // Ensure you have composer installed
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create connection using environment variables
$conn = new mysqli(
    $_ENV['DB_HOST'], 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASS'], 
    $_ENV['DB_NAME']
);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
?>
