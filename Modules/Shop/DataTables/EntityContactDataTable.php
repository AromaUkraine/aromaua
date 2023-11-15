<?php

namespace Modules\Shop\DataTables;

use App\Services\ModelService;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Shop\Entities\EntityContact;
use Yajra\DataTables\Services\DataTable;

class EntityContactDataTable extends DataTable
{

    use DataTableTrait;

    public $attributes;

    public $totalCount;

    protected $query;

    public $columns = [
        [
            'data' => 'order',
            'title' => '#',
        ],
        [
            'data' => 'value',
            'title' => 'cms.value',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'description',
            'title' => 'cms.entity_contact_description',
            'name' => 'country',
            'orderable' => false,
            'sortable' => false,
        ],
    ];


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        $this->attributes = [
            'data-model' => EntityContact::class,
            'class' => 'table sortable',
            'data-url' => route('sortable')
        ];
    }


    public function query()
    {

        $entity = app(ModelService::class)->findEntityByTableId(request()->table, request()->id);

        $this->query = EntityContact::with('contactable')
            ->where('contactable_type', get_class($entity))
            ->where('contactable_id', $entity->id);

        if (request()->has('trash')) {
            $this->query->onlyTrashed();
        }

        $this->query->newQuery();
    }

    public function dataTable()
    {

        $datatable = datatables()->eloquent($this->query);

        /** добавлено для сортировки **/
        if ($this->totalCount > 1) {

            $datatable
                ->setRowClass('row-sort')
                ->setRowAttr(['data-id' => function ($data) {
                    return $data->id;
                },
                ]);
        }

        return $datatable
            ->addColumn('order', function ($data) {
                return ($this->totalCount > 1) ? "<i class=\"bx bx-move-vertical move\"></i>" : '';
            })
            ->addColumn('value', function ($data) {
                return $data->value;
            })
            ->addColumn('description', function ($data){
                return $data->description;
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request()->has('trash')) {
            if (\Auth::user()->can('module.entity_contact.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('module.entity_contact.restore',[
                    request()->table,
                    request()->id,
                    $data->id
                ]));
            }
        } else {

            if (\Auth::user()->can('module.entity_contact.edit')) {
                $buttons .= DataTableButton::make()->edit(route('module.entity_contact.edit', [
                    request()->table,
                    request()->id,
                    $data->id
                ] ));
            }

            if (\Auth::user()->can('module.entity_contact.active')) {
                $buttons .= DataTableButton::make()
                    ->toggleActive($data->active, route('module.entity_contact.active', $data->id));
            }

            if (\Auth::user()->can('module.entity_contact.destroy')) {
                $buttons .= DataTableButton::make()->delete(route('module.entity_contact.destroy', $data->id));
            }

        }

        return $buttons;
    }

}
