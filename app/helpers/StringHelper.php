<?php
namespace app\helpers;

/**
 * Содержит полезные функции для работы с текстом
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */
class StringHelper
{
    public static function getNumEnding($number, $endings = array('', 'a', 'ов'))
    {
        $number = $number % 100;
        if ($number >= 11 && $number <= 19)
            $ending = $endings[2];
        else {
            $i = $number % 10;
            switch ($i) {
                case (1):
                    $ending = $endings[0];
                    break;
                case (2):
                case (3):
                case (4):
                    $ending = $endings[1];
                    break;
                default:
                    $ending = $endings[2];
            }
        }
        return $ending;
    }
}
