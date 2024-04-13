<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="./CSS/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>dropout</title>
</head>
<body>
    <header>
        <section id="identify">
            <img src="./Graphics/logodropout.jpg" alt="Logo">
            <h1>dropout</h1>
        </section>
        <section id="search">
        </section>
        <section id="links">
            <a href="welcome.php" >Wróć do strony głównej</a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="login.php" id="b_creac">Zaloguj się</a>
        </section>
    </header>
    <main>
        <form action="signup.php" method="post">
            <article id="login">
                <h1>Stwórz konto</h1>
                    <input type="text" name="email" placeholder="Twój adres e-mail" required>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="username" placeholder="Twoja nazwa użytkownika" required>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="password" name="password" placeholder="Twoje hasło" required>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="password" placeholder="Powtórz hasło" required>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit">Utwórz konto</button>
            </article>
        </form>
    </main>
</body>
</html>
<?php
    error_reporting(E_ALL ^ E_WARNING);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $login = $_POST['username'];
        $plain_password = $_POST['password'];
        $email = $_POST['email'];
        
        $hashed_password = hash('sha256', $plain_password);
        
        $db = mysqli_connect('localhost','root','','dropout2.0');
        
        $login = mysqli_real_escape_string($db, $login);
        $hashed_password = mysqli_real_escape_string($db, $hashed_password);
        
        $check_query = "SELECT * FROM users WHERE username='$login'";
        $check_result = mysqli_query($db, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Nazwa użytkownika jest już zajęta. Wybierz inną nazwę.')</script>";
        } else {
            $query = "INSERT INTO users (username, password, email) VALUES ('$login', '$hashed_password', '$email')";
            $result = mysqli_query($db, $query);
            if ($result) {
                session_start();
                $_SESSION['login'] = $login;
                echo "<script>alert('Pomyślnie zarejestrowano.');document.location='welcome.php'</script>";
            } else {
                echo "<script>alert('Błąd podczas rejestracji.');</script>";
            }
        }
        mysqli_close($db);
    }
    
?>