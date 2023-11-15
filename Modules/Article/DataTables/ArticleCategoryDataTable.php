<?php


namespace Modules\Article\DataTables;

use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Article\Entities\ArticleCategory;
use Yajra\DataTables\Services\DataTable;

class ArticleCategoryDataTable extends DataTable
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
            'data' => 'pageable_id',
            'title' => 'id',
        ],
        [
            'data' => 'name',

            'title' => 'article.category.title',
        ],
        [
            'data' => 'count_articles',
            'title' => 'article.category.count_articles',
        ],
    ];




    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query(){

        if(request('trash')){
            $this->query = ArticleCategory::with('articles')
                ->with(['page'=>function($query){
                    $query->onlyTrashed();
                }])
                ->onlyTrashed()
                ->where('parent_page_id', request()->page->id)->newQuery();
        }else{
            $this->query = ArticleCategory::with(['articles','page'])
                ->where('parent_page_id', request()->page->id)->newQuery();
        }

    }

    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {

                    $query->where('article_categories.parent_page_id', request()->page->id)->with(['articles','page'])
                        ->whereHas('page', function ($q){
                            $q->join('page_translations', function($join){
                                $join->on('pages.id','=','page_translations.page_id')
                                    ->where('name', 'like', "%" . request('search')['value'] . "%");
                            });
                        });

                    if(request('trash')){
                        $query->onlyTrashed();
                    }
                }
            })
            ->addColumn('pageable_id', function ($data) {
                return $data->id;
            })
            ->addColumn('name', function ($data) {
               // dump($data->page()->name);
                return $data->page->name;
            })
            ->addColumn('count_articles', function ($data) {
                return $this->badge($data->articles()->count());
            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action','count_articles']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if( request('trash')) {
            if(\Auth::user()->can('module.article_category.restore')){
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' =>'success'
                ])->edit(route('module.article_category.restore', ['page'=>request()->page->id,'category'=>$data->id]));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }
        }else{

            if(\Auth::user()->can('module.article_category.edit')){
                $buttons .= DataTableButton::make()->edit(route('module.article_category.edit', ['page'=>request()->page->id,'category'=>$data->id] ));
            }

            if(\Auth::user()->can('module.article_category.active')) {
                $buttons .= DataTableButton::make()->toggleActive( $data->page->active , route( 'module.article_category.active', $data->id ));
            }

            if(\Auth::user()->can('module.article_category.destroy')) {
                $buttons .= DataTableButton::make()->delete(route('module.article_category.destroy',   $data->id));
            }

        }


        return $buttons;
    }

}
