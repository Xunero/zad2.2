<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wybór bryły</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Wybierz bryłę</h1>
    <form action="shape_info.php" method="post">
        <label><input type="radio" name="shape" value="szescian" required> Sześcian</label><br>
        <label><input type="radio" name="shape" value="Walec"> Walec</label><br>
        <label><input type="radio" name="shape" value="Stozek"> Stożek</label><br>
        <button type="submit">Dalej</button>
    </form>
</body>
</html>