<?php

namespace Modules\Developer\Http\Controllers;

use App\Helpers\ArrayHelper;
use App\Models\Component;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Developer\DataTables\ModuleDataTable;
use Modules\Developer\Entities\Template;
use Modules\Developer\Http\Requests\ModuleRequest;
use Modules\Developer\Service\ModulesService;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param ModuleDataTable $dataTable
     * @return Renderable
     */
    public function index( ModuleDataTable $dataTable )
    {
        return $dataTable->render('developer::module.index');
    }

    public function create($alias=null)
    {

        $module = [];
        $modules = app(ModulesService::class)->getPageComponents();

        $types = $modules->unique('type')->map(function ($array) {
            return $array['type'];
        });

        if ($alias) {
            $module = $modules->where('alias', $alias)->first();
        }


        return view('developer::module.create', compact('types', 'modules', 'module'));
    }


    /**
     * Show the form for creating a new resource.
     * @param ModuleRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ModuleRequest $request)
    {

        $data = $request->all();

        foreach ($data['data'] as $key=>$value){
            $data['data'][$key] = json_decode($value, true);
        }

        Component::create($data);

        return redirect( route('developer.module.index'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Component $module
     * @return Renderable
     */
    public function edit(Component $module)
    {
        return view('developer::module.edit', compact('module'));
    }


    /**
     * Update the specified resource in storage.
     * @param ModuleRequest $request
     * @param Component $module
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ModuleRequest $request, Component $module)
    {
        $data = $request->all();

        foreach ($data['data'] as $key=>$value)
        {

            $data['data'][$key] = json_decode($value, true);
        }

        $module->update($data);

        return redirect( route('developer.module.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
