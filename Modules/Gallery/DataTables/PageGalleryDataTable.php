<?php


namespace Modules\Gallery\DataTables;


use App\Services\ModelService;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Gallery\Entities\Gallery;

class PageGalleryDataTable extends GalleryDataTable
{

    public function query(){

        $query = Gallery::where('parent_page_id', request()->page->id)
            ->withPageComponent(request()->page_component->alias);

        if(request('trash')){
            $query->onlyTrashed();
        }

        $this->query = $query->newQuery();
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {
            if (\Auth::user()->can('module.page_gallery.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('module.page_gallery.restore', $data->id));
            }
        } else {

            if (\Auth::user()->can('module.page_gallery.edit')) {
                $buttons .= DataTableButton::make()->edit(route('module.page_gallery.edit', [
                    request()->page->id,
                    $data->component->alias,
                    $data->id
                ]));
            }

            if (\Auth::user()->can('module.page_gallery.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('module.page_gallery.active', $data->id));
            }

            if (\Auth::user()->can('module.page_gallery.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('module.page_gallery.destroy', $data->id));
            }

        }


        return $buttons;
    }
}
