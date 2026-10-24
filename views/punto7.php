<?php
session_start();
require_once '../classes/Calculator.php';

// Inicializar el historial en la sesión si no existe
if (!isset($_SESSION['calculator_history'])) {
    $_SESSION['calculator_history'] = [];
}

// Acción para borrar el historial
if (isset($_POST['clear_history'])) {
    $_SESSION['calculator_history'] = [];
    header('Location: punto7.php');
    exit;
}

$num1 = $_POST['num1'] ?? '';
$num2 = $_POST['num2'] ?? '';
$operation = $_POST['operation'] ?? 'add';
$currentResult = null;
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate'])) {
    if (is_numeric($num1) && is_numeric($num2)) {
        $calc = new Calculator((float)$num1, (float)$num2, $operation);
        $res = $calc->calculate();

        if ($res['error'] !== null) {
            $errorMessage = $res['error'];
        } else {
            $currentResult = $res['result'];
            // Guardar al inicio del historial para ver el último resultado primero
            array_unshift($_SESSION['calculator_history'], $res['entry']);
        }
    } else {
        $errorMessage = 'Por favor, ingresa números válidos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 7 - Calculadora con Historial</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="back-link">← Volver al menú principal</a>
        
        <h1>Calculadora con Historial</h1>
        <p class="subtitle-text">Realiza operaciones básicas entre números enteros o decimales y consulta tu historial de cálculos.</p>

        <?php if ($errorMessage !== null): ?>
            <div style="background-color: #ffe6e6; color: #d9534f; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="num1">Primer Número:</label>
                <input type="number" step="any" id="num1" name="num1" value="<?= htmlspecialchars((string)$num1) ?>" placeholder="Ej: 25.5" required>
            </div>

            <div>
                <label for="operation">Operación:</label>
                <select id="operation" name="operation" required>
                    <option value="add" <?= $operation === 'add' ? 'selected' : '' ?>>Suma (+)</option>
                    <option value="subtract" <?= $operation === 'subtract' ? 'selected' : '' ?>>Resta (-)</option>
                    <option value="multiply" <?= $operation === 'multiply' ? 'selected' : '' ?>>Multiplicación (×)</option>
                    <option value="divide" <?= $operation === 'divide' ? 'selected' : '' ?>>División (÷)</option>
                    <option value="percentage" <?= $operation === 'percentage' ? 'selected' : '' ?>>Porcentaje (%)</option>
                </select>
            </div>

            <div>
                <label for="num2">Segundo Número:</label>
                <input type="number" step="any" id="num2" name="num2" value="<?= htmlspecialchars((string)$num2) ?>" placeholder="Ej: 10" required>
            </div>

            <button type="submit" name="calculate">Calcular</button>
        </form>

        <?php if ($currentResult !== null): ?>
            <div class="result-card">
                <h2 class="result-title">Resultado:</h2>
                <p><span class="result-highlight"><?= htmlspecialchars((string)$currentResult) ?></span></p>
            </div>
        <?php endif; ?>

        <!-- Sección de Historial de Operaciones -->
        <div class="result-card" style="margin-top: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h2 class="result-title" style="margin: 0;">Historial de Operaciones</h2>
                <?php if (!empty($_SESSION['calculator_history'])): ?>
                    <form method="POST" action="" style="margin: 0; width: auto;">
                        <button type="submit" name="clear_history" style="background-color: #b5838d; padding: 8px 15px; font-size: 0.85rem;">Borrar Historial</button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if (!empty($_SESSION['calculator_history'])): ?>
                <ul>
                    <?php foreach ($_SESSION['calculator_history'] as $item): ?>
                        <li><?= htmlspecialchars($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay operaciones registradas en el historial.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>