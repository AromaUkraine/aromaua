<?php


namespace Modules\Banner\Http\Controllers\Cms;


use App\Events\DestroyEntityEvent;
use App\Http\Controllers\Controller;
use App\Services\ModelService;
use App\Services\PublishAttribute;
use Modules\Banner\DataTables\EntityBannerDataTable;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Http\Requests\BannerRequest;
use Modules\Banner\Http\Requests\EntityBannerRequest;

class EntityBannerController extends Controller
{


    public function index($table, $id, EntityBannerDataTable $dataTable)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return $dataTable->render('banner::cms.entity_banner.index', compact('table', 'id', 'entity'));
    }


    public function create($table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('banner::cms.entity_banner.create', compact('table','id', 'entity'));
    }

    public function store(EntityBannerRequest $request, $table, $id)
    {

        // подготавливаем данные для сохранения
        $data = app(PublishAttribute::class)->make($request);

        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        if(method_exists($entity, 'entity_banner')):
            $entity->entity_banner()->create($data);
        endif;

        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.entity_banner.index',[$table, $id]));
    }


    public function edit($table, $id, Banner $banner)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('banner::cms.entity_banner.edit',compact('table','id', 'type', 'entity', 'banner'));
    }



    public function update(EntityBannerRequest $request, $table, $id, Banner $banner)
    {

        // подготавливаем данные для сохранения
        $data = app(PublishAttribute::class)->make($request);

        $banner->update($data);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.entity_banner.index',[$table, $id]));
    }


    /**
     * Enabled / disabled article
     * @param Banner $banner
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Banner $banner)
    {
        $banner->update(['active'=>!$banner->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }



    public function destroy(Banner $banner)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($banner, config('banner.softDelete') ?? false));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }


    public function restore( $table, $id, $item_id)
    {
        $banner = Banner::withTrashed()->findOrFail($item_id);
        $banner->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.entity_banner.index',[$table, $id]));
    }
}
