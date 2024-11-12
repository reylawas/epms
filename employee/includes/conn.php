<?php
	$host = getenv('DB_HOST');
	$database = getenv('DB_DATABASE');
	$username = getenv('DB_USERNAME');
	$password = getenv('DB_PASSWORD');
	$port = getenv('DB_PORT') ?: 3306;  // Default to 3306 if no DB_PORT is set

	// Check if all environment variables are set
	if (!$host || !$database || !$username || !$password) {
	    die("Required environment variables (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD) are not set.");
	}

	$conn = new mysqli($host, $username, $password, $database, $port);

	if ($conn->connect_error) {
	    error_log("Connection failed: " . $conn->connect_error);
	    die("Connection failed. Please check the logs.");
	}

	// Your database operations go here...

	// Close the connection
	$conn->close();
?>
