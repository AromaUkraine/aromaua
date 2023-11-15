<?php


namespace App\Helpers;


class ArrayHelper
{


    /**
     * Поиск по многомерному массиву
     *
     * @param $array - массив
     * @param $key - ключ в массиве
     * @param $value - значение которое необходимо найти по ключу
     * @return array
     */
    public static function multiArraySearch($array, $key, $value)
    {
        $results = [];

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, self::multiArraySearch($subarray, $key, $value));
            }
        }

        return $results;
    }


    /**
     * @param array $arr
     * @param null $is_count
     * @return bool|int
     */
    public static function cnt($arr, $is = NULL)
    {
        $count = (is_array($arr) or is_object($arr)) ? count($arr) : 0;

        return (!is_null($is)) ? ((int)$count === (int)$is) : $count;
    }

    public static function multiDiff($array1, $array2)
    {
        $result = array();
        foreach($array1 as $key => $val) {
            if(isset($array2[$key])){
                if(is_array($val) && $array2[$key]){
                    $result[$key] = self::multiDiff($val, $array2[$key]);
                }
            } else {
                $result[$key] = $val;
            }
        }

        return $result;
    }

}
