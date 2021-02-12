<?php

namespace Davidwyly\Lunchnlearn\Model;

use JetBrains\PhpStorm\Pure;

class Fibonacci
{

    /**
     * @param $index
     *
     * @return int
     */
    #[Pure]
    public static function calculateFibValueByIndex($index): int
    {
        if ($index === 0
            || $index === 1
            || $index === -1
        ) {
            return abs($index);
        }

        // we already know the first two numbers of the sequence:
        $second_last = 0;
        $last        = 1;

        $calculated  = 0;
        for ($i = 2; $i <= abs($index); $i++) {
            $calculated  = $last + $second_last;
            $second_last = $last;
            $last        = $calculated;
        }

        if ($index < 0
            && ($index % 2 === 0)
        ) {
            $calculated = $calculated * -1;
        }
        return (int)$calculated;
    }
}