<?php


namespace Modules\Catalog\DataTables;


use App\Services\ModelService;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\Product;
use Yajra\DataTables\Services\DataTable;

class SeoCatalogProductDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    protected $query;


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
        $this->columns = $this->setColumns();
    }

    public function query()
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId(request()->table, request()->id);
        // добавляем фильтр товаров по хар-кам сео-страницы
        $filter = (new Product())->makeFilter(request(), $entity->entity_features);
        // фильтруем

        if(!request()->has('add')):
            $this->query = (new Product())->filter($filter);
        else:
            $this->query = (new Product())->notInFilter($filter);
        endif;


        // если у сео-страницы есть категория, добавляем категорию в условие выборки
        if($entity->product_category_id):
            $this->query->whereHas('category', function ($query) use($entity){
                $query->where('id',$entity->product_category_id) ;
            });
        endif;

        $this->query->newQuery();
    }




    public function dataTable()
    {
        $dt =  datatables()
            ->eloquent($this->query)
            ->filter(function ($query)  {
                if (request()->has('search') && request('search')['value']) {
                    $query->whereHas('page', function ($q) {
                        $q->join('page_translations', function($join)  {
                            $join->on('pages.id','=','page_translations.page_id')
                                ->where('name', 'like',  "%" . request('search')['value'] . "%");
                        });
                    });
                }
            });

        if(request()->has('add')) :
            $dt->addColumn('add', function ($data) {
                return $this->checkbox('add', $data, false, route('module.seo_catalog_product.change', [
                    request()->table, request()->id, $data->id, 'add'
                ]));
            });
        else:
            $dt->addColumn('remove', function ($data) {
                return $this->checkbox('remove', $data, true, route('module.seo_catalog_product.change', [
                    request()->table, request()->id, $data->id, 'remove'
                ]));
            });
        endif;

        $dt->addColumn('name', function ($data) {
                return  $this->link(route('catalog.product.edit',  $data->id), $data->page->name);
            })
            ->addColumn('category', function ($data){
                if(isset($data->category)):
                    return  $this->link(route('catalog.product_category.edit',  $data->category->id), $data->category->page->name);
                endif;
                return null;
            })
            ->addColumn('feature', function ($data){
                $res = '';
                if(isset($data->category)):
                    $res .= __('cms.product_category').' : '.$data->category->page->name. '<br>';
                endif;
                if(isset($data->entity_features)){
                    $collection = $data->entity_features->map(function ($entity_feature)  {
                        $value = $entity_feature->feature->feature_kind->feature_values->where('id',$entity_feature->feature_value_id)->first();
                        return [
                            'feature_id' =>$entity_feature->feature_id,
                            'feature_name' =>$entity_feature->feature->name,
                            'values_name' => $value->name
                        ];
                    });

                    $collection->groupBy('feature_name')->map(function ($f, $key) use(&$res){
                        $res .= $key.' : '.$f->implode('values_name', ','). '<br>';
                    });

                }
                return $res;
            })
            ->addColumn('action', function ($data) {
                return null;//$this->getActionColumn($data);
            });



         $dt->rawColumns(['category','name','remove','add', 'feature', 'action']);

        return $dt;
    }



    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request()->has('add')) {
            $buttons .= '<form action="'.route('module.seo_catalog_product.change', [
                    request()->table, request()->id, $data->id, 'add'
                ]).'" method="post">
                    '.csrf_field().method_field('POST').'
                    <button type="submit">add</button>
             </form>';

        } else {

             $buttons .= '<form action="'.route('module.seo_catalog_product.change', [
                     request()->table, request()->id, $data->id, 'remove'
                 ]).'" method="post">
                    '.csrf_field().method_field('POST').'
                    <button type="submit">remove</button>
             </form>';
        }

        return $buttons;
    }
















    protected function setColumns()
    {
        $columns = [
            [
                'data' => 'id',
                'name' => 'id',
                'title' => '#',
            ],
        ];

        if(request()->has('add')):
            $columns = array_merge($columns,[
                [
                    'data' => 'add',
                    'title' => '',
                    'orderable' => false
                ]
            ]);
        else:
            $columns = array_merge($columns,[
                [
                    'data' => 'remove',
                    'title' => '',
                    'orderable' => false
                ]
            ]);
        endif;

        $columns = array_merge($columns,[
            [
                'data' => 'name',
                'title' => 'cms.product_name',
                'orderable' => false
            ],
//            [
//                'data' => 'category',
//                'title' => 'cms.product_category',
//                'orderable' => false
//            ],
            [
                'data' => 'feature',
                'title' => 'cms.feature',
                'orderable' => false
            ],
        ]);

        return $columns;
    }
}
