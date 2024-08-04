<?php
$host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: '';

// Establish a connection to the database.
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

// Check the connection and handle errors.
if ($polaczenie->connect_error) {
    die("Connection failed: " . $polaczenie->connect_error);
}

// Set the correct character set for communication with the database.
$polaczenie->set_charset("utf8");
?>