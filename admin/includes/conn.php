<?php
	// Hardcode the environment variables for testing purposes
	$host = 'z48w4sk4w0w4kk084c4oggs4';  // DB_HOST
	$database = 'default';  // DB_DATABASE
	$username = 'mysql';  // DB_USERNAME
	$password = 'YfZPI9ttqdyjK68qs68GUnhrpodQt0jO3zLDkVR4ZXTFl30EtKi1hGCkk9HITVrW';  // DB_PASSWORD
	$port = 3306;  // DB_PORT (default value is 3306)

	// Check if any of the required values are missing
	if (!$host || !$database || !$username || !$password) {
	    die("Required environment variables (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD) are not set.");
	}

	// Create a new connection to the database
	$conn = new mysqli($host, $username, $password, $database, $port);

	// Check for a connection error
	if ($conn->connect_error) {
	    error_log("Connection failed: " . $conn->connect_error);
	    die("Connection failed. Please check the logs.");
	}

	// Your database operations go here...

	// Close the connection when done
	$conn->close();
?>
