<?php

namespace App\Base\Traits;


/**
 * Displays time formatting
 * using carbon
 */
trait timing
{

    /**
     * summary date and time
     * rolling up to seconds, minutes, hours, days, months, years
     *
     * @param object $time
     * @return string
     */
    public function summaryDateTime(object $time)
    {
        return $time->diffForHumans();
    }

    /**
     * long date and time
     * 'Tuesday, July 23, 2019 2:51 PM'
     *
     * @param object $time
     * @return string
     */
    public function longDateTime(object $time)
    {
        return $time->isoFormat('LLLL');
        // Carbon::parse('2019-07-23 14:51')->isoFormat('LLLL');
    }
}
