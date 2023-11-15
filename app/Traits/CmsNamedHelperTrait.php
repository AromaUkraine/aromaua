<?php


namespace App\Traits;


trait CmsNamedHelperTrait
{
    public function setName($name)
    {

        // ошибка хранения в переводах (нужно исправить и убрать массивы в переводах)
        if( is_array(__($name)) ) {
            return $name;
        }

        $arr = explode('|', $name);
        $cnt = is_array($arr) ? count($arr) : 0;

        if(!$cnt)
            return;

        if($cnt == 1)
            return __(array_shift($arr));

        if($cnt == 2)
            return trans_choice(array_shift($arr), end($arr));
    }
}
