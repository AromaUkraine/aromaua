<?php

namespace App\DataTables;


use App\Models\Role;
use App\Services\SettingsService;
use App\Services\TranslateOrDefaultService;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Developer\Entities\Template;
use Yajra\DataTables\Services\DataTable;
use App\Models\Page;

class PageDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    private $query;


    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns = [
        [
            'data' => 'id',
            'name' => 'id',
            'title' => '#'
        ],
        [
            'data' => 'status',
            'title' => 'cms.page_status',
        ],
        [
            'data' => 'name',
            'title' => 'cms.page_name',
        ],
        [
            'data' => 'module',
            'title' => 'cms.page_module',
        ],
        [
            'data' => 'widgets',
            'title' => 'cms.page_widgets',
        ],
    ];




    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query()
    {
        $this->query = Page::with(['modules', 'widgets'])
            ->where('pageable_type', Template::class)
            //            ->withTranslation()
            ->newQuery();
    }


    public function dataTable()
    {

        return datatables()
            ->eloquent($this->query)
            ->addColumn('status', function ($data) {
                if (!$data->slug) :
                    return $this->badge('', 'danger', "<i data-toggle='tooltip' title='" . __('cms.page_not_created') . "'  class='fas fa-times'></i>"); //__('page');
                else :
                    return $this->badge('', 'success', "<i data-toggle='tooltip' title='" . __('cms.page_created') . "' class='fas fa-check'></i>");
                endif;
            })
            ->addColumn('name', function ($data) {
                return app(TranslateOrDefaultService::class)->get($data, 'name'); //app(SettingsService::class)->getTranslateOrDefault($data, true);//$data->translate(app()->getLocale(), true)->name ;
            })
            ->addColumn('module', function ($data) {
                $names = $data->modules->map(function ($item) {
                    return $item->name;
                });
                $list = '';
                if ($names) {
                    foreach ($names as $name) {
                        $list .= "<div class=\"badge badge-pill badge-light-secondary mr-1 mb-1\">{$name}</div>";
                    }
                }
                return $list;
            })
            ->addColumn('widgets', function ($data) {

                $names = $data->widgets->map(function ($item) {
                    return $item->name;
                });
                $list = '';
                if ($names) {
                    foreach ($names as $name) {
                        $list .= "<div class=\"badge badge-pill badge-light-secondary mr-1 mb-1\">{$name}</div>";
                    }
                }
                return $list;
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['status', 'module', 'widgets', 'action']);
    }



    protected function getActionColumn($data)
    {
        $buttons = null;
        /**** dev buttons ****/
        if (\Auth::user()->role()->slug == Role::DEVELOPER_ROLE) :

            if (\Auth::user()->can('module.page_component.index')) {
                $buttons .= DataTableButton::make([
                    'icon' => 'fa fa-list',
                    'name'=>trans_choice('cms.widget', 2)])
                    ->edit(route('module.page_component.index', $data->id));
            }

            if (\Auth::user()->can('developer.page.edit')) :
                $buttons .= DataTableButton::make()->edit(route('developer.page.edit', $data->id));
            endif;

            if (\Auth::user()->can('developer.page.active') && $data->slug) :
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('developer.page.active', $data->id));
            else :
                $buttons .= DataTableButton::make(['class' => 'danger', 'icon' => 'bx bx-hide'])->disabled()->edit();
            endif;

            if (\Auth::user()->can('developer.page.destroy')) :
                $buttons .= DataTableButton::make()->delete(route('developer.page.destroy', $data->id));
            endif;

            /**** another ****/
        else :


            if (\Auth::user()->can('module.page_component.index')) {
                $buttons .= DataTableButton::make(['icon' => 'fa fa-list',])->edit(route('module.page_component.index', $data->id));
            }

            if (\Auth::user()->can('section.section.edit')) {
                $buttons .= DataTableButton::make()->edit(route('section.section.edit', $data->id));
            }


            if (\Auth::user()->can('section.section.active') && $data->slug) {
                // отключаем возможность изменять главную страницу
                if ($data->pageable->is_main) {
                    $buttons .= DataTableButton::make(['class' => 'success'])->disabled()->toggleActive();
                } else {
                    $buttons .= DataTableButton::make()->toggleActive($data->active, route('section.section.active', $data->id)); //'admin.'.$key.'.active'.'||'.$data->page->active;//
                }
            } else {
                $buttons .= DataTableButton::make(['class' => 'danger', 'icon' => 'bx bx-hide'])->disabled()->edit();
            }

            if (\Auth::user()->can('section.section.destroy')) {
                // отключаем возможность изменять главную страницу
                if ($data->pageable->is_main) {
                    $buttons .= DataTableButton::make(['class' => 'danger'])->disabled()->delete();
                } else {
                    // test delete page and all related
                    //                $buttons .= '<form action="'.route('section.section.destroy', $data->id).'" method="post">
                    //                    '.csrf_field().method_field('DELETE').'
                    //                    <button type="submit">delete</button>
                    //                </form>';
                    $buttons .= DataTableButton::make()->delete(route('section.section.destroy', $data->id));
                }
            }


        endif;






        return $buttons;
    }
}
