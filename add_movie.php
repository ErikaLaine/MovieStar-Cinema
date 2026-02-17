<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];

    $stmt = $conn->prepare("INSERT INTO movies (title, description, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $year);

    if ($stmt->execute()) {
        echo "Elokuva lisätty onnistuneesti!";
    } else {
        echo "Virhe: " . $conn->error;
    }

    $stmt->close();
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
