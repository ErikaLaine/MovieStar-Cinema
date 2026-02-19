<?php
// TIETOKANTAYHTEYS
$servername = "localhost";
$username = "root";      // muuta jos käytätte muuta
$password = "";          // muuta jos käytätte salasanaa
$dbname = "elokuvat";    // muuta tietokannan nimi

$conn = new mysqli($servername, $username, $password, $dbname);

// Tarkista yhteys
if ($conn->connect_error) {
    die("Yhteys epäonnistui: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Hae elokuvia</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .movie { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; }
        img { max-width: 200px; display: block; margin-bottom: 10px; }
    </style>
</head>
<body>

<h1>Hae elokuvia</h1>

<form method="GET" action="">
    <input type="text" name="hakusana" placeholder="Kirjoita elokuvan nimi..." required>
    <button type="submit">Hae</button>
</form>

<hr>

<?php
if (isset($_GET['hakusana'])) {

    $hakusana = $_GET['hakusana'];

    // Prepared statement estää SQL-injektion
    $stmt = $conn->prepare("SELECT * FROM movies WHERE title LIKE ?");
    $searchTerm = "%" . $hakusana . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='movie'>";
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p><strong>Vuosi:</strong> " . htmlspecialchars($row['year']) . "</p>";
            echo "<p><strong>Genre:</strong> " . htmlspecialchars($row['genre']) . "</p>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";

            if (!empty($row['image'])) {
                echo "<img src='" . htmlspecialchars($row['image']) . "' alt='Elokuvan kuva'>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>Ei hakutuloksia.</p>";
    }

    $stmt->close();
}

$conn->close();
?>

</body>
</html>
