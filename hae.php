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
    <link rel="stylesheet" href="css/style.css">
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
    <h2>Ota yhteyttä</h2>

    <?php if ($sent_viesti != ""): ?>
        <div class="message">
            <strong>Lähetit tämän (<?= htmlspecialchars($sent_nimi) ?>):</strong>
            <p><?= nl2br(htmlspecialchars($sent_viesti)) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="form">
        <label>Nimi</label>
        <input class="form__input" type="text" name="nimi" required>

        <label>Sähköposti</label>
        <input class="form__input" type="email" name="sahkoposti" required>

        <label>Viesti</label>
        <textarea class="form__textarea" name="viesti" rows="5" required></textarea>

        <button type="submit" class="btn btn-primary">Lähetä</button>
    </form>
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