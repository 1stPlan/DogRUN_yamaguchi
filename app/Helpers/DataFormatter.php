<?php

namespace App\Helpers;

use Carbon\Carbon;

class DataFormatter {

    static public function zipCodeForInput($zipCode)
    {
        if (isset($zipCode)) {
            return explode("-", $zipCode);
        } else {
            return ["", ""];
        }
    }

    static public function zipCodeForDisplay($zipCode1, $zipCode2)
    {
        if (isset($zipCode1) && isset($zipCode2)) {
            return $zipCode1 . "-" . $zipCode2;
        } else {
            return null;
        }
    }

    static public function dateTimeFromDateAndTime($date, $time)
    {
        if (isset($date) && isset($time)) {
            $dateCarbon = new Carbon($date);
            return $dateCarbon->format('Y-m-d') . ' ' . $time . ':00';
        } else {
            return null;
        }
    }
}