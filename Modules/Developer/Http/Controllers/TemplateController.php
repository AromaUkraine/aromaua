<?php

namespace Modules\Developer\Http\Controllers;



use App\Models\Component;
use App\Models\PageComponent;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Developer\DataTables\TemplateDataTable;
use Modules\Developer\Entities\Template;

use Modules\Developer\Events\CreateTemplateEvent;
use Modules\Developer\Events\UpdateTemplateEvent;
use Modules\Developer\Service\ModulesService;

class TemplateController extends Controller
{

    public function index(TemplateDataTable $dataTable)
    {
        return $dataTable->render('developer::template.index');
    }


    public function create()
    {

        $module = null;
        $modules = app(ModulesService::class)->getModules();
        $widgets['available'] = app(ModulesService::class)->getWidgets()->toArray();

        return view('developer::template.create', compact('module','modules', 'widgets'));
    }


    public function store(Request $request)
    {
        event(new CreateTemplateEvent($request->all()));

        toastr()->success(__('toastr.created.message'));

        return redirect(route('developer.template.index'));
    }


    public function edit(Template $template)
    {

        $modules = app(ModulesService::class)->getModules();
        $widgets_collection = app(ModulesService::class)->getWidgets();


        $module = collect($template->components)->where('type',PageComponent::TYPE_MODULE)->first();
        $used_widgets = collect($template->components)->where('type',PageComponent::TYPE_WIDGET);

        if($used_widgets){
            $widgets['available'] = $widgets_collection->whereNotIn('alias', $used_widgets->pluck('alias'))->toArray();
            $widgets['used'] = $used_widgets->toArray();
        }else{
            $widgets['available'] = $widgets_collection->toArray();
            $widgets['used'] = [];
        }

        return view('developer::template.edit', compact('template','module','modules','widgets'));
    }

    /**
     * @param Request $request
     * @param Template $template
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Template $template)
    {

        try{
            \DB::beginTransaction();

            event(new UpdateTemplateEvent($request->all(), $template));
            toastr()->success(__('toastr.updated.message'));

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd('Update failed with class "'.get_class($this).'" error : '.$e->getMessage());
        }
        return redirect(route('developer.template.index'));
    }

}
