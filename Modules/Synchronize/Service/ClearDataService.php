<?php

namespace Modules\Synchronize\Service;

class ClearDataService
{

    public function make($item, $implode = [])
    {
        $data = [];

        if(count($implode) > 0) {
            foreach($implode as $section){
                if(isset($item[$section])){
                    $data[$section] = $item[$section];
                }
            }
        }else{

            foreach ($item as $key => $value) {

                if (!is_array($value)) {
                    $value = trim($value);
                    $data[$key] = strip_tags($value);
                } else {
                    $data[$key] = $value;
                }
            }

        }
        return $data;
    }
}