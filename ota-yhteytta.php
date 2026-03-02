
<?php

require_once "db.php";


$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Otetaan arvot ja siistitään vähän
    $values["nimi"] = trim($_POST["nimi"] ?? "");
    $values["sahkoposti"] = trim($_POST["sahkoposti"] ?? "");
    $values["viesti"] = trim($_POST["viesti"] ?? "");

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
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ota yhteytta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <h1 class="logo">MovieStar Cinema<span>★</span></h1>

        <ul class="nav-links">
            <li><a href="index.html">Etusivu</a></li>
            <li><a href="#">Naytosajat</a></li>
            <li><a href="liput.html">Liput</a></li>
            <li><a href="#">Hae</a></li>
        </ul>

        <div class="nav-buttons">
            <a href="profiili.html" class="btn">Profiili</a>
            <a href="liput.html" class="btn">Osta liput</a>
        </div>
    </nav>
</header>

<main style="max-width: 900px; margin: 40px auto; padding: 0 16px;">
    <h2>Ota yhteytta</h2>
    

    <?php if ($success !== ""): ?>
        <div style="border:1px solid #4caf50; padding:10px; margin:15px 0;">
            <?php echo htmlspecialchars($success, ENT_QUOTES, "UTF-8"); ?>
        </div>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <div style="border:1px solid #f44336; padding:10px; margin:15px 0;">
            <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="margin-top: 20px;">
        <label>Nimi:</label><br>
        <input type="text" name="name" required style="width:100%; padding:10px; margin:8px 0;"><br>

        <label>Sahkoposti:</label><br>
        <input type="email" name="email" required style="width:100%; padding:10px; margin:8px 0;"><br>

        <label>Viesti:</label><br>
        <textarea name="message" required rows="5" style="width:100%; padding:10px; margin:8px 0;"></textarea><br>

        <button type="submit" class="btn">Lähetä</button>
    </form>

    <hr style="margin: 30px 0;">

    <h3>Lahetetyt viestit</h3>

</main>

<footer>
    <section>
        <h4>Info</h4>
        <p>Edut ja kampanjat</p>
        <p>Ikarajat</p>
        <p>Teatterit</p>
        <p>Aukioloajat</p>
    </section>

    <section>
        <h4>Yritys</h4>
        <p>Tietoa meistä</p>
        <p>Tyopaikat</p>
        <p>Yhteiskuntavastuu</p>
    </section>

    <section>
        <h4>Asiakaspalvelu</h4>
        <p>asiakaspalvelu@moviestar.fi</p>
        <p><a href="ota-yhteytta.php">Ota yhteytta</a></p>
    </section>
</footer>

</body>
</html>
<?php
$conn->close();
?>



