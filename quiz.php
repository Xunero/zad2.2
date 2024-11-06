<?php
session_start();
include 'functions.php';

// Inicjalizacja zmiennych
$shape = $_SESSION['shape'];
// Sprawdzanie, czy wymiary zostały już zapisane w sesji
if (!isset($_SESSION['randomDimensions'])) {
    // Jeśli nie, losujemy nowe wymiary
    $_SESSION['randomDimensions'] = generateRandomDimensions($shape);
}

// Pobieranie wymiarów z sesji
$randomDimensions = $_SESSION['randomDimensions'];

// Generowanie obliczeń dla danego kształtu
$correctCalculations = getShapeCalculations($shape, $randomDimensions);
$_SESSION['correctCalculations'] = $correctCalculations;

$isSurfaceCorrect = null;
$isVolumeCorrect = null;
$feedback = "";

// Sprawdzanie odpowiedzi po wysłaniu formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userSurface = isset($_POST['user_surface_area']) ? floatval($_POST['user_surface_area']) : null;
    $userVolume = isset($_POST['user_volume']) ? floatval($_POST['user_volume']) : null;

    $epsilon = 0.01;

    // Sprawdzanie odpowiedzi użytkownika
    $isSurfaceCorrect = (abs($userSurface - $correctCalculations['surface_area']) < $epsilon);
    $isVolumeCorrect = (abs($userVolume - $correctCalculations['volume']) < $epsilon);

    if ($isSurfaceCorrect && $isVolumeCorrect) {
        $feedback = "<p>Poprawnie! Brawo!</p>";   
    } else {
        $feedback = "<p>Niestety, odpowiedź jest błędna. Spróbuj jeszcze raz!</p>";
    }
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

        var_dump($randomDimensions);

    
    // Wyświetlanie wymiarów
    foreach ($randomDimensions as $dim => $value): 
        // Dopasowujemy etykiety do odpowiednich wymiarów
        $label = isset($dimensionLabels[$dim]) ? $dimensionLabels[$dim] : $dim;
    ?>
        <li><?php echo $label . ': ' . $value; ?></li>
    <?php endforeach; ?>
</ul>
    </ul>

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

    <?php
    
    if (isset($feedback)) {
        echo $feedback;
    }

    if ($isSurfaceCorrect && $isVolumeCorrect) {
        echo '<form action="index.php" method="post">
                <button type="submit" name="action" value="choose_another">Wybierz inną figurę</button>
            </form>';

    echo '<form action="quiz.php" method="post">
                <button type="submit" name="action" value="next_example">Spróbuj kolejny przykład</button>
            </form>';
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'choose_another':
                    header('Location: index.php');
                    exit;
                case 'next_example':
                    $_SESSION['randomDimensions'] = generateRandomDimensions($shape);
                    header('Location: quiz.php');
                    exit;
            }
        }
    }
    ?>

</body>
</html>