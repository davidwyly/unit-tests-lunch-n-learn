<?php

namespace Davidwyly\Lunchnlearn\Model;

use Exception;

class LeadingDigitDistribution
{
    public int $frequency1 = 0;
    public int $frequency2 = 0;
    public int $frequency3 = 0;
    public int $frequency4 = 0;
    public int $frequency5 = 0;
    public int $frequency6 = 0;
    public int $frequency7 = 0;
    public int $frequency8 = 0;
    public int $frequency9 = 0;

    /**
     * @param $value
     *
     * @return false|string
     */
    public static function getLeadingDigit($value)
    {
        return substr((string)$value, 0, 1);
    }

    /**
     * @param $digit
     *
     * @return false|float
     * @throws Exception
     */
    public static function getProbabilityFromBenfordsLaw($digit)
    {
        if (!is_int($digit)) {
            throw new Exception("Not a digit");
        }
        if ($digit < 0 || $digit > 9) {
            throw new Exception("Invalid range");
        }
        return round(log10(1 + (1 / $digit)), 6);
    }

    /**
     * @param $leadingDigits
     *
     * @throws Exception
     */
    public function assignFrequencyByLeadingDigits($leadingDigits): void
    {
        foreach ($leadingDigits as $leadingDigit) {
            $this->assignFrequencyByLeadingDigit($leadingDigit);
        }
    }

    /**
     * @param $leadingDigit
     *
     * @throws Exception
     */
    public function assignFrequencyByLeadingDigit($leadingDigit): void
    {
        switch ($leadingDigit) {
            case 1:
                $this->frequency1++;
                break;
            case 2:
                $this->frequency2++;
                break;
            case 3:
                $this->frequency3++;
                break;
            case 4:
                $this->frequency4++;
                break;
            case 5:
                $this->frequency5++;
                break;
            case 6:
                $this->frequency6++;
                break;
            case 7:
                $this->frequency7++;
                break;
            case 8:
                $this->frequency8++;
                break;
            case 9:
                $this->frequency9++;
                break;
            case 0:
                // do nothing;
                break;
            default:
                throw new Exception("Cannot process leading digit");
        }
    }


    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->frequency1 + $this->frequency2 + $this->frequency3 + $this->frequency4 + $this->frequency5
            + $this->frequency6 + $this->frequency7 + $this->frequency8 + $this->frequency9;
    }

    /**
     * @param $digit
     *
     * @return int
     * @throws Exception
     */
    public function getDigitCount($digit)
    {
        switch ($digit) {
            case 1:
                return $this->frequency1;
                break;
            case 2:
                return $this->frequency2;
                break;
            case 3:
                return $this->frequency3;
                break;
            case 4:
                return $this->frequency4;
                break;
            case 5:
                return $this->frequency5;
                break;
            case 6:
                return $this->frequency6;
                break;
            case 7:
                return $this->frequency7;
                break;
            case 8:
                return $this->frequency8;
                break;
            case 9:
                return $this->frequency9;
                break;
            case 0:
                // do nothing;
                break;
            default:
                throw new Exception("Cannot process leading digit");
        }
    }

    /**
     * @param $digit
     *
     * @return float
     * @throws Exception
     */
    public function getDistributionByDigit($digit): float
    {
        $totalCount = $this->getTotalCount();
        $digitCount = $this->getDigitCount($digit);
        return round($digitCount / $totalCount, 6);
    }
}