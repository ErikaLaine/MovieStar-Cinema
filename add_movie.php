<?php
require_once "db.php";

$servername = "localhost";
$username = "kayttaja";
$password = "salasana";
$dbname = "elokuvaprojekti";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Yhteys epäonnistui: " . $conn->connect_error);
}

// Lomakkeelta lähetetyn tiedon käsittely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];

    // Yksinkertainen SQL-lause lisäystä varten
    $sql = "INSERT INTO movies (title, description, year) VALUES ('$title', '$description', '$year')";

    if ($conn->query($sql) === TRUE) {
        echo "Elokuva lisätty!";
    } else {
        echo "Virhe: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lisää elokuva</title>
</head>
<body>

<h2>Lisää uusi elokuva</h2>

<form method="POST" action="">
    <label>Elokuvan nimi:</label><br>
    <input type="text" name="title"><br><br>

    <label>Kuvaus:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Julkaisuvuosi:</label><br>
    <input type="number" name="year"><br><br>

    <input type="submit" value="Lisää elokuva">
</form>

</body>
</html>
