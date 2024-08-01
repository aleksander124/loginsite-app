<?php
session_start();

if (!isset($_POST['login']) || !isset($_POST['haslo'])){
    header('Location: index.php');
    exit();
}

require_once "connect.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");

    $login = htmlentities($_POST['login'], ENT_QUOTES, "UTF-8");
    $unslashed_password = stripslashes($_POST['haslo']); // Unslash the password

    $stmt = $pdo->prepare("SELECT * FROM uzytkownicy WHERE user=:login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($unslashed_password, $user['pass'])) { // Use the unslashed password for verification
        $_SESSION['zalogowany'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['user'] = $user['user'];
        unset($_SESSION['blad']);
        header('Location: home.php');
        exit();
    } else {
        $_SESSION['blad'] = '<span>Nieprawidłowy login lub hasło!</span>';
        header('Location: index.php');
        exit();
    }
} catch(PDOException $e) {
    // Log the error and display a generic message to the user
    error_log("Database error: " . $e->getMessage());
    $_SESSION['blad'] = '<span>Wystąpił błąd logowania. Proszę spróbować ponownie.</span>';
    header('Location: index.php');
    exit();
}