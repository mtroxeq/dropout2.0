<?php
    error_reporting(E_ALL ^ E_WARNING);
    function user()
    {
        if (!isset($_SESSION['login'])) return 'Gość';
        if ($_SESSION['login']=='') return 'Gość';
        return $_SESSION['login'];
    }
?>
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
            <form action="">
                <section id="search_text">
                    <input type="text" placeholder="Wyszukaj, co chcesz posłuchać...">
                    <button type="submit"><img src="./Graphics/search_FILL0_wght400_GRAD0_opsz24.png" alt="Szukaj"></button>
                </section>
            </form>
        </section>
        <section id="links">
            <?php
                @session_start();
                if(isset($_SESSION['login'])){
                    echo '<a href="upload.php" >Prześlij</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="account.php" >'.user().'</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="logout.php" >Wyloguj się</a>';
                }else{
                    echo '<a href="login.php" >Zaloguj się</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="signup.php" id="b_creac">Stwórz konto</a>';
                }
            ?>
        </section>
    </header>
    <main>
        <article id="desc">
            <?php
                @session_start();
                if(isset($_SESSION['login'])){
                    echo '<h1>Witaj ' . user() . '!
                    <p>Oto nowości przygotowane dla Ciebie.';
                    $db = mysqli_connect('localhost','root','','dropout2.0');
                    $query = "SELECT title, cover, created_by, filename FROM music";
                    $result = mysqli_query($db, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)){
                            echo '
                            <article id="music_feed">
                                <img src="./' . $row['cover'] . '" alt="cover">
                                <h3>' . $row['title'] . '</h3>
                                <h5>' . $row['created_by'] . '</h5>
                                <audio controls>
                                    <source src="./' . htmlspecialchars($row['filename']) . '" type="audio/mp3">
                                    Twoja przeglądarka nie obsługuje elementu audio.
                                </audio>
                            </article>';
                    }}
                }else{
                    echo'<h1>Witaj na <span style="color:#1C5D99">dropout</span></h1><p>Tutaj muzyka spotyka swoją przyszłość. W sercu naszej platformy leży pasja   do dźwięków, które poruszają, inspirują i łączą nas bez względu na to, skąd pochodzimy. <span style="color:#1C5D99">dropout</span> to nie     tylko strona do streamingu muzyki; to przestrzeń, gdzie artyści i fani tworzą wspólnie nowy wymiar muzycznych doświadczeń.
                    <h3>Nasza misja jest prosta: </h3> Dostarczać niezapomniane wrażenia muzyczne, udostępniając szeroką gamę utworów od znanych wykonawców,    aż po perełki        niezależnej sceny. W dropout wierzymy, że każdy ma prawo do odkrywania, dzielenia się i czerpania radości z muzyki –  bez ograniczeń, bez    kompromisów.
                    <h3>Z nami</h3> Zanurzysz się w głębię gatunków i dźwięków, które definiują współczesną scenę muzyczną. Od hip-hopu, przez elektronikę,     indie, rock, jazz,       aż po klasykę – <span style="color:#1C5D99">dropout</span> jest domem dla wszystkiego, co rytmiczne, melodyjne, ekscytujące i nowatorskie.
                    <h3>Przygotuj się</h3> Na podróż przez nieskończony wszechświat muzyki, gdzie każdy klik przenosi Cię w inne miejsce, a każdy utwór to  nowa historia do      odkrycia. Czy jesteś gotowy, aby stać się częścią tej przygody? Zapnij pasy, włącz <span   style="color:#1C5D99">dropout</span> i daj się ponieść fali dźwięków, która nie zna granic.       Witaj w domu, miłośniku muzyki.     Zapraszamy do świata <span style="color:#1C5D99">dropout</span>, gdzie muzyka gra dla Ciebie.</p>
                    <article id="music_feed">
                        <h2>Odkryj nowości od artystów</h2>';
                        $db = mysqli_connect('localhost','root','','dropout2.0');
                        $query = "SELECT title, cover, created_by, filename FROM music";
                        $result = mysqli_query($db, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)){
                                echo '
                                <article id="music_feed">
                                    <img src="./' . $row['cover'] . '" alt="cover">
                                    <h3>' . $row['title'] . '</h3>
                                    <h5>' . $row['created_by'] . '</h5>
                                    <audio controls>
                                        <source src="./' . htmlspecialchars($row['filename']) . '" type="audio/mp3">
                                        Twoja przeglądarka nie obsługuje elementu audio.
                                    </audio>
                                </article>';
                        }}
                    '</article>';
                }
            ?>    
        </article>
    </main>
</body>
</html>