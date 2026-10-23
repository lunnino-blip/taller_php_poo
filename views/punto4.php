<?php
require_once '../classes/SetOperations.php';

$result = null;
$rawInputA = '';
$rawInputB = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setA'], $_POST['setB'])) {
    $rawInputA = trim($_POST['setA']);
    $rawInputB = trim($_POST['setB']);

    // Separar elementos por comas o espacios
    $itemsA = preg_split('/[\s,]+/', $rawInputA);
    $itemsB = preg_split('/[\s,]+/', $rawInputB);

    $sets = new SetOperations($itemsA, $itemsB);

    $result = [
        'union'        => $sets->formatSet($sets->getUnion()),
        'intersection' => $sets->formatSet($sets->getIntersection()),
        'diffAB'       => $sets->formatSet($sets->getDifferenceAB()),
        'diffBA'       => $sets->formatSet($sets->getDifferenceBA())
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 4 - Operaciones de Conjuntos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="back-link">← Volver al menú principal</a>
        
        <h1>Operaciones de Conjuntos</h1>
        <p class="subtitle-text">Ingresa dos conjuntos de números enteros para calcular su unión, intersección y diferencias.</p>

        <form method="POST" action="">
            <div>
                <label for="setA">Conjunto A (números enteros separados por comas):</label>
                <input type="text" id="setA" name="setA" value="<?= htmlspecialchars($rawInputA) ?>" placeholder="Ej: 1, 2, 3, 4, 5" required>
            </div>

            <div>
                <label for="setB">Conjunto B (números enteros separados por comas):</label>
                <input type="text" id="setB" name="setB" value="<?= htmlspecialchars($rawInputB) ?>" placeholder="Ej: 4, 5, 6, 7" required>
            </div>

            <button type="submit">Calcular Operaciones</button>
        </form>

        <?php if ($result !== null): ?>
            <div class="result-card">
                <h2 class="result-title">Resultados de Conjuntos:</h2>
                <p><strong>Unión (A ∪ B):</strong> <span class="result-highlight"><?= htmlspecialchars($result['union']) ?></span></p>
                <p><strong>Intersección (A ∩ B):</strong> <span class="result-highlight"><?= htmlspecialchars($result['intersection']) ?></span></p>
                <p><strong>Diferencia (A - B):</strong> <span class="result-highlight"><?= htmlspecialchars($result['diffAB']) ?></span></p>
                <p><strong>Diferencia (B - A):</strong> <span class="result-highlight"><?= htmlspecialchars($result['diffBA']) ?></span></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>