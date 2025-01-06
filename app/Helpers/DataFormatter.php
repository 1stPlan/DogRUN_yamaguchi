<?php

namespace App\Helpers;

use Carbon\Carbon;

class DataFormatter
{
    public static function zipCodeForInput($zipCode)
    {
        if (isset($zipCode)) {
            return explode('-', $zipCode);
        } else {
            return ['', ''];
        }
    }

    public static function zipCodeForDisplay($zipCode1, $zipCode2)
    {
        if (isset($zipCode1) && isset($zipCode2)) {
            return $zipCode1.'-'.$zipCode2;
        } else {
            return;
        }
    }

    public static function dateTimeFromDateAndTime($date, $time)
    {
        if (isset($date) && isset($time)) {
            $dateCarbon = new Carbon($date);

            return $dateCarbon->format('Y-m-d').' '.$time.':00';
        } else {
            return;
        }
    }
}
