
<?php
require_once "db.php";

$errors = [];
$nimi = "";
$sahkoposti = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nimi = ($_POST["nimi"] ?? "");
    $sahkoposti = ($_POST["sahkoposti"] ?? "");
    $salasana = $_POST["salasana"] ?? "";
    $varmennus = $_POST["varmenna_salasana"] ?? "";
    
}

if ($nimi === "" || strlen($nimi) > 3) {
    $errors[] = "Nimen pitää olla vähintään 3 merkkiä.";
}

if ($sahkoposti === "" || !filter_var($sahkoposti, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Syötä kelvollinen sähköposti";
}

if (strlen($salasana) <5) {
    $errors[] = "Salasanan tulee olla vähintään 5 merkkiä pitkä.";
}

if ($salasana !== $varmennus) {
    $errors[] = "Salasana ei täsmää.";
}

if (empty($errors)) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE sahkoposti = ?");
    $stmt->bind_pram("s", $sahkoposti); 
    $stmt->execute();

    $tulokset = $stmt->get_result(); //tulokset user tietokannasta

    if ($res->num_rows > 0) {
        $errors[] = "Tämä sähköposti on jo käytössä";
    }

    $stmt->close();
}

if (empty($errors)) { 
    $sql = "INSERT INTO users (nimi, sahkoposti, salasana_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_pram("sss", $nimi, $sahkoposti, $salsana); //sss tilalle nimi, säpö ja salasana 
    $kirjautunut = $stmt->execute();

    if ($kirjautunut) {
        $sahkoposti = ($values["sahkoposti"]); 
        header("Location: profiili.php?sahkoposti=" . $sahkoposti);
        exit;

    } else {
        $errors[] = "Tallennus epäonnistui" . $stmt->error;
    }

    $stmt->close();
}
////W3-school htmlspecialchars()-> erikoisemrkit parempaan muotoon
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8" />
    <meta name= "viewposrt" content="width=device-width, initial.scale=1.0" />
    <title>Luo Profiili | MovieStar Cinema</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <nav class="navbar">
        <h1 class="logo">MovieStar Cinema<span>★</span></h1>

        <ul class="nav-links">
            <li><a href="index.html">Etusivu</a></li>
            <li><a href="naytosajat.html">Näytösajat</a></li>
            <li><a href="liput.html">Liput</a></li>
            <li><a href="haku.html">Hae</a></li>
        </ul>

        <div class="nav-buttons">
            <a href="profiili.html" class="btn">Profiili</a>
            <a href="liput.html" class="btn">Osta liput</a>
        </div>
    </nav>
    <main class="page">
        <h1 class="page-title">Luo Profiili</h1>

    <?php if (!empty($errors)): ?>
    <div class="form-errors">
        <h3>Tarkista:</h3>
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

        <from class="form-card" method="POST" action="uusi_kayttaja.php" novalidate>
            <label class="form-label">
                Nimi
                <input class="form-input" type="text" name="nimi" value= <?php echo htmlspecialchars($nimi) ?>/>
            </label>

            <label class="form-label">
                Sähköposti
                <input class="form-input" type="email" name="sahkoposti" value= <?php echo htmlspecialchars($sahkoposti) ?>/>
            </label>

            <label class="form-label">
                Salasana
                <input class="form-input" type="password" name="salasana"/>
            </label>

            <label class="form-label">
                Varmenna salasana
                <input class="form-input" type="salasana" name="varmenna_salasana"/>
            </label>

            <button class="btn btn-primary" type="submit">Luo profiili</button>
        </form>
    </main>
</body>
</html> 