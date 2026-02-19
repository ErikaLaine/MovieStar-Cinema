
<?php

$servername = "localhost";
$username   = "amk1013231";
$password   = "IxNzc6lJ";
$dbname     = "wp_amk1013231";


$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Tietokantayhteys epaonnistui: " . $conn->connect_error);
}


$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Otetaan arvot ja siistitään vähän
    $name    = trim($_POST["name"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name === "" || $email === "" || $message === "") {
        $error = "Tayta kaikki kentat.";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $message);
            if ($stmt->execute()) {
                $success = "Kiitos! Viestisi tallennettiin.";
            } else {
                $error = "Tallennus epaonnistui: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Tallennus epaonnistui: " . $conn->error;
        }
    }
}


$result = $conn->query("SELECT id, name, email, message, created_at FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lisää elokuva</title>
</head>
<body>

<h2>Lisää uusi elokuva</h2>

<form method="POST" action="">
    <label>Elokuvan nimi:</label><br>
    <input type="text" name="title"><br><br>

    <label>Kuvaus:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Julkaisuvuosi:</label><br>
    <input type="number" name="year"><br><br>

    <input type="submit" value="Lisää elokuva">
</form>

</body>
</html>
