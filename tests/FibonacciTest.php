<?php

use PHPUnit\Framework\TestCase;
use Davidwyly\Lunchnlearn\Model\Fibonacci;


class FibonacciTest extends TestCase
{

    public function testCalculateValueByIndex()
    {
        $fixture1 = [0, 1, 1, 2, 3, 5, 8, 13, 21];
        for ($i = 0; $i < count($fixture1); $i++) {
            $this->assertEquals($fixture1[$i], Fibonacci::calculateFibValueByIndex($i), "index: $i");
        }

        $fixture2 = [0, 1, -1, 2, -3, 5, -8, 13, -21];
        for ($i = 0; $i < count($fixture2); $i++) {
            $j = $i * -1;
            $this->assertEquals($fixture2[$i], Fibonacci::calculateFibValueByIndex($j), "index: $j");
        }
    }

    public function testPositiveValues() {
        $fixture1 = [0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987, 1597, 2584, 4181, 6765];
        for ($i = 0; $i < count($fixture1); $i++) {
            $this->assertEquals($fixture1[$i], Fibonacci::calculateFibValueByIndex($i), "index: $i");
        }
    }

    public function testNegativeValues() {
        $fixture2 = [0, 1, -1, 2, -3, 5, -8, 13, -21, 34, -55, 89, -144, 233, -377, 610, -987, 1597];
        for ($i = 0; $i < count($fixture2); $i++) {
            $j = $i * -1;
            $this->assertEquals($fixture2[$i], Fibonacci::calculateFibValueByIndex($j), "index: $j");
        }
    }
}