<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$hakusana = "";
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hae elokuvia | MovieStar Cinema</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <nav class="navbar">
        <h1 class="logo">MovieStar Cinema<span>★</span></h1>
        <ul class="nav-links">
            <li><a href="index.html">Etusivu</a></li>
            <li><a href="#">Näytösajat</a></li>
            <li><a href="liput.html">Liput</a></li>
            <li><a href="hae.php">Hae</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="profiili.html" class="btn">Profiili</a>
            <a href="liput.html" class="btn">Osta liput</a>
        </div>
    </nav>
</header>

<main class="page">
    <h1 class="page-title">Hae elokuvia</h1>

    <form class="form-card" method="GET">
        <label class="form-label">
            Hakusana
            <input class="form-input" 
                   type="text" 
                   name="hakusana" 
                   value="<?php echo isset($_GET['hakusana']) ? htmlspecialchars($_GET['hakusana']) : ''; ?>" 
                   placeholder="Kirjoita elokuvan nimi">
        </label>
        <button class="btn btn-primary" type="submit">Hae</button>
    </form>

    <hr>

    <?php
    if(isset($_GET['hakusana'])){
        $hakusana = trim($_GET['hakusana']);

        if(!empty($hakusana)){
            echo "<p>Elokuvaa ei löytynyt.</p>";
        } else {
            echo "<p>Kirjoita hakusana.</p>";
        }
    }
    ?>
</main>

<footer>
    <section>
        <h4>Info</h4>
        <p>Edut ja kampanjat</p>
        <p>Ikärajat</p>
        <p>Teatterit</p>
        <p>Aukioloajat</p>
    </section>
    <section>
        <h4>Yritys</h4>
        <p>Tietoa meistä</p>
        <p>Työpaikat</p>
        <p>Yhteiskuntavastuu</p>
    </section>
    <section>
        <h4>Asiakaspalvelu</h4>
        <p>asiakaspalvelu@moviestar.fi</p>
        <p><a href="hae.php">Hae elokuvia</a></p>
    </section>
</footer>

</body>
</html>