<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function toLocalTime($timeString, $timezone)
    {
        if (empty($timeString)) {
            return 'N/A';
        }

        try {
            return Carbon::parse($timeString)
                ->setTimezone($timezone)
                ->format('h:i A');
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}