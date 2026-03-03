<?php
$conn = new mysqli("localhost", "trtkm25a_12", "NB6NgN3X", "wp_trtkm25a_12");
if ($conn->connect_error) {
    die("Tietokantayhteys epäonnistui.");
}

$hakusana = "";
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Hae elokuvia</title>
    <style>
        body { margin: 0; font-family: Arial; background-color: #111; color: white; }
        h1,h2,h3 { color: #e50914; }
        .navbar { background: black; padding: 10px; }
        .nav-links { list-style: none; display: flex; gap: 10px; }
        .nav-links a { color: white; text-decoration: none; }
        .nav-links a:hover { color: #e50914; }
        input, button { padding: 5px; margin: 5px 0; }
        button { background: #e50914; color: white; border: none; cursor: pointer; }
        button:hover { background: #b20710; }
        .movie { background: #1c1c1c; padding: 10px; margin-bottom: 10px; border-left: 4px solid #e50914; }
        footer { background: black; padding: 15px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="navbar">
    <span class="logo">MovieStar Cinema ★</span>
    <ul class="nav-links">
        <li><a href="index.html">Etusivu</a></li>
        <li><a href="#">Näytösajat</a></li>
        <li><a href="liput.html">Liput</a></li>
        <li><a href="hae.php">Hae</a></li>
    </ul>
</div>

<!-- =====================================================
     HAKUTOIMINTO
===================================================== -->
<h2>Hae elokuvia</h2>

<form method="GET">
    <input type="text" name="hakusana" placeholder="Kirjoita elokuvan nimi">
    <button type="submit">Hae</button>
</form>

<hr>

<?php
if (isset($_GET['hakusana'])) {
    $hakusana = trim($_GET['hakusana']);

    if ($hakusana != "") {
        $stmt = $conn->prepare("SELECT * FROM movies WHERE title LIKE ?");
        if ($stmt) {
            $haku = "%" . $hakusana . "%";
            $stmt->bind_param("s", $haku);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='movie'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>Vuosi: " . $row['year'] . "</p>";
                    echo "<p>Genre: " . $row['genre'] . "</p>";
                    echo "<p>" . $row['description'] . "</p>";
                    if (!empty($row['image'])) { echo "<img src='" . $row['image'] . "' width='150'>"; }
                    echo "</div>";
                }
            } else { echo "<p>Ei hakutuloksia.</p>"; }
            $stmt->close();
        } else { echo "<p>Haku ei ole käytettävissä.</p>"; }
    } else { echo "<p>Kirjoita hakusana.</p>"; }
}
$conn->close();
?>

<footer>
    <p>&copy; MovieStar Cinema</p>
</footer>

</body>
</html>