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