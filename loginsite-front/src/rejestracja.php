<?php
session_start();
if (isset($_POST['email'])){
    $nick = $_POST['nick'];
    $email = $_POST['email'];
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    // Validate input
    $errors = array();

    if (strlen($nick) < 3 || strlen($nick) > 20){
        $errors['nick'] = "Nazwa użytkownika musi posiadać od 3 do 20 znaków!";
    }

    if (!ctype_alnum($nick)){
        $errors['nick'] = "Nazwa użytkownika może składać się tylko z liter i cyfr (bez polskich znaków)";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Podaj poprawny adres e-mail";
    }

    if (strlen($haslo1) < 8 || strlen($haslo1) > 20){
        $errors['haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
    }

    if ($haslo1 != $haslo2){
        $errors['haslo'] = "Podane hasła nie są takie same";
    }

    if (!isset($_POST['regulamin'])){
        $errors['regulamin'] = "Potwierdź akceptację regulaminu!";
    }

    if (empty($errors)) {
        // All input is valid, proceed with registration

        // Use prepared statements to prevent SQL injection
        require_once "connect.php";
        $conn = new mysqli($host, $db_user, $db_password, $db_name);

        $stmt = $conn->prepare("SELECT id FROM uzytkownicy WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $errors['email'] = "Istnieje już konto przypisane do tego adresu email!";
        }

        $stmt = $conn->prepare("SELECT id FROM uzytkownicy WHERE user=?");
        $stmt->bind_param("s", $nick);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            $errors['nick'] = "Istnieje już konto o takiej nazwie!";
        }

        if (empty($errors)) {
            // Hash the password
            $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO uzytkownicy VALUES (NULL, ?, ?, ?)");
            $stmt->bind_param("sss", $nick, $haslo_hash, $email);
            $stmt->execute();

            $_SESSION['udanarejestracja'] = true;
            header('Location: witamy.php');
        }

        $conn->close();
    }

    // Store errors in session
    $_SESSION['errors'] = $errors;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="stylesheet" href="style.css">
    <title>Rejestracja</title>

    <style>
        .error{
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
<h1>Formularz rejestracji</h1>

<div>
    <form method="post">
        <label for="username">Nazwa użytkownika: </label>
        <input type="text" name="nick"><br><br>

        <?php
        if(isset($_SESSION['errors']['nick'])){
            echo '<div class="error">'.$_SESSION['errors']['nick'].'</div>';
        }
        ?>

        <label for="email">Email: </label>
        <input type="text" name="email"><br><br>

        <?php
        if(isset($_SESSION['errors']['email'])){
            echo '<div class="error">'.$_SESSION['errors']['email'].'</div>';
        }
        ?>

        <label for="password">Twoje hasło: </label>
        <input type="password" name="haslo1"><br><br>

        <?php
        if(isset($_SESSION['errors']['haslo'])){
            echo '<div class="error">'.$_SESSION['errors']['haslo'].'</div>';
        }
        ?>

        <label for="password">Powtórz hasło:</label>
        <input type="password" id="haslo2" name="haslo2"><br>
        <span id="haslo2-error" class="error"></span><br>

        <input type="checkbox" name="regulamin"> Akceptuję regulamin<br><br>

        <?php
        if(isset($_SESSION['errors']['regulamin'])){
            echo '<div class="error">'.$_SESSION['errors']['regulamin'].'</div>';
        }
        ?>

        <input type="submit" value="Zarejestruj się">

    </form>
</div>
</body>
</html>