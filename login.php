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
            <a href="signup.php" id="b_creac">Stwórz konto</a>
        </section>
    </header>
    <main>
        <form action="login.php" method="post">
            <article id="login">
                <h1>Logowanie</h1>
                    <input type="text" name="username" placeholder="Twoja nazwa użytkownika">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="password" name="password" placeholder="Twoje hasło">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit">Zaloguj się</button>
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

        $hashed_password = hash('sha256', $plain_password);

        $db = mysqli_connect('localhost','root','','dropout2.0');

        $login = mysqli_real_escape_string($db, $login);

        $query = "SELECT password FROM users WHERE username ='$login'";
        $result = mysqli_query($db, $query);

        if ($result) {
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $stored_hashed_password = $row['password'];
                if (hash_equals($stored_hashed_password, $hashed_password)) {
                    session_start();
                    $_SESSION['login'] = $login;
                    echo "<script>document.location='welcome.php'</script>";
                } else {
                    echo "<script>alert('Nieprawidłowe hasło. Spróbuj ponownie.');</script>";
                }
            } else {
                echo "<script>alert('Nieprawidłowy login. Spróbuj ponownie.');</script>";
            }
        } else {
            echo "<script>alert('Błąd zapytania. Spróbuj ponownie.');</script>";
        }
        mysqli_close($db);
    }
?>
