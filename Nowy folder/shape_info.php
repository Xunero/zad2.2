<?php
session_start();
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['shape'] = $_POST['shape'];
}
$shape = $_SESSION['shape'];
$info = getShapeInfo($shape);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Informacje o bryle</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Informacje o bryle: <?php echo $info['name']; ?></h1>
    <p><?php echo $info['description']; ?></p>
    <img src="<?php echo $info['image']; ?>" alt="Rysunek bryły">
    <form action="dimensions.php" method="post">
        <button type="submit">Dalej</button>
    </form>
</body>
</html>