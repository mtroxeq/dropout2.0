<?php
    session_start();
    error_reporting(E_ALL ^ E_WARNING);
    function user()
    {
        if (!isset($_SESSION['login'])) return 'Gość';
        if ($_SESSION['login']=='') return 'Gość';
        return $_SESSION['login'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Przesyłanie plików muzycznych</title>
</head>
<body>
    <h1>Przesyłanie plików muzycznych</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label>Wybierz plik muzyczny (tylko MP3):</label>
        <input type="file" name="uploadedFile" accept=".mp3">
        <br>
        <label>Tytuł pliku:</label>
        <input type="text" name="fileTitle">
        <br>
        <label>Opis pliku:</label>
        <textarea name="fileDescription"></textarea>
        <br>
        <input type="hidden" name="fileArtist" value='<?php echo user(); ?>'>
        <label>Okładka albumu:</label>
        <input type="file" name="coverImage" accept="image/*">
        <br>
        <label>Prywatność:</label>
        <select name="privacy" id="">
            <option value="0">Publiczny</option>
            <option value="1">Prywatny</option>
        </select>
        <br>
        <input type="submit" value="Prześlij plik">
    </form>
</body>
</html>
<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $db = new mysqli('localhost','root','','dropout2.0');
        if ($db->connect_error) {
            die("Nie udało się połączyć z bazą danych: " . $db->connect_error);
        }
    
        $uploadedFile = $_FILES["uploadedFile"];
        $fileTitle = $_POST["fileTitle"];
        $fileArtist = $_POST["fileArtist"];
        $fileDescription = $_POST["fileDescription"];
        $coverImage = $_FILES["coverImage"];
        $privacy = $_POST["privacy"];
    
        $targetDirectory = "Music/";
        $targetFile = $targetDirectory . basename($uploadedFile["name"]);
    
        if (move_uploaded_file($uploadedFile["tmp_name"], $targetFile)) {
            echo "Plik muzyczny " . basename($uploadedFile["name"]) . " został przesłany.<br>";
        
            if ($coverImage["size"] > 0) {
                $targetDirectory = "Covers/";
                $targetCoverFile = $targetDirectory . basename($coverImage["name"]);
            
                if (move_uploaded_file($coverImage["tmp_name"], $targetCoverFile)) {
                    echo "Okładka albumu została przesłana i zapisana jako " . basename($coverImage["name"]) . ".<br>";
                
                    $sql = "INSERT INTO music(filename, title, description, created_by, cover, privacy) VALUES ('$targetFile', '$fileTitle',        '$fileDescription', '$fileArtist', '$targetCoverFile', '$privacy')";
                
                    if ($db->query($sql) === TRUE) {
                        echo "Informacje o pliku muzycznym i okładce zostały zapisane w bazie danych.<br>";
                    } else {
                        echo "Błąd zapisu informacji o pliku muzycznym w bazie danych: " . $db->error;
                    }
                } else {
                    echo "Wystąpił problem podczas przesyłania okładki albumu.<br>";
                }
            } else {
                echo "Nie wybrano okładki albumu.<br>";
            
            
                $sql = "INSERT INTO music(filename, title, description, artist, privacy) VALUES ('$targetFile', '$fileTitle', '$fileDescription', '$fileArtist', '$privacy')";
            
                if ($db->query($sql) === TRUE) {
                    echo "Informacje o pliku muzycznym zostały zapisane w bazie danych.<br>";
                } else {
                    echo "Błąd zapisu informacji o pliku muzycznym w bazie danych: " . $db->error;
                }
            }
        } else {
            echo "Wystąpił problem podczas przesyłania pliku muzycznego.<br>";
        }
        mysqli_close($db);
    }
?>
