<?php

use Davidwyly\Lunchnlearn\Model\LeadingDigitDistribution;
use PHPUnit\Framework\TestCase;


class LeadingDigitDistributionTest extends TestCase
{

    public function testGetLeadingDigit() {
        $fixture = [
            12345 => 1,
            34567 => 3,
            56789 => 5,
            78901 => 7,
        ];
        foreach ($fixture as $value => $expected) {
            $this->assertEquals($expected, LeadingDigitDistribution::getLeadingDigit($value));
        }
    }

    public function testGetProbabilityFromBenfordsLaw() {
        $fixture = [
            1 => 0.301030,
            2 => 0.176091,
            3 => 0.124939,
            4 => 0.096910,
            5 => 0.079181,
            6 => 0.066947,
            7 => 0.057992,
            8 => 0.051153,
            9 => 0.045757,
        ];
        foreach ($fixture as $digit => $expected) {
            try {
                $this->assertEquals($expected, LeadingDigitDistribution::getProbabilityFromBenfordsLaw($digit));
            } catch (Exception $e) {
                $this->fail($e->getMessage());
            }
        }
    }
}