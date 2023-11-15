<?php


namespace Modules\Banner\DataTables;


use App\Services\ModelService;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Banner\Entities\Banner;
use Modules\Gallery\Entities\Gallery;
use Yajra\DataTables\Services\DataTable;

class EntityBannerDataTable extends PageBannerDataTable
{

    public function query(){

        $class = app(ModelService::class)->getClassFromTable(request()->table);
        $entity = $class::findOrFail(request()->id);

        $query = Banner::where('bannerable_type', $class)->where('bannerable_id', $entity->id);

        if(request('trash')){
            $query->onlyTrashed();
        }

        $this->query = $query->newQuery();
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if( request('trash')) {
            if(\Auth::user()->can('module.entity_banner.restore')){
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' =>'success'
                ])->edit(route('module.entity_banner.restore', [
                    request()->table,
                    request()->id,
                    $data->id
                ]));
            }
        }else{

            if(\Auth::user()->can('module.entity_banner.edit')){
                $buttons .= DataTableButton::make()->edit(route('module.entity_banner.edit', [
                    request()->table,
                    request()->id,
                    $data->id
                ] ));
            }

            if(\Auth::user()->can('module.entity_banner.active')) {
                $buttons .= DataTableButton::make()->toggleActive( $data->active , route( 'module.entity_banner.active', $data->id ));
            }

            if(\Auth::user()->can('module.entity_banner.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('module.entity_banner.destroy', $data->id));
            }

        }



        return $buttons;
    }
}
