<!DOCTYPE html>
<html>
<head>
    <title>Muokkaa elokuvaa</title>
</head>
<body>

<h2>Muokkaa elokuvaa</h2>

<form method="POST" action="">
    <label>Elokuvan nimi:</label><br>
    <input type="text" name="title" value=""><br><br>

    <label>Kuvaus:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Julkaisuvuosi:</label><br>
    <input type="number" name="year" value=""><br><br>

    <input type="submit" value="Tallenna muutokset">
</form>

</body>
</html>
