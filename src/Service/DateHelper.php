<?php

namespace App\Service;

use DateInterval;
use DatePeriod;
use DateTimeInterface;

/**
 * Class DateHelper.
 *
 * @package App\Service
 */
class DateHelper
{
    /**
     * @param $start
     * @param $end
     * @param string $format
     *
     * @return array
     * @throws \Exception
     */
    public function getDatesFromRange(DateTimeInterface $start, DateTimeInterface $end, string $format = 'Y-m-d'): array
    {
        $dates = [];
        $interval = new DateInterval('P1D');

        $end->add($interval);

        $period = new DatePeriod($start, $interval, $end);

        /** @var \DateTime $date */
        foreach ($period as $date) {
            $dates[] = $date->format($format);
        }

        return $dates;
    }
}
