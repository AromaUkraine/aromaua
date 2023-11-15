<?php


namespace Modules\Article\DataTables;

use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Article\Entities\Article;
use Yajra\DataTables\Services\DataTable;

class ArticleDataTable extends DataTable
{

    use DataTableTrait;

    public $attributes;

    public $totalCount;


    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns = [
        [
            'data' => 'id',
            'title' => 'id',
        ],
        [
            'data' => 'name',
            'title' => 'article.title',
        ],
        [
            'data' => 'categories',
            'title' => 'article.categories',
        ],
        [
            'data' => 'published_at',
            'name' => 'published_at',
            'title' => 'article.published_at',
        ],

    ];

    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query(){

        $this->query = Article::where('parent_page_id', request()->page->id)
            ->orderBy('published_at','desc')
            ->with(['categories', 'page']);

        if(request('trash')){
            $this->query->with(['page'=>function($query){
                $query->onlyTrashed();
            }])->onlyTrashed();
        }

        $this->query->newQuery();
    }


    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->filter(function ($query) {

                if (request()->has('search') && request('search')['value']) {

                    $query->where('articles.parent_page_id', request()->page->id)->with(['categories','page'])
                        ->whereHas('page', function ($q) {
                            $q->join('page_translations', function($join)  {
                                $join->on('pages.id','=','page_translations.page_id')
                                    ->where('name', 'like',  "%" . request('search')['value'] . "%");
                            });
                        })->orWhereHas('categories',function ($q) {
                            $q->whereHas('page', function ($q)  {
                                $q->join('page_translations', function ($join)  {
                                    $join->on('pages.id', '=', 'page_translations.page_id')
                                        ->where('name', 'like',  "%" . request('search')['value'] . "%");
                                });
                            });
                        });
                }
            })
            ->addColumn('name', function ($data) {
                return $data->page->name;
            })
            ->addColumn('categories', function ($data) {
                $names = $data->categories->map( function ($category){
                   return $category->page->name;
                });
                $list = '';
                if($names) {
                    foreach ($names as $name){
                        $list .= "<div class=\"badge badge-pill badge-light-secondary mr-1 mb-1\">{$name}</div>";
                    }
                }
                return $list;
            })
            ->addColumn('published_at', function ($data) {
                return $data->published_at->diffForHumans();
            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['categories','action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if( request('trash')) {
            if(\Auth::user()->can('module.article.restore')){
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' =>'success'
                ])->edit(route('module.article.restore', ['page'=>request()->page->id,'article'=>$data->id]));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }
        }else{

            if(\Auth::user()->can('module.article.edit')){
                $buttons .= DataTableButton::make()->edit(route('module.article.edit', ['page'=>request()->page->id,'article'=>$data->id] ));
            }

            if(\Auth::user()->can('module.article.active')) {
                $buttons .= DataTableButton::make()->toggleActive( $data->page->active , route( 'module.article.active', $data->id ));
            }

            if(\Auth::user()->can('module.article.destroy')) {

                $buttons .= DataTableButton::make()->delete(route('module.article.destroy',   $data->id));
            }

        }



        return $buttons;
    }


    public function initComplete()
    {
//        return "
//        function () {
//        this.api().columns().every( function () {
//            var column = this;
//            $('.dataTables_filter#category').on('change', function(){
//                var val = $.fn.dataTable.util.escapeRegex(
//                            $(this).val()
//                        );
//                console.log(val);
//                column.search(category ? '^'+val+'$' : '', true, false)
//                .draw();
//            })
//        })
//
//            }
//        ";
    }
}
