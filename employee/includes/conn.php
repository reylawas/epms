<?php
	$host = getenv('DB_HOST');
	$database = getenv('DB_DATABASE');
	$username = getenv('DB_USERNAME');
	$password = getenv('DB_PASSWORD');
	$port = getenv('DB_PORT');

	$conn = new mysqli($host, $username, $password, $database, $port);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
?>
