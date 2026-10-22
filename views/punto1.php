<?php

require_once '../classes/AcronymGenerator.php';

$result = '';
$inputText = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
   
    $inputText = trim($_POST['text']);
    
    if (!empty($inputText)) {
        
        $generator = new AcronymGenerator($inputText);
        $result = $generator->generate();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 1 - Generador de Acrónimos</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="back-link">← Volver al menú principal</a>
        
        <h1>Generador de Acrónimos</h1>
        <p class="subtitle-text">Convierte cualquier nombre largo o frase en su acrónimo correspondiente.</p>

        <form method="POST" action="">
            <div>
                <label for="text">Ingresa una frase:</label>
                <input type="text" id="text" name="text" value="<?= htmlspecialchars($inputText) ?>" placeholder="Ej: Portable Network Graphics" required>
            </div>
            
            <button type="submit">Generar Acrónimo</button>
        </form>

        <?php if ($result !== ''): ?>
            <div class="result-card">
                <h2 class="result-title">Resultado:</h2>
                <p><strong>Frase ingresada:</strong> <?= htmlspecialchars($inputText) ?></p>
                <p><strong>Acrónimo:</strong> <span class="result-highlight"><?= htmlspecialchars($result) ?></span></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>     
