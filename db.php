<?php


$servername = "localhost";
$username   = "amk1013231";
$password   = "IxNzc6lJ";   
$dbname     = "wp_amk1013231";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Tietokantayhteys epäonnistui: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
