<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Artisan;

class SynchronizeController extends Controller
{
    public function import()
    {
        if(Artisan::call('web-data:import')){
            sleep(10);
            echo "Синхронизация данных завершена.".PHP_EOL;
        }
    }
}
