<?php

namespace Modules\Synchronize\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Modules\Synchronize\DataTables\LogDataTable;
use Modules\Synchronize\Entities\SynchronizeLog;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // $query = SynchronizeLog::query();

        // if ($request->has('datetime')) {
        //     $query->where('datetime', $request->datetime);
        // } else {
        //     $query->latest();
        // }

        // $test = $query->first();

        // dump("<pre>".print_r($test->context)."</pre>");
        // dd($test);

        if ($request->ajax()) {

            $query = SynchronizeLog::query();

            if ($request->has('datetime')) {
                $query->where('datetime', $request->datetime)
                    ->latest();
            } else {
                $query->latest();
            }

            return Datatables::of($query->get())
                ->addIndexColumn()
                ->editColumn('message', function ($data) {
                    return $data->message; //;json_decode($data->message, true);
                })
                ->addColumn('context', function ($data) {
                    return "<pre id='json'>".json_encode($data->context, JSON_UNESCAPED_UNICODE)."</pre>";
                })
                ->rawColumns(['context'])
                ->make(true);
        }

        return view('synchronize::log.index');
    }


    public function destroy(Request $request)
    {
        DB::table($this->getTable(SynchronizeLog::class))->truncate();
        $this->setAutoIncrement(SynchronizeLog::class, 0);
        return response()->json(['message' => __('toastr.deleted.message')]);
    }

    protected function getTable($class)
    {
        return (new $class)->getTable();
    }

    protected function setAutoIncrement($class, $value)
    {
        \DB::statement("ALTER TABLE {$this->getTable($class)} AUTO_INCREMENT = {$value};");
    }
}
