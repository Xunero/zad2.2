<?php
session_start();
include 'functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['isSurfaceCorrect'] = null;
    $_SESSION['isVolumeCorrect'] = null;
}
$shape = $_SESSION['shape'];
$randomDimensions = generateRandomDimensions($shape);
$correctCalculations = getShapeCalculations($shape, $randomDimensions);

$isSurfaceCorrect = null;
$isVolumeCorrect = null;

// Sprawdzenie, czy formularz został przesłany
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userSurface = isset($_POST['user_surface_area']) ? floatval($_POST['user_surface_area']) : null;
    $userVolume = isset($_POST['user_volume']) ? floatval($_POST['user_volume']) : null;

    echo "<p>Wartość użytkownika (pole powierzchni): $userSurface</p>";
    echo "<p>Wartość użytkownika (objętość): $userVolume</p>";
    echo "<p>Oczekiwane pole powierzchni: " . $correctCalculations['surface_area'] . "</p>";
    echo "<p>Oczekiwana objętość: " . $correctCalculations['volume'] . "</p>";

    $isSurfaceCorrect = ($userSurface !== null && round($userSurface, 2) === round($correctCalculations['surface_area'], 2));
    $isVolumeCorrect = ($userVolume !== null && round($userVolume, 2) === round($correctCalculations['volume'], 2));
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Quiz: Oblicz pole powierzchni i objętość</h1>
    <p>Wymiary:</p>
    <ul>
        <?php
        $dimensionLabels = [
            'side' => 'Bok',
            'radius' => 'Promień',
            'height' => 'Wysokość'
        ];

        foreach ($randomDimensions as $dim => $value): 
        ?>
            <li><?php echo $dimensionLabels[$dim] . ': ' . $value; ?></li>
        <?php endforeach; ?>
        
    </ul>
    <form action="quiz.php" method="post">
        <label>Pole powierzchni całkowitej:
            <input type="number" name="user_surface_area" step="0.01" required>
        </label><br>
        <label>Objętość:
            <input type="number" name="user_volume" step="0.01" required>
        </label><br>
        <button type="submit">Sprawdź</button>
    </form>

    <?php
    // Wyświetlanie komunikatu tylko po przesłaniu formularza
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($isSurfaceCorrect && $isVolumeCorrect) {
            echo "<p>Poprawnie! Brawo!</p>";
            echo "<p>Wartość użytkownika (pole powierzchni): $userSurface</p>";
            echo "<p>Wartość użytkownika (objętość): $userVolume</p>";
        } else {
            echo "<p>Niestety, odpowiedź jest błędna. Spróbuj jeszcze raz!</p>";
            echo "<p>Wartość użytkownika (pole powierzchni): $userSurface</p>";
            echo "<p>Wartość użytkownika (objętość): $userVolume</p>";
        }
    }
    ?>
</body>
</html>