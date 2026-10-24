<?php

class Calculator
{
    private float $num1;
    private float $num2;
    private string $operation;

    public function __construct(float $num1, float $num2, string $operation)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;
        $this->operation = $operation;
    }

    public function calculate(): array
    {
        $result = 0;
        $symbol = '';

        switch ($this->operation) {
            case 'add':
                $result = $this->num1 + $this->num2;
                $symbol = '+';
                break;
            case 'subtract':
                $result = $this->num1 - $this->num2;
                $symbol = '-';
                break;
            case 'multiply':
                $result = $this->num1 * $this->num2;
                $symbol = '×';
                break;
            case 'divide':
                if ($this->num2 == 0) {
                    return [
                        'error' => 'Error: No se puede dividir entre cero.',
                        'entry' => null
                    ];
                }
                $result = $this->num1 / $this->num2;
                $symbol = '÷';
                break;
            case 'percentage':
                // Calcula el num2% de num1 (ej: 200 * 15% = 30)
                $result = ($this->num1 * $this->num2) / 100;
                $symbol = '% de';
                break;
            default:
                return [
                    'error' => 'Operación no válida.',
                    'entry' => null
                ];
        }

        $formattedResult = is_float($result) ? round($result, 4) : $result;
        $historyEntry = "{$this->num1} {$symbol} {$this->num2} = {$formattedResult}";

        return [
            'error'  => null,
            'result' => $formattedResult,
            'entry'  => $historyEntry
        ];
    }
}