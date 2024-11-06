<?php
session_start();
include 'functions.php';

// Inicjalizacja zmiennych
$shape = isset($_SESSION['shape']) ? $_SESSION['shape'] : 'szescian'; // Domyślny kształt
$randomDimensions = generateRandomDimensions($shape);
$correctCalculations = getShapeCalculations($shape, $randomDimensions);

// Zapisanie poprawnych obliczeń w sesji, by były dostępne podczas porównania
$_SESSION['correctCalculations'] = $correctCalculations;

// Sprawdzanie, czy formularz został wysłany
$isSurfaceCorrect = null;
$isVolumeCorrect = null;
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

    <!-- Wyświetlanie poprawnych odpowiedzi przed wysłaniem formularza -->
    <p>Oczekiwane wartości:</p>
    <ul>
        <li>Oczekiwane pole powierzchni: <?php echo round($correctCalculations['surface_area'], 2); ?></li>
        <li>Oczekiwana objętość: <?php echo round($correctCalculations['volume'], 2); ?></li>
    </ul>

    <form action="quiz.php" method="post">
        <label>Pole powierzchni całkowitej:
            <input type="number" name="user_surface_area" step="0.01" value="<?php echo isset($userSurface) ? round($userSurface, 2) : ''; ?>" required>
        </label><br>
        <label>Objętość:
            <input type="number" name="user_volume" step="0.01" value="<?php echo isset($userVolume) ? round($userVolume, 2) : ''; ?>" required>
        </label><br>
        <button type="submit">Sprawdź</button>
    </form>

    <!-- Wyświetlanie wyników po kliknięciu "Sprawdź" -->
    <?php
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobranie wymiarów wprowadzonych przez użytkownika
    $userSurface = isset($_POST['user_surface_area']) ? floatval($_POST['user_surface_area']) : null;
    $userVolume = isset($_POST['user_volume']) ? floatval($_POST['user_volume']) : null;

    // Ustalenie marginesu błędu do porównań zmiennoprzecinkowych
    $epsilon = 0.01;

    // Sprawdzanie poprawności odpowiedzi
    $isSurfaceCorrect = (abs($userSurface - $correctCalculations['surface_area']) < $epsilon);
    $isVolumeCorrect = (abs($userVolume - $correctCalculations['volume']) < $epsilon);

    // Wyświetlanie wyników
    if ($isSurfaceCorrect && $isVolumeCorrect) {
        $feedback = "<p>Poprawnie! Brawo!</p>";
    } else {
        $feedback = "<p>Niestety, odpowiedź jest błędna. Spróbuj jeszcze raz!</p>";
    }
}
    if (isset($feedback)) {
        echo $feedback;
    }
    ?>
</body>
</html>