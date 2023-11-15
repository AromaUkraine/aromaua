<?php


namespace Modules\Catalog\View\Cms\ProductCategory;


use Illuminate\View\Component;
use Modules\Catalog\Entities\ProductCategory;

class ItemList  extends Component
{
    public $categories;

    public $rootPages;

    public $model;
    /**
     * @var string
     */
    public $name;
    /**
     * @var mixed
     */
    public $options;
    /**
     * @var string|null
     */
    private $selected;

    public function __construct(?object $model = null, ?string $name = null, ?string $selected = null, $options = null )
    {
        $this->model = $model;

        $this->name= !$name ? 'product_category_id' : $name;

        $this->selected = $selected;

        $this->options = ['class'=>'','type'=>'select2','placeholder'=>__('cms.select.default')];

        $options = ($options) ?json_decode($options, true) : [];

        $this->options = array_merge($this->options, $options);

        $this->categories = ProductCategory::joinPage()->get()->toTree();

    }


    public function setSelected($item){

        if(!$this->model && $this->selected) :
            if($item->id == (int)$this->selected) :
                return 'selected';
            endif;
        elseif ($this->model):
            if($item->id == $this->model->product_category_id):
                return 'selected';
            endif;
        else:
            return null;
        endif;

    }


    public function render()
    {
        return view('catalog::cms.components.product_category.item-list');
    }
}
