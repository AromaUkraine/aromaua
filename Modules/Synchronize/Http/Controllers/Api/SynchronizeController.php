<?php

namespace Modules\Synchronize\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Modules\Synchronize\Events\ApiSynchronizeEvent;

class SynchronizeController extends Controller
{

    /**
     *  Тестовый просмотр процесса синхронизации
     */
    public function test()
    {
        $upload_date = 'demo';

        event(new ApiSynchronizeEvent($upload_date));
    }

    /**
     * Метод для создания в директории public/synchronize директории upload_date по полю filename
     * json-файла и записи в него data
     *
     * @param Request $request
     * @return void
     */
    public function import(Request $request)
    {

        return response()->json([
            'data' => $request->all(),
            'filename' => $request->header('FILENAME'),
            'upload_date' => $request->header('UPLOAD-DATE'),
        ]);
    }

    /**
     * Метод для добавления, обновления записей по дате
     *
     * @return void
     */
    public function start(Request $request)
    {

        $upload_date = $request->header('UPLOAD-DATE') ?? null;

        if($upload_date){

            // event(new ApiSynchronizeEvent($upload_date));
        }
    }
}