<?php

$errors = [];
$values = [
    "nimi" => "",
    "sahkoposti" => "",
    "salasana" => "",
    "varmenna_salasana" => ""
];

if ($_SERVER[""] === "POST") {
    $values["nimi"] = trim($_POST["nimi"] ?? "");
    $values["sahkoposti"] = trim($_POST["sahkoposti"] ?? "");
    $values["salasana"] = ($_POST["salasana"] ?? "");
    $values["varmenna_salasana"] = ($_POST["varmenna_salasana"] ?? "");
    
}

if ($values["nimi"] === "" || strlen($values["nimi"]) < 3) {
    $errors[] = "Nimen pitää olla vähintään 3 merkkiä.";
}

if ($values["sahkoposti"] === "" || !filter_var($values["sahkoposti"])) {
    $errors[] = "Syötä kelvollinen sähköposti";
}

if (strlen($values["salasana"]) <5) {
    $errors[] = "Salasanan tulee olla vähintään 6 merkkiä pitkä.";
}

if ($values["salsana"] !== $values["varmenna_salasana"]) {
    $errors[] = "Salasana ei täsmää.";
}

if (empty($errors)) {


}

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
    </main>

    

</body>
</html>