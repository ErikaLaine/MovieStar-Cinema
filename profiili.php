<?php
require_once __DIR__ . "/db.php";

$sahkoposti = trim($_GET["sahkoposti"] ?? "");
$user = null;

if ($sahkoposti !== "") {
    // HUOM: poistettu ylimääräinen pilkku ennen FROM
    $stmt = $conn->prepare("
        SELECT nimi, sahkoposti, jasenyystaso, ostetut_liput, suosikkielokuva
        FROM users
        WHERE sahkoposti = ?
        LIMIT 1
    ");
    $stmt->bind_param("s", $sahkoposti);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc(); // korjattu fetch_assoc
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiili | MovieStar Cinema</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="home">

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
            <a href="profiili.php" class="btn">Profiili</a>
            <a href="liput.html" class="btn">Osta liput</a>
        </div>
    </nav>
</header>

<main class="page">
    <h1 class="page-title">Profiili</h1>

    <?php if (!$user): ?>
        <p>
            Profiilia ei löytynyt.
            Haluatko luoda käyttäjän?
            <a href="uusi_kayttaja.php">Luo Profiili</a>
        </p>
    <?php else: ?>
        <div class="profile-card">
            <div class="profile-info">
                <h2><?= htmlspecialchars($user["nimi"]) ?></h2>
                <p>Sähköposti: <?= htmlspecialchars($user["sahkoposti"]) ?></p>
                <p>Jäsenyystaso: <?= htmlspecialchars($user["jasenyystaso"] ?? "") ?></p>
                <p>Ostetut liput: <?= (int)($user["ostetut_liput"] ?? 0) ?></p>
                <p>Suosikkielokuva: <?= htmlspecialchars($user["suosikkielokuva"] ?? "") ?></p>
            </div>
        </div>
    <?php endif; ?>
</main>

</body>
</html>