<?php
require_once 'Node.php';

class BinaryTreeBuilder
{
    public ?Node $root = null;

    // 1. Reconstruir desde Preorden e Inorden
    public function buildFromPreIn(array $preorder, array $inorder): ?Node
    {
        if (empty($preorder) || empty($inorder)) {
            return null;
        }

        $rootValue = $preorder[0];
        $root = new Node($rootValue);

        $rootIndex = array_search($rootValue, $inorder);
        if ($rootIndex === false) return null;

        $leftInorder  = array_slice($inorder, 0, $rootIndex);
        $rightInorder = array_slice($inorder, $rootIndex + 1);

        $leftPreorder  = array_slice($preorder, 1, count($leftInorder));
        $rightPreorder = array_slice($preorder, 1 + count($leftInorder));

        $root->left  = $this->buildFromPreIn($leftPreorder, $leftInorder);
        $root->right = $this->buildFromPreIn($rightPreorder, $rightInorder);

        return $root;
    }

    // 2. Reconstruir desde Inorden y Postorden
    public function buildFromInPost(array $inorder, array $postorder): ?Node
    {
        if (empty($inorder) || empty($postorder)) {
            return null;
        }

        $rootValue = end($postorder);
        $root = new Node($rootValue);

        $rootIndex = array_search($rootValue, $inorder);
        if ($rootIndex === false) return null;

        $leftInorder  = array_slice($inorder, 0, $rootIndex);
        $rightInorder = array_slice($inorder, $rootIndex + 1);

        $leftPostorder  = array_slice($postorder, 0, count($leftInorder));
        $rightPostorder = array_slice($postorder, count($leftInorder), count($rightInorder));

        $root->left  = $this->buildFromInPost($leftInorder, $leftPostorder);
        $root->right = $this->buildFromInPost($rightInorder, $rightPostorder);

        return $root;
    }

    // 3. Reconstruir desde Preorden y Postorden (Árboles estrictamente binarios)
    public function buildFromPrePost(array $preorder, array $postorder): ?Node
    {
        if (empty($preorder) || empty($postorder)) {
            return null;
        }

        $root = new Node($preorder[0]);
        if (count($preorder) === 1) {
            return $root;
        }

        $leftRootValue = $preorder[1];
        $leftSubtreeSize = array_search($leftRootValue, $postorder) + 1;

        $leftPreorder  = array_slice($preorder, 1, $leftSubtreeSize);
        $rightPreorder = array_slice($preorder, 1 + $leftSubtreeSize);

        $leftPostorder  = array_slice($postorder, 0, $leftSubtreeSize);
        $rightPostorder = array_slice($postorder, $leftSubtreeSize, -1);

        $root->left  = $this->buildFromPrePost($leftPreorder, $leftPostorder);
        $root->right = $this->buildFromPrePost($rightPreorder, $rightPostorder);

        return $root;
    }

    // Método para renderizar la estructura gráfica mediante HTML
    public function renderHTML(?Node $node = null): string
    {
        if ($node === null) {
            $node = $this->root;
        }
        if ($node === null) {
            return '';
        }

        $html = '<div class="tree-node-wrapper">';
        $html .= '<div class="tree-node-value">' . htmlspecialchars($node->value) . '</div>';

        if ($node->left !== null || $node->right !== null) {
            $html .= '<div class="tree-children">';
            $html .= '<div class="tree-child left">' . ($node->left ? $this->renderHTML($node->left) : '<div class="tree-empty"></div>') . '</div>';
            $html .= '<div class="tree-child right">' . ($node->right ? $this->renderHTML($node->right) : '<div class="tree-empty"></div>') . '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';
        return $html;
    }
}