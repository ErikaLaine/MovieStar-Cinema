<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
// tietokantayhteys
$host = "localhost";
$user = "root";
$pass = "";
$db   = "vieraskirja";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Yhteys epäonnistui: " . $conn->connect_error);

// Jos lomake lähetetty, tallenna viesti
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();
}

// Hae viestit
$result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Ota yhteyttä</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Ota yhteyttä asiakaspalveluun</h2>

<form action="" method="post">
    <label>Nimi</label><br>
    <input type="text" name="name" required><br><br>

    <label>Sähköposti</label><br>
    <input type="email" name="email" required><br><br>

    <label>Viesti</label><br>
    <textarea name="message" rows="5" required></textarea><br><br>

    <button type="submit">Lähetä</button>
</form>

<h2>Vieraskirja</h2>

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='viesti'>";
        echo "<strong>" . htmlspecialchars($row['name']) . "</strong> (" . $row['created_at'] . ")<br>";
        echo nl2br(htmlspecialchars($row['message']));
        echo "</div><hr>";
    }
} else {
    echo "<p>Ei vielä viestejä.</p>";
}

$conn->close();
?>

</body>
</html>

