<?php


namespace App\Services;


class Configuration
{


    public function save($values, $configFilename = '.env')
    {
        if (empty($values) || !is_array($values)) {
            return false;
        }

        $envFile = base_path($configFilename);
        if (!\File::exists($envFile)) {
            $existingConfig = [];
        } else {
            $existingConfig = file($envFile);
        }

        $configs = [];
        foreach ($existingConfig as $config) {
            if (!empty(str_replace(' ', '', $config))) {
                $config = str_replace([
                    "\r",
                    "\n"
                ], ['', ''], $config);
                $configParts = explode('=', $config, 2);
                if (!empty($configParts[1])) {
                    if (!array_key_exists($configParts[0], $values)) {
                        $configs[] = $configParts[0].'='.$configParts[1];
                    }
                }
            }
        }

        foreach ($values as $key => $value) {
            $value = str_replace('"', '\"', $value);

            if(is_array($values)) {
                $res ='';
                foreach ($values[$key] as $t){
                    $res .= $t.'.';
                }
                $res = substr($res, 0, -1);

                $configs[] = $key.'="'.$res.'"';
            }else{
                if (strpos($values[$key], ' ') !== false) {
                    $configs[] = $key.'="'.$value.'"';
                } else {
                    $configs[] = $key.'='.$value;
                }
            }


        }

        \File::put($envFile, implode("\n", $configs));

        return true;
    }
}
