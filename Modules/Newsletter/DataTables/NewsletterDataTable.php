<?php

namespace Modules\Newsletter\DataTables;

use App\Traits\DataTableTrait;

use Yajra\DataTables\Services\DataTable;
use Modules\Newsletter\Entities\Newsletter;

class NewsletterDataTable extends DataTable
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
            'data' => 'email',
            'name' => 'email',
            'title' => 'E-mail',

        ],
        [
            'data' => 'status',
            'title' => 'cms.status',

        ],
    ];


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }



    public function query()
    {
        $this->query = Newsletter::withTrashed()->newQuery();
    }


    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {
        $datatable = datatables()->eloquent($this->query);

        return $datatable
            ->addColumn('status', function ($data) {
                return (!$data->delete_at) ? 'subscribe' : 'unsubscribe';
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action']);
    }

    protected function getActionColumn($data)
    {
        return null;
    }
}