<?php

class BinaryConverter
{
    private int $decimalNumber;

    public function __construct(int $number)
    {
        // Garantizamos que no se procesen números negativos
        $this->decimalNumber = max(0, $number);
    }

    public function convertToBinary(): array
    {
        if ($this->decimalNumber === 0) {
            return [
                'binary' => '0',
                'steps'  => ['0 ÷ 2 = 0, residuo: 0']
            ];
        }

        $currentNumber = $this->decimalNumber;
        $remainderStack = [];
        $steps = [];

        while ($currentNumber > 0) {
            $quotient = (int)floor($currentNumber / 2);
            $remainder = $currentNumber % 2;

            $steps[] = "{$currentNumber} ÷ 2 = {$quotient}, residuo: <strong>{$remainder}</strong>";
            
            // Guardamos el residuo en la lista
            $remainderStack[] = $remainder;

            $currentNumber = $quotient;
        }

        // Invertimos el arreglo de residuos para obtener el orden binario correcto
        $binaryResult = implode('', array_reverse($remainderStack));

        return [
            'binary' => $binaryResult,
            'steps'  => $steps
        ];
    }
}