<?php

namespace Modules\Backup\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Modules\Backup\Services\BackupService;
use Illuminate\Contracts\Support\Renderable;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Backup\Services\ArchiveService;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {


        if ($request->ajax()) {

            $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
            $dir_name = app(ArchiveService::class)->getDirName();
            $backups = app(BackupService::class)->getBackups($disk, $dir_name);


            $data = [];
            foreach ($backups as $key => $backup) {
                $data[$key] = [
                    'id' => ++$key,
                    'file_name' => $backup['file_name'],
                    'file_size' => $backup['human_file_size'],
                    'created_date' => date('F jS, Y, g:ia (T)', $backup['last_modified']),
                    'created_age' => \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans(),
                ];
            }

            return Datatables::of($data)
                ->addColumn('action', function ($data) {
                    return $this->getActionColumn($data);
                })
                ->make(true);
        }

        return view('backup::index');
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (\Auth::user()->can('root.backup.destroy')) {
            $buttons .= DataTableButton::make()->delete(route('root.backup.destroy',  $data['file_name']));
        }


        return $buttons;
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        try {
            /* only database backup*/
            Artisan::call('backup:db');

            toastr()->success(__('toastr.created.message'));
            return redirect()->back();
        } catch (Exception $e) {

            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('backup::edit');
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($file_name)
    {

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $dir_name = app(ArchiveService::class)->getDirName();
        $backups = app(BackupService::class)->getBackups($disk, $dir_name);

        $file_path = null;
        foreach ($backups as $backup) {
            if ($backup['file_name'] == $file_name) {
                $file_path = $backup['file_path'];
            }
        }

        if ($disk->exists($file_path)) {

            $disk->delete($file_path);
            toastr()->success(__('toastr.deleted.message'));
            return redirect()->back();
        } else {
            abort(404, "Backup file doesn't exist.");
        }
    }
}
