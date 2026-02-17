<?php
require_once "db.php"; // Eveliinan db.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Lomakkeelta saadut tiedot
    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];

    // Prepared statement SQL-injectionin välttämiseksi
    $stmt = $conn->prepare("INSERT INTO movies (title, description, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $year);

    if ($stmt->execute()) {
        // Onnistumisen jälkeen ohjaa admin.php-sivulle
        header("Location: admin.php");
        exit();
    } else {
        echo "Virhe: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
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
