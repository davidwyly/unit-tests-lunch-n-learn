<?php

use PHPUnit\Framework\TestCase;
use Davidwyly\Lunchnlearn\Model\FibonacciTrial;


class FibonacciTrialTest extends TestCase
{
    public function testIndexIsOne() {
        $this->assertEquals(0, FibonacciTrial::calculateFibValueByIndex(0));
    }

    public function testIndexIsZero() {
        $this->assertEquals(1, FibonacciTrial::calculateFibValueByIndex(1));
    }

    public function testIndexIsNegativeOne() {
        $this->assertEquals(1, FibonacciTrial::calculateFibValueByIndex(1));
    }

    public function testExpectedValues() {
        $fixture1 = [0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987, 1597, 2584, 4181, 6765];
        for ($i = 0; $i < count($fixture1); $i++) {
            $this->assertEquals($fixture1[$i], FibonacciTrial::calculateFibValueByIndex($i), "index: $i");
        }
    }

    public function testNegativeValues() {
        $fixture2 = [0, 1, -1, 2, -3, 5, -8, 13, -21, 34, -55, 89, -144, 233, -377, 610, -987, 1597];
        for ($i = 0; $i < count($fixture2); $i++) {
            $j = $i * -1;
            $this->assertEquals($fixture2[$i], FibonacciTrial::calculateFibValueByIndex($j), "index: $j");
        }
    }

    public function testReallyHighIndex() {
        $this->assertEquals(3736710778780516352, FibonacciTrial::calculateFibValueByIndex(100));
    }

}