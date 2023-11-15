<?php


namespace Modules\Catalog\View\Cms\FeatureKind;


use Illuminate\View\Component;
use Modules\Catalog\Entities\FeatureKind;

class ItemList extends Component
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|FeatureKind[]
     */
    public $kinds;
    /**
     * @var object|null
     */
    public $model;


    public $name = 'feature_kind_id';

    public function __construct(?object $model = null)
    {
        $this->model = $model;

        $this->kinds = FeatureKind::all();
    }

    public function setSelected($item){

        if(!$this->model) {
            if($item->id == old($this->name)){
                return 'selected';
            }
        }else{
            if($item->id == $this->model->feature_kind_id){
                return 'selected';
            }
        }

        return null;
    }

    public function render()
    {
        return view('catalog::cms.components.feature_kind.item-list');
    }
}
