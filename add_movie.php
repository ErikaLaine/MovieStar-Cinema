
<?php
<<<<<<< HEAD

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
=======
require_once "db.php"; // Eveliinan db.php hoitaa yhteyden

// Lomakkeelta lähetetyn tiedon käsittely
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $year = $_POST['year'];

    // Prepared statement SQL-injectionin estämiseksi
    $stmt = $conn->prepare("INSERT INTO movies (title, description, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $year);

    if ($stmt->execute()) {
        // Onnistuneen lisäyksen jälkeen voi ohjata hallintasivulle
        header("Location: admin.php"); // vaihda tarvittaessa omaan hallinta-/index-sivuun
        exit();
>>>>>>> 0a5e71936ddd07df3fc1a3e3c11ae560e6993d56
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

    $stmt->close();
}


$result = $conn->query("SELECT id, name, email, message, created_at FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Lisää elokuva</title>
</head>
<body>

<h2>Lisää uusi elokuva</h2>

<form method="POST" action="">
    <label>Elokuvan nimi:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Kuvaus:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Julkaisuvuosi:</label><br>
    <input type="number" name="year" required><br><br>

    <input type="submit" value="Lisää elokuva">
</form>

</body>
</html>
