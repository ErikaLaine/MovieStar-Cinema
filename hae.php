<?php
require_once "db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sent_nimi = "";
$sent_viesti = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nimi = trim($_POST["nimi"] ?? "");
    $sahkoposti = trim($_POST["sahkoposti"] ?? "");
    $viesti = trim($_POST["viesti"] ?? "");

    if ($nimi !== "" && $sahkoposti !== "" && $viesti !== "") {
        $stmt = $conn->prepare("INSERT INTO viestit (nimi, sahkoposti, viesti) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $nimi, $sahkoposti, $viesti);
            if ($stmt->execute()) {
                $sent_nimi = $nimi;
                $sent_viesti = $viesti;
            }
            $stmt->close();
        } else {
            die("SQL-virhe: " . $conn->error);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ota yhteyttä | MovieStar Cinema</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <h1 class="logo">MovieStar Cinema<span>★</span></h1>
        <ul class="nav-links">
            <li><a href="index.html">Etusivu</a></li>
            <li><a href="#">Näytösajat</a></li>
            <li><a href="liput.html">Liput</a></li>
            <li><a href="hae.php">Hae</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="profiili.html" class="btn">Profiili</a>
            <a href="liput.html" class="btn">Osta liput</a>
        </div>
    </nav>
</header>

<main class="page">
    <h1 class="page-title">Hae elokuvia</h1>

    <form class="form-card" method="GET" novalidate>
        <label class="form-label">
            Hakusana
            <input class="form-input" type="text" name="hakusana" value="<?= htmlspecialchars($hakusana) ?>" placeholder="Kirjoita elokuvan nimi">
        </label>
        <button class="btn btn-primary" type="submit">Hae</button>
    </form>

    <hr>

    <?php
    if(isset($_GET['hakusana'])){
        $hakusana = trim($_GET['hakusana']);
        if($hakusana != ""){
            $stmt = $conn->prepare("SELECT nimi, vuosi, genre, kuvaus, kuva FROM elokuvat WHERE nimi LIKE ?");
            if(!$stmt){
                die("SQL-virhe: " . $conn->error);
            }
            $haku = "%".$hakusana."%";
            $stmt->bind_param("s", $haku);
            $stmt->execute();
            $stmt->bind_result($nimi, $vuosi, $genre, $kuvaus, $kuva);

            $found = false;
            while($stmt->fetch()){
                $found = true;
                echo "<div class='movie'>";
                echo "<h3>".htmlspecialchars($nimi)."</h3>";
                echo "<p><strong>Vuosi:</strong> ".htmlspecialchars($vuosi)."</p>";
                echo "<p><strong>Genre:</strong> ".htmlspecialchars($genre)."</p>";
                echo "<p>".htmlspecialchars($kuvaus)."</p>";
                if(!empty($kuva)){
                    echo "<img src='".htmlspecialchars($kuva)."' width='150'>";
                }
                echo "</div>";
            }
            if(!$found){
                echo "<p>Ei hakutuloksia.</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Kirjoita hakusana.</p>";
        }
    }
    ?>
</main>

<footer>
    <section>
        <h4>Info</h4>
        <p>Edut ja kampanjat</p>
        <p>Ikärajat</p>
        <p>Teatterit</p>
        <p>Aukioloajat</p>
    </section>

    <section>
        <h4>Yritys</h4>
        <p>Tietoa meistä</p>
        <p>Työpaikat</p>
        <p>Yhteiskuntavastuu</p>
    </section>

    <section>
        <h4>Asiakaspalvelu</h4>
        <p>asiakaspalvelu@moviestar.fi</p>
        <p><a href="ota-yhteytta.php">Ota yhteyttä</a></p>
    </section>
</footer>

</body>
</html>

<?php
$conn->close();
?>