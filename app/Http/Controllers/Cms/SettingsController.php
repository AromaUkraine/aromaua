<?php

namespace App\Http\Controllers\Cms;

use App\DataTables\SettingsDataTable;
use App\Events\SettingUpdateEvent;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use App\Models\Role;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $roles = [];

    public function __construct()
    {
        $this->roles = [Role::DEVELOPER_ROLE];
    }
    /**
     * Display a listing of the resource.
     *
     * @param SettingsDataTable $dataTable
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(SettingsDataTable $dataTable)
    {
        return $dataTable->render('cms.settings.index', with(['roles'=>$this->roles]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        if(!$request->user()->hasRole($this->roles)) {
            abort(403);
        }
        return view('cms.settings.create')->with(['roles'=>$this->roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SettingsRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(SettingsRequest $request)
    {
        if(!$request->user()->hasRole($this->roles)) {
            abort(403);
        }

        Settings::create($request->all());

        toastr()->success(__('toastr.created.message'));

        return redirect(route('root.settings.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Settings $setting
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit( Settings $setting)
    {
        return view('cms.settings.edit', compact('setting'))->with(['roles'=>$this->roles]);
    }

    /**
     * Update the specified resource in storage.
     * @param SettingsRequest $request
     * @param Settings $setting
     */
    public function update(SettingsRequest $request, Settings $setting)
    {

        event(new SettingUpdateEvent($request, $setting));

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('root.settings.index'));
    }

    public function destroy(Settings $settings)
    {
        $settings->delete();
        toastr()->success( __('toastr.deleted.message') );
        return response()->json(['status' => 'ok']);
    }
}
