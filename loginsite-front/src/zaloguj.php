<?php
session_start();

// Redirect if login or password is not set
if (empty($_POST['login']) || empty($_POST['haslo'])) {
    $_SESSION['blad'] = '<span>Login and password are required!</span>';
    header('Location: index.php');
    exit();
}

// Include database connection file
require_once "connect.php";

// Fetch and sanitize user input
$login = trim($_POST['login']);
$password = trim($_POST['haslo']);

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute SQL query
    $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE user = :login");
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables for logged-in user
        $_SESSION['zalogowany'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['user'] = $user['user'];

        // Regenerate session ID for security
        session_regenerate_id(true);

        // Redirect to home page
        header('Location: home.php');
        exit();
    } else {
        // Set error message and redirect to login page
        $_SESSION['blad'] = '<span>Invalid login or password!</span>';
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    // Log error and display a generic message
    error_log("Database error: " . $e->getMessage());
    $_SESSION['blad'] = '<span>An error occurred. Please try again.</span>';
    header('Location: index.php');
    exit();
}
