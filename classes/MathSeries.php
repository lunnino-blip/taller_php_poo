<?php
class MathSeries{

    private int $number;
 
    public function __construct(int $number){

        $this->number = max(0, $number);

    }

    public function getFibonacci(): array {

        if ($this->number == 0){
            return [0];
        }

         $series =[0, 1];

         for ($i = 2; $i <= $this->number; $i++){
         $series[] =$series[$i - 1] + $series[$i -2];
        }
   
         return array_slice($series, 0, $this->number + 1);
    }

    public function getFactorial(): array{

        if ($this->number == 0 || $this->number == 1){
            return [
                'result' => 1,
                'stops' => '1 = 1'
            ];
        }

        $factorial = 1;
        $steps = [];

        for($i = $this->number; $i >= 1; $i--){
            $factorial *= $i;
            $steps[] = $i;

        }

        return [
            'result' => $factorial,
            'steps' => implode(' × ', $steps) . ' = ' . number_format($factorial, 0, '', '.')

        ];
    }
    
}

    

