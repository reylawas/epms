<?php


$conn = mysqli_connect(
    getenv('DB_HOST'),       // Database host (e.g., localhost or the Coolify server)
    getenv('DB_USERNAME'),   // Database username
    getenv('DB_PASSWORD'),   // Database password
    getenv('DB_DATABASE'),   // Database name
    getenv('DB_PORT') ?: '3306' // Database port, default to 3306 if not set
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



// define('DB_HOST', 'localhost');
// define('DB_NAME', 'user_db');
// define('DB_USER', 'root');
// define('DB_PASS', '');

// try {
 
//     $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
//     $options = [
//         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::ATTR_EMULATE_PREPARES   => false,
//     ];
//     $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
// } catch (PDOException $e) {
  
//     exit("Failed to connect to database: " . $e->getMessage());
// }

?>