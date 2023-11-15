<?php


namespace Modules\Shop\View\Model;


use Illuminate\View\Component;
use phpDocumentor\Reflection\Types\Collection;

class ItemList extends Component
{

    /**
     * @var string
     */
    public $name;
    /**
     * @var Collection|null
     */
    public $items;
    /**
     * @var string|null
     */
    public $label;
    /**
     * @var object|null
     */
    protected $model;
    /**
     * @var string
     */
    protected $table;



    public function __construct( string $name, string $entity, ?string $label ,?object $model = null )
    {
        $this->name = $name;
        $this->label = $label;
        $this->model = $model;

        $this->items = (new $entity)->get();
    }

    public function setSelected($item){

        $name = $this->name;
        if(!$this->model) {
            if($item->id == old($this->name)){
                return 'selected';
            }
        }else{
            if($item->id == $this->model->$name){
                return 'selected';
            }
        }

        return null;
    }

    public function render()
    {
        return view('shop::components.item.list');
    }
}
