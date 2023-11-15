<?php


namespace Modules\Gallery\DataTables;


use App\Services\ModelService;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Gallery\Entities\Gallery;
use Yajra\DataTables\Services\DataTable;

class GalleryDataTable  extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    protected $query;

    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns = [
        [
            'data' => 'order',
            'title' => '#',
            'orderable' => false
        ],

        [
            'data' => 'image',
            'title' => 'cms.gallery_image',
        ],
        [
            'data' => 'name',
            'name' => 'name',
            'title' => 'cms.gallery_name',
        ],
        //        [
        //            'data' => 'alt',
        //            'name'=>'alt',
        //            'title' => 'gallery.alt',
        //        ],
        //        [
        //            'data' => 'alt',
        //            'title' => 'gallery.in_preview',
        //        ],
        [
            'data' => 'type',
            'name' => 'type',
            'title' => 'cms.gallery_type',
        ],
    ];

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => Gallery::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {

        $class = app(ModelService::class)->getClassFromTable(request()->table);
        $entity = $class::findOrFail(request()->id);

        $query = Gallery::where('galleriable_type', $class)->where('galleriable_id', $entity->id);

        if (request('trash')) {
            $query->onlyTrashed();
        }

        $this->query = $query->newQuery();
    }

    public function dataTable()
    {

        $datatable = datatables()->eloquent($this->query);

        /** добавлено для сортировки **/
        if ($this->totalCount > 1) {

            $datatable
                ->setRowClass('row-sort')
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ]);
        }

        return $datatable
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {

                    //                    $query->join('gallery_translations', function ($join)  {
                    //                        $join->on('galleries.id', '=', 'gallery_translations.gallery_id')
                    //                            ->where('name', 'like',  "%" . request('search')['value'] . "%")
                    //                            ->orWhere('alt','like',"%" . request('search')['value'] . "%");
                    //                    });

                }
            })
            ->addColumn('order', function ($data) {
                return ($this->totalCount > 1) ? "<i class=\"bx bx-move-vertical move\"></i>" : '';
            })
            ->addColumn('image', function ($data) {
                return "<img src='{$data->thumbs('300x200')}' height='150px' />";
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'image', 'action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {
            if (\Auth::user()->can('module.gallery.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'), //'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('module.gallery.restore', [
                    'table' => request()->table,
                    'id' => request()->id,
                    'gallery' => $data->id
                ]));
            }
        } else {

            if (\Auth::user()->can('module.gallery.edit')) {
                $buttons .= DataTableButton::make()->edit(route('module.gallery.edit', [
                    'table' => request()->table,
                    'id' => request()->id,
                    'gallery' => $data->id
                ]));
            }

            if (\Auth::user()->can('module.gallery.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('module.gallery.active', $data->id));
            }

            if (\Auth::user()->can('module.gallery.destroy')) {

                $buttons .= DataTableButton::make()->delete(route('module.gallery.destroy', $data->id));
            }
        }

        return $buttons;
    }
}