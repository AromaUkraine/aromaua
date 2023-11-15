<?php


namespace Modules\Gallery\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Yajra\DataTables\Services\DataTable;

class EntityGalleryDataTable  extends GalleryDataTable
{
    protected function getActionColumn($data)
    {
        $buttons = null;

        if( request('trash')) {
            if(\Auth::user()->can('module.entity_gallery.restore')){
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' =>'success'
                ])->edit(route('module.entity_gallery.restore',[
                    'page'=>request()->page->id,
                    'table'=>request()->table,
                    'id'=>request()->id,
                    'gallery'=>$data->id
                ]));
            }
        }else{

            if(\Auth::user()->can('module.entity_gallery.edit')){
                $buttons .= DataTableButton::make()->edit(route('module.entity_gallery.edit', [
                    'page'=>request()->page->id,
                    'table'=>request()->table,
                    'id'=>request()->id,
                    'gallery'=>$data->id
                ] ));
            }

            if(\Auth::user()->can('module.entity_gallery.active')) {
                $buttons .= DataTableButton::make()->toggleActive( $data->active , route( 'module.entity_gallery.active', $data->id ));
            }

            if(\Auth::user()->can('module.entity_gallery.destroy')) {

                $buttons .= DataTableButton::make()->delete(route('module.entity_gallery.destroy',   $data->id));
            }

        }



        return $buttons;
    }
}