<?php


$servername = "localhost";
$username   = "trtkm25a_12";
$password   = "NB6NgN3X";   
$dbname     = "wp_trtkm25a_12";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Tietokantayhteys epäonnistui: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
