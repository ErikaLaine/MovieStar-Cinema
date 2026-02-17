<?php
require_once "db.php"; // Eveliinan db.php hoitaa yhteyden

// Lomakkeelta lähetetyn tiedon käsittely
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];

    // Prepared statement SQL-injectionin estämiseksi
    $stmt = $conn->prepare("INSERT INTO movies (title, description, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $year);

    if ($stmt->execute()) {
        // Onnistuneen lisäyksen jälkeen voi ohjata hallintasivulle
        header("Location: admin.php"); // vaihda tarvittaessa omaan hallinta-/index-sivuun
        exit();
    } else {
        echo "Virhe: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää elokuva</title>
</head>
<body>

<h2>Lisää uusi elokuva</h2>

<form method="POST" action="">
    <label>Elokuvan nimi:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Kuvaus:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Julkaisuvuosi:</label><br>
    <input type="number" name="year" required><br><br>

    <input type="submit" value="Lisää elokuva">
</form>

</body>
</html>
