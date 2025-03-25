<?php

namespace App\helpers;

use Carbon\Carbon;

class GlobalFunction
{
    /**
     * Generate an array of dates between the start and end date.
     *
     * @param string $startDate The start date in 'Y-m-d' format.
     * @param string $endDate The end date in 'Y-m-d' format.
     * @param bool $includeToday Whether to include the current date in the range.
     * @return \Carbon\Carbon[] Array of Carbon date objects.
     */
    public static function periodDate($startDate,$endDate,$day = true,$interval='1 day'){
        $begin = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        if($day){
            $end = $end->modify('+1 day');
        }
        $interval = \DateInterval::createFromDateString($interval);
        $period = new \DatePeriod($begin, $interval, $end);
        return $period;
    }

    
    // Add more utility functions as needed.
}
