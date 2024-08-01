<?php
$host = "openshift-deployment-site-php-login-site-db-service";
$db_user = "root";
$db_password = "root";
$db_name = "logowanie";

// Establish a connection to the database
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

// Check the connection and handle errors
if ($polaczenie->connect_error) {
    die("Connection failed: " . $polaczenie->connect_error);
}

// Set the correct character set for communication with the database
$polaczenie->set_charset("utf8"); // Assuming UTF-8 encoding

// Perform any other necessary configuration for the database connection
// For example, setting error mode, handling exceptions, etc.

// It's also good practice to close the database connection when it's no longer needed
// $polaczenie->close(); // Close the connection when done with database operations
?>