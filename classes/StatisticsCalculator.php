<?php

class StatisticsCalculator
{
    private array $numbers;

    public function __construct(array $numbers)
    {
        // Filtramos para asegurar que solo procesemos valores numéricos
        $this->numbers = array_map('floatval', array_filter($numbers, 'is_numeric'));
    }

    // 1. Calcular Promedio (Media Aritmética)
    public function getAverage(): float
    {
        $count = count($this->numbers);
        if ($count === 0) {
            return 0.0;
        }

        return array_sum($this->numbers) / $count;
    }

    // 2. Calcular Mediana
    public function getMedian(): float
    {
        $count = count($this->numbers);
        if ($count === 0) {
            return 0.0;
        }

        $sorted = $this->numbers;
        sort($sorted); // Ordenamos de menor a mayor

        $middle = (int)floor($count / 2);

        // Si la cantidad es impar, tomamos el centro
        if ($count % 2 !== 0) {
            return $sorted[$middle];
        }

        // Si la cantidad es par, promediamos los dos valores del centro
        return ($sorted[$middle - 1] + $sorted[$middle]) / 2;
    }

    // 3. Calcular Moda
    public function getMode(): string
    {
        if (empty($this->numbers)) {
            return 'No ingresó números válidos';
        }

        // Contamos la frecuencia de cada número
        // Convertimos a string para usar array_count_values con números flotantes
        $stringValues = array_map(function($val) {
            return (string)$val;
        }, $this->numbers);

        $frequencies = array_count_values($stringValues);
        $maxFrequency = max($frequencies);

        // Si la frecuencia máxima es 1, no hay repeticiones
        if ($maxFrequency === 1) {
            return 'No hay moda (ningún número se repite)';
        }

        // Obtenemos los números que tienen la frecuencia máxima
        $modes = array_keys($frequencies, $maxFrequency);

        return implode(', ', $modes) . " (se repite {$maxFrequency} veces)";
    }
}