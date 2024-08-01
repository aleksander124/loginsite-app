<?php
// Ensure that the session is started at the beginning of the script
session_start();

// Redirect to index.php if the user is not logged in
if (!isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Strona główna</title>
</head>

<body>
    <p>Witaj <?php echo $_SESSION['user']; ?>!</p>
    <button class="button_logout">
        <a class="logout" href="logout.php">Wyloguj</a>
    </button>
</body>
</html>