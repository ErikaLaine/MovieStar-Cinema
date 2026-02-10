<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <title>Ota yhteyttä</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Ota yhteyttä asiakaspalveluun</h2>

<p>Täytä alla oleva lomake ja vastaamme sinulle mahdollisimman pian.</p>

<form action="laheta.php" method="post">
    <label>Nimi</label><br>
    <input type="text" name="name" required><br><br>

    <label>Sähköposti</label><br>
    <input type="email" name="email" required><br><br>

    <label>Viesti</label><br>
    <textarea name="message" rows="5" required></textarea><br><br>

    <button type="submit">Lähetä</button>
</form>

</body>
</html>
