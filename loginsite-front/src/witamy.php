<?php
session_start();

if (!isset($_SESSION['udanarejestracja'])){
    header('Location: index.php');
    exit();
}else{
    unset($_SESSION['udanarejestracja']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="style.css">
    <title>Logowanie</title>
</head>

<body>
<p>Dziękujemy za rejestracje w serwisie! Możesz już zalogować się na swoje konto<p>

    <a href="index.php">Zaloguj się na swoje konto!</a><br><br>

</body>
</html>