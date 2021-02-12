<?php

namespace Davidwyly\Lunchnlearn\Model;

class FibonacciTrial
{

    public static function calculateFibValueByIndex($index): int|string
    {
        // handle the first 2 numbers in the sequence manually, then assign

        $second_to_last_value = 0;
        $last_value           = 1;

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
            $calculated  = gmp_add($last, $second_last);
            $second_last = $last;
            $last        = $calculated;
        }

        if ($index < 0
            && ($index % 2 === 0)
        ) {
            $calculated = $calculated * -1;
        }
        return $calculated;
    }
}