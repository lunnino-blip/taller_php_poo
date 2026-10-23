<?php

class SetOperations
{
    private array $setA;
    private array $setB;

    public function __construct(array $setA, array $setB)
    {
        // 1. Filtrar solo números enteros válidos
        // 2. array_unique para garantizar la propiedad matemática de los conjuntos (no duplicados internos)
        $this->setA = array_values(array_unique(array_map('intval', array_filter($setA, 'is_numeric'))));
        $this->setB = array_values(array_unique(array_map('intval', array_filter($setB, 'is_numeric'))));
    }

    // 1. Unión (A ∪ B)
    public function getUnion(): array
    {
        $union = array_merge($this->setA, $this->setB);
        $result = array_unique($union);
        sort($result);
        return array_values($result);
    }

    // 2. Intersección (A ∩ B)
    public function getIntersection(): array
    {
        $intersection = array_intersect($this->setA, $this->setB);
        sort($intersection);
        return array_values($intersection);
    }

    // 3. Diferencia A - B
    public function getDifferenceAB(): array
    {
        $diff = array_diff($this->setA, $this->setB);
        sort($diff);
        return array_values($diff);
    }

    // 4. Diferencia B - A
    public function getDifferenceBA(): array
    {
        $diff = array_diff($this->setB, $this->setA);
        sort($diff);
        return array_values($diff);
    }

    // Método auxiliar para formatear la salida como conjunto matemático: {1, 2, 3}
    public function formatSet(array $set): string
    {
        if (empty($set)) {
            return '∅ (Conjunto Vacío)';
        }
        return '{ ' . implode(', ', $set) . ' }';
    }
}