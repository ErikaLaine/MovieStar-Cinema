<?php
require_once "db.php";

$hakusana = "";
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Hae elokuvia</title>
</head>
<body>

<h2>Hae elokuvia</h2>

<form method="GET">
    <input type="text" name="hakusana" placeholder="Kirjoita elokuvan nimi">
    <button type="submit">Hae</button>
</form>

<hr>

<?php

if (isset($_GET["hakusana"])) {

    $hakusana = trim($_GET["hakusana"]);

    if ($hakusana != "") {

        $stmt = $conn->prepare("SELECT * FROM movies WHERE title LIKE ?");
        
        if ($stmt) {

            $search = "%" . $hakusana . "%";
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    echo "<div>";
                    echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";
                    echo "<p>Vuosi: " . htmlspecialchars($row["year"]) . "</p>";
                    echo "<p>Genre: " . htmlspecialchars($row["genre"]) . "</p>";
                    echo "<p>" . htmlspecialchars($row["description"]) . "</p>";

                    if (!empty($row["image"])) {
                        echo "<img src='" . htmlspecialchars($row["image"]) . "' width='150'>";
                    }

                    echo "<hr>";
                    echo "</div>";
                }

            } else {
                echo "<p>Ei hakutuloksia.</p>";
            }

            $stmt->close();
        }
    } else {
        echo "<p>Kirjoita hakusana.</p>";
    }
}

$conn->close();
?>

</body>
</html>