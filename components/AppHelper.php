<?php

namespace app\components;

use DateTime;
use yii\validators\DateValidator;

class AppHelper
{
    public static function convertDateTimeFormat($date, $formatFrom = "d-m-Y H:i", $formatTo = "Y-m-d H:i")
    {
        if (!empty($date)) {

            if (self::isValidDate($date, $formatFrom)) {
                $myDateTime = DateTime::createFromFormat($formatFrom, $date);
                return $myDateTime->format($formatTo);
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

    public static function isValidDate($date, $format)
    {
        $validator = new DateValidator();
        $validator->format = "php:" . $format;
        return $validator->validate($date);
    }
}
?>