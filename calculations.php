<?php
session_start();
include 'functions.php';

$shape = $_SESSION['shape'];
$dimensions = $_POST;
$_SESSION['dimensions'] = $dimensions;

$calculations = getShapeCalculations($shape, $dimensions);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wzory obliczeń</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Obliczenia dla <?php echo ucfirst($shape); ?></h1>
    <p>Pole powierzchni całkowitej: <?php echo $calculations['surface_area']; ?> jednostek²</p>
    <p>Objętość: <?php echo $calculations['volume']; ?> jednostek³</p>
    <form action="quiz.php" method="post">
        <button type="submit">Sprawdź swoje umiejętności</button>
    </form>
</body>
</html>