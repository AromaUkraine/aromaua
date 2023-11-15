<?php


namespace App\Helpers;


class StringHelper
{
    public static function upper($str)
    {
        $str = mb_strtolower($str, 'UTF-8');
        return mb_strtoupper(mb_substr($str, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($str, 1, null, 'UTF-8');
    }


    public function makeMetaphone($str)
    {
        if (strlen($str)) {
            $str = \Transliterate::make($str);
            return metaphone($str);
        }

        return null;
    }
}
