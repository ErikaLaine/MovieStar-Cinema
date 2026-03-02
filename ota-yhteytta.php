<?php

require_once "db.php";




$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $nimi = trim($_POST["nimi"] ?? "");
    $sahkoposti = trim($_POST["sahkoposti"] ?? "");
    $viesti = trim($_POST["viesti"] ?? "");

    if ($nimi === "" || $sahkoposti === "" || $viesti === "") {
        $error = "Tayta kaikki kentat.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO viestit (nimi, sahkoposti, viesti) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $nimi, $sahkoposti, $viesti);
            if ($stmt->execute()) {
                $success = "Kiitos! Viestisi tallennettiin.";

                $sent_preview = [
                "nimi" => $nimi,
                "viesti" => $viesti
            ];
            } else {
                $error = "Tallennus epaonnistui: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Tallennus epaonnistui: " . $conn->error;
        }
    }
}


$result = $conn->query("SELECT id, nimi, sahkoposti, viesti, created_at FROM viestit ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ota yhteytta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <h1 class="logo">MovieStar Cinema<span>★</span></h1>

        <ul class="nav-links">
            <li><a href="index.html">Etusivu</a></li>
            <li><a href="#">Naytosajat</a></li>
            <li><a href="liput.html">Liput</a></li>
            <li><a href="#">Hae</a></li>
        </ul>

        <div class="nav-buttons">
            <a href="profiili.html" class="btn">Profiili</a>
            <a href="liput.html" class="btn">Osta liput</a>
        </div>
    </nav>
</header>

<main class="page">

  <h2>Ota yhteyttä</h2>

  <?php if ($success !== ""): ?>
    <div class="alert alert--success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <?php if ($error !== ""): ?>
    <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if (!empty($sent_preview)): ?>
    <div class="viesti">
      <strong>Lähetit tämän (<?= htmlspecialchars($sent_preview["nimi"]) ?>):</strong>
      <p><?= nl2br(htmlspecialchars($sent_preview["viesti"])) ?></p>
    </div>
  <?php endif; ?>

  <form method="POST" class="form">
    <label>Nimi</label>
    <input type="text" name="nimi" required>

    <label>Sahkoposti</label>
    <input type="email" name="sahkoposti" required>

    <label>Viesti</label>
    <textarea name="viesti" rows="5" required></textarea>

    <button type="submit" class="btn">Lähetä</button>
  </form>

  </main>


<footer>
    <section>
        <h4>Info</h4>
        <p>Edut ja kampanjat</p>
        <p>Ikarajat</p>
        <p>Teatterit</p>
        <p>Aukioloajat</p>
    </section>

    <section>
        <h4>Yritys</h4>
        <p>Tietoa meistä</p>
        <p>Tyopaikat</p>
        <p>Yhteiskuntavastuu</p>
    </section>

    <section>
        <h4>Asiakaspalvelu</h4>
        <p>asiakaspalvelu@moviestar.fi</p>
        <p><a href="ota-yhteytta.php">Ota yhteytta</a></p>
    </section>
</footer>

</body>
</html>
<?php
$conn->close();
?>



