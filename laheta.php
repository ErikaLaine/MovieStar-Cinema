
// Tietokantayhteys
$host = "localhost";          // palvelin
$user = "amk1013231";         // MySQL-käyttäjäsi
$pass = "IxNzc6lJ";           // MySQL-salasana
$db   = "wp_amk1013231";      // käytettävä tietokanta

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Yhteys epäonnistui: " . $conn->connect_error);
}

// Tarkista, että lomake on lähetetty
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Valmis prepared statement SQL-injektion välttämiseen
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    // Ohjataan takaisin lomakkeeseen vahvistuksen kanssa
    header("Location: ota-yhteyttä.php?status=success");
    exit;
} else {
    echo "Lomaketta ei lähetetty oikein.";
}

$conn->close();
?>
