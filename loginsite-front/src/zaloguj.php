<?php
session_start();

// Check if login and password are set
if (!isset($_POST['login']) || !isset($_POST['haslo'])) {
    header('Location: index.php');
    exit();
}

// Include database connection file
require_once "connect.php";

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sanitize user inputs
    $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
    $unslashed_password = stripslashes($_POST['haslo']); // Unslash the password

    // Prepare and execute SQL query
    $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE user=:login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch();

    // Check if user exists and password is correct
    if ($user && password_verify($unslashed_password, $user['pass'])) {
        // Set session variables for logged-in user
        $_SESSION['zalogowany'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['user'] = $user['user'];
        unset($_SESSION['blad']);
        header('Location: home.php');
        exit();
    } else {
        // Set error message and redirect to login page
        $_SESSION['blad'] = '<span>Nieprawidłowy login lub hasło!</span>';
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    // Log error and display a generic message
    error_log("Database error: " . $e->getMessage());
    $_SESSION['blad'] = '<span>Wystąpił błąd logowania. Proszę spróbować ponownie.</span>';
    header('Location: index.php');
    exit();
}
