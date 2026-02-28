<?php
// TIETOKANTAYHTEYS
$servername = "localhost";
$username   = "amk1013231";
$password   = "IxNzc6lJ";
$dbname     = "wp_amk1013231";

$conn = new mysqli($servername, $username, $password, $dbname);

// Tarkista yhteys
if ($conn->connect_error) {
    die("Yhteys epäonnistui: " . $conn->connect_error);
}
?>

<?php
require_once "db.php";

$sahkoposti = trim($_GET["sahkoposti"] ?? "");
$user = null;

if ($sahkoposti !== "") {
    $stmt = $conn->prepare("SELECT nimi, sahkoposti, jasenyystaso, ostetut_liput, suosikkielokuva, FROM users WHERE sahkoposti = ?");
    $stmt->bind_param("s", $sahkoposti);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res-<>fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStar Cinema</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <body class="home">


    <header>
        <nav class="navbar">
            <h1 class="logo">MovieStar Cinema<span>★</span></h1>

            <ul class="nav-links">
                <li> <a href="index.html"> Etusivu</a></li>
                <li> <a href="#"> Näytösajat</a></li>
                <li> <a href="liput.html"> Liput</a></li>
                <li> <a href="hae.php"> Hae</a></li>


            </ul>

            <div class="nav-buttons">
                <a href="profiili.html" class="btn"> Profiili</a>
                <a href="liput.html" class="btn"> Osta liput</a>

            </div>
        </nav>

        <main class="page">
            <h1 class="page-title">Profiili</h1>

            <?php if (!$user): ?> 
                <p>Profiilia ei löydetty. Haluatko luoda käyttäjän? <a href="uusi_kayttaja.php">Luo Profiili</a></p>
            

            <?php else: ?>
                <div class="profile-card">
                    <div class="profile-info">
                        <h2><?= htmlspecialchars($user["nimi"]) ?></h2>
                        <p>Sähkoposti: <?= htmlspecialchars($user["sahkoposti"]) ?></p>
                        <p>Jäsenyystaso: <?= htmlspecialchars($user["jasenyystaso"]) ?></p>
                        <p>Ostetut liput: <?= (int)$user["ostetut_liput"] ?></p>
                        <p>Suosikkielokva: <?= htmlspecialchars($user["suosikkielokuva"] ?? "") ?></p>
                        <p>Pisteet: <?= (int)$user["sahkoposti"] ?> MSC-Coins</p>
                    </div>
                </div>
            <?php endif; ?>
        </main>
</body>
</html>