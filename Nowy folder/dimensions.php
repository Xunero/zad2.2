<?php
session_start();
include 'functions.php';

$shape = $_SESSION['shape'];
$dimensions = getShapeDimensions($shape);
$info = getShapeInfo($shape);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Podaj wymiary</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Podaj wymiary bryły: <?php echo ucfirst($shape); ?></h1>
    <form action="calculations.php" method="post">
        <?php foreach ($dimensions as $dim): 
            ?>
            <label><?php echo $dim['label']; ?>:
                <input type="number" name="<?php echo $dim['name']; ?>" min="0.1" step="0.1" required>
            </label><br>
        <?php endforeach; ?>
        <img src="<?php echo $info['image2']; ?>" alt="Podaj bok a">
        <form action="dimensions.php" method="post">
        <button type="submit">Dalej</button>
    </form>
</body>
</html>