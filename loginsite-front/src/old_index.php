<?php
       session_start();

       if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
		header('Location: home.php');
		exit();
	    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="main.css" rel="stylesheet" />
    <title>Logowanie</title>
</head>

<body>
    <h1>Formularz logowania</h1>
    
    <div id="panel">
        Nie masz jeszcze konta?<br><button class="reg_button"><a href="rejestracja.php">Zarejestruj się!</a></button><br>
        <form method="post" action="zaloguj.php">
            <label for="username" >Nazwa użytkownika: </label>
            <input type="text" name="login" id="username"><br><br>
            <label for="password">Hasło: </label>
            <input type="password" name="haslo" id="password">
            
            <p class="blad"><?php
                if(isset($_SESSION['blad']))
                    echo $_SESSION['blad'];
            ?></p>

                <div id="lower">
                    <label for="submit">
                        <input type="submit" value="Zaloguj" class="button button--block" name="loguj">
                    </label>
                </div>
        </form>
    </div>
</body>
</html>