<?php
require_once '../classes/BinaryTreeBuilder.php';

$resultHTML = '';
$error = '';

$preorderInput  = $_POST['preorder'] ?? '';
$inorderInput   = $_POST['inorder'] ?? '';
$postorderInput = $_POST['postorder'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preorder  = array_filter(preg_split('/[\s,->]+/', trim($preorderInput)));
    $inorder   = array_filter(preg_split('/[\s,->]+/', trim($inorderInput)));
    $postorder = array_filter(preg_split('/[\s,->]+/', trim($postorderInput)));

    $countProvided = (!empty($preorder) ? 1 : 0) + (!empty($inorder) ? 1 : 0) + (!empty($postorder) ? 1 : 0);

    if ($countProvided < 2) {
        $error = 'Debes ingresar al menos dos recorridos para construir el árbol.';
    } else {
        $builder = new BinaryTreeBuilder();

        // 1. Si ingresa los tres o Preorden + Inorden
        if (!empty($preorder) && !empty($inorder)) {
            $builder->root = $builder->buildFromPreIn($preorder, $inorder);
        } 
        // 2. Inorden + Postorden
        elseif (!empty($inorder) && !empty($postorder)) {
            $builder->root = $builder->buildFromInPost($inorder, $postorder);
        } 
        // 3. Preorden + Postorden
        elseif (!empty($preorder) && !empty($postorder)) {
            $builder->root = $builder->buildFromPrePost($preorder, $postorder);
        }

        if ($builder->root !== null) {
            $resultHTML = $builder->renderHTML();
        } else {
            $error = 'No se pudo construir el árbol con los recorridos ingresados. Revisa que coincida la secuencia de elementos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto 6 - Reconstrucción de Árbol Binario</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="back-link">← Volver al menú principal</a>
        
        <h1>Reconstrucción de Árbol Binario</h1>
        <p class="subtitle-text">Ingresa mínimo dos recorridos para generar la estructura del árbol correspondiente.</p>

        <?php if (!empty($error)): ?>
            <div style="background-color: #ffe6e6; color: #d9534f; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="preorder">Recorrido Preorden:</label>
                <input type="text" id="preorder" name="preorder" value="<?= htmlspecialchars($preorderInput) ?>" placeholder="Ej: A, B, D, E, C">
            </div>

            <div>
                <label for="inorder">Recorrido Inorden:</label>
                <input type="text" id="inorder" name="inorder" value="<?= htmlspecialchars($inorderInput) ?>" placeholder="Ej: D, B, E, A, C">
            </div>

            <div>
                <label for="postorder">Recorrido Postorden:</label>
                <input type="text" id="postorder" name="postorder" value="<?= htmlspecialchars($postorderInput) ?>" placeholder="Ej: D, E, B, C, A">
            </div>

            <button type="submit">Construir Árbol</button>
        </form>

        <?php if (!empty($resultHTML)): ?>
            <div class="result-card">
                <h2 class="result-title">Árbol Reconstruido:</h2>
                <div class="tree-container">
                    <?= $resultHTML ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>