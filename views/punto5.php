<?php
require_once '../classes/BinaryConverter.php';

$result = null;
$numberInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['number'])) {
    $numberInput = trim($_POST['number']);

    if($numberInput !== '' && is_numeric($numberInput)){
        $decimal = (int)$numberInput;
        $converter = new BinaryConverter($decimal);
        $result = $converter->convertToBinary();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 5 - Decimal a Binario</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
       <a href="../index.php" class="back-link">← Volver al menú principal</a>
        
        <h1>Conversor Decimal a Binario</h1>
        <p class="subtitle-text">Ingresa un número entero positivo para convertirlo a código binario con el procedimiento paso a paso.</p>

        <form method="POST" action="">
            <div>
                <label for="number">Ingresa un número entero positivo (Base 10):</label>
                <input type="number" id="number" name="number" min="0" value="<?= htmlspecialchars((string)$numberInput) ?>" placeholder="Ej: 13" required>
            </div>

            <button type="submit">Convertir a Binario</button>
        </form>

        <?php if ($result !== null): ?>
            <div class="result-card">
                <h2 class="result-title">Resultado de la Conversión:</h2>
                <p><strong>Número Decimal:</strong> <?= htmlspecialchars((string)$numberInput) ?></p>
                <p><strong>Número Binario:</strong> <span class="result-highlight"><?= htmlspecialchars($result['binary']) ?>₂</span></p>

                <h3 class="result-title">Procedimiento Paso a Paso:</h3>
                <ul>
                    <?php foreach ($result['steps'] as $step): ?>
                        <li><?= $step ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>