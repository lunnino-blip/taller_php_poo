<?php
require_once '../classes/MathSeries.php';

$result = null;
$number = '';
$operation = 'fibonacci';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['number'], $_POST['operation'])) {
    $number = (int)$_POST['number'];
    $operation = $_POST['operation'];

    $math = new MathSeries($number);

    if ($operation === 'fibonacci') {
        $result = [
            'type' => 'Sucesión de Fibonacci',
            'data' => implode(', ', $math->getFibonacci())
        ];
    } else {
        $factData = $math->getFactorial();
        $result = [
            'type' => 'Factorial de ' . $number,
            'data' => $factData['steps']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 2 - Fibonacci & Factorial</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="back-link">← Volver al menú principal</a>
        
        <h1>Fibonacci & Factorial</h1>
        <p class="subtitle-text">Calcula la sucesión de Fibonacci o el factorial de un número dado.</p>

        <form method="POST" action="">
            <div>
                <label for="number">Ingresa un número entero positivo:</label>
                <input type="number" id="number" name="number" min="0" value="<?= htmlspecialchars((string)$number) ?>" placeholder="Ej: 6" required>
            </div>

            <div>
                <label for="operation">Selecciona la operación:</label>
                <select id="operation" name="operation" required>
                    <option value="fibonacci" <?= $operation === 'fibonacci' ? 'selected' : '' ?>>Sucesión de Fibonacci</option>
                    <option value="factorial" <?= $operation === 'factorial' ? 'selected' : '' ?>>Factorial</option>
                </select>
            </div>

            <button type="submit">Calcular Operación</button>
        </form>

        <?php if ($result !== null): ?>
            <div class="result-card">
                <h2 class="result-title">Resultado (<?= htmlspecialchars($result['type']) ?>):</h2>
                <p><span class="result-highlight"><?= htmlspecialchars($result['data']) ?></span></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

