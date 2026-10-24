<?php
require_once '../classes/StatisticsCalculator.php';

$result = null;
$rawInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numbers'])) {
    $rawInput = trim($_POST['numbers']);

    if (!empty($rawInput)) {
        // Separamos el texto ingresado por comas o espacios
        $items = preg_split('/[\s,]+/', $rawInput);
        
        $stats = new StatisticsCalculator($items);

        $result = [
            'average' => number_format($stats->getAverage(), 2, '.', ''),
            'median'  => number_format($stats->getMedian(), 2, '.', ''),
            'mode'    => $stats->getMode()
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 3 - Promedio, Mediana y Moda</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="back-link">← Volver al menú principal</a>
        
        <h1>Promedio, Mediana y Moda</h1>
        <p class="subtitle-text">Ingresa una serie de números reales separados por comas para calcular sus medidas estadísticas.</p>

        <form method="POST" action="">
            <div>
                <label for="numbers">Ingresa los números reales (separados por comas):</label>
                <input type="text" id="numbers" name="numbers" value="<?= htmlspecialchars($rawInput) ?>" placeholder="Ej: 5, 8.5, 12, 8.5, 3, 10" required>
            </div>

            <button type="submit">Calcular Estadísticas</button>
        </form>

        <?php if ($result !== null): ?>
            <div class="result-card">
                <h2 class="result-title">Resultados Estadísticos:</h2>
                <p><strong>Promedio:</strong> <span class="result-highlight"><?= htmlspecialchars($result['average']) ?></span></p>
                <p><strong>Mediana:</strong> <span class="result-highlight"><?= htmlspecialchars($result['median']) ?></span></p>
                <p><strong>Moda:</strong> <span class="result-highlight"><?= htmlspecialchars($result['mode']) ?></span></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>