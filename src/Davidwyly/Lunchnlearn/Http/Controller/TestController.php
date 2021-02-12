<?php

declare(strict_types=1);

namespace Davidwyly\Lunchnlearn\Http\Controller;

use Davidwyly\Lunchnlearn\Http\Controller\Collect;
use Davidwyly\Lunchnlearn\Model\LeadingDigitDistribution;
use Davidwyly\Lunchnlearn\Model\Fibonacci;
use Exception;

class TestController extends Controller
{
    use Collect\Json;
    use Collect\Xml;

    public const FIBONACCI_ITERATIONS = 1000; // warning: do not increase this!

    /**
     * GET {url}/fibonacci
     *
     * @response JSON object
     *
     * @throws Exception
     */
    public function fibonacci()
    {
        try {
            $distribution  = new LeadingDigitDistribution();
            $leadingDigits = [];
            for ($i = 1; $i <= self::FIBONACCI_ITERATIONS; $i++) {
                $fibonacci       = Fibonacci::calculateFibValueByIndex($i);
                $leadingDigit    = LeadingDigitDistribution::getLeadingDigit($fibonacci);
                $leadingDigits[] = $leadingDigit;
                $distribution->assignFrequencyByLeadingDigit($leadingDigit);
            }
            $results = $this->calculateResults($distribution, $leadingDigits);
            $this->renderSuccess($results);
        } catch (Exception $e) {
            $this->renderFail($e);
        }
    }

    /**
     * POST {url}/custom
     *
     * @request  JSON array of integers
     * @response JSON object
     */
    public function custom()
    {
        try {
            $data          = $this->request->post;
            $values        = (array)$data['json'];
            $distribution  = new LeadingDigitDistribution();
            $leadingDigits = [];
            foreach ($values as $key => $value) {
                $leadingDigit    = LeadingDigitDistribution::getLeadingDigit($value);
                $leadingDigits[] = $leadingDigit;
                $distribution->assignFrequencyByLeadingDigit($leadingDigit);
            }
            $results = $this->calculateResults($distribution, $leadingDigits);
            $this->renderSuccess($results);
        } catch (\Exception $e) {
            $this->renderFail($e);
        }
    }

    /**
     * @param $values
     *
     * @return float
     */
    private function standardDeviation($values)
    {
        $count    = count($values);
        $variance = 0.0;

        // calculating mean using array_sum() method
        $average = array_sum($values) / $count;

        foreach ($values as $i) {
            // sum of squares of differences between
            // all numbers and means.
            $variance += pow(($i - $average), 2);
        }

        return (float)sqrt($variance / ($count - 1));
    }

    /**
     *
     * @param $control
     * @param $treatment
     *
     * @return float|int
     */
    private function zScore(array $control, array $treatment)
    {
        $c = $control;
        $t = $treatment;
        $z = ($t[1] / $t[0]) - ($c[1] / $c[0]);
        $s = (($t[1] / $t[0]) * (1 - ($t[1] / $t[0]))) / $t[0] + (($c[1] / $c[0]) * (1 - ($c[1] / $c[0]))) / $c[0];
        return $z / sqrt($s);
    }

    /**
     * @param $zScore
     * @param $numberOfInterest
     * @param $sampleSize
     *
     * @return float|int
     */
    private function marginOfError($zScore, $numberOfInterest, $sampleSize)
    {
        $p = $numberOfInterest / $sampleSize;
        return $zScore * sqrt(($p * (abs(1 - $p))) / $sampleSize);
    }

    /**
     * @param LeadingDigitDistribution $distribution
     * @param array                    $treatment
     *
     * @return array
     * @throws Exception
     */
    private function calculateResults(LeadingDigitDistribution $distribution, array $treatment)
    {
        $control = [];
        for ($i = 1; $i <= 9; $i++) {
            $control[] = LeadingDigitDistribution::getProbabilityFromBenfordsLaw($i);
        }

        $results                       = [];
        $zScore                        = $this->zScore($control, $treatment);
        $results['sample-size']        = count($treatment);
        $results['z-score']            = $zScore;
        $results['standard-deviation'] = $this->standardDeviation($treatment);
        for ($i = 1; $i <= 9; $i++) {
            $actual                                    = $distribution->getDistributionByDigit($i);
            $expected                                  = $control[$i - 1];
            $variance                                  = round($actual - $expected, 6);
            $marginOfError                             = $this->marginOfError(
                $zScore,
                $distribution->{'frequency' . $i},
                $distribution->getTotalCount()
            );
            $results[$i]['expected']                   = round($expected * 100, 4) . '%';
            $results[$i]['actual']                     = round($actual * 100, 4) . '%';
            $results[$i]['variance']                   = round($variance * 100, 4) . '%';
            $results[$i]['margin-of-error']            = round($marginOfError * 100, 4) . '%';
            $results[$i]['conforms-to-benford\'s-law'] = $this->isWithinMarginOfError(
                $expected,
                $actual,
                $marginOfError
            );
        }
        return $results;
    }

    /**
     * @param $expected
     * @param $actual
     * @param $marginOfError
     *
     * @return bool
     */
    private function isWithinMarginOfError($expected, $actual, $marginOfError)
    {
        if ($actual < ($expected + $marginOfError)
            && $actual > ($expected - $marginOfError)
        ) {
            return true;
        }
        return false;
    }
}