<?php


namespace Modules\Catalog\View\Cms\Currency;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Currency;

class ItemList extends Component
{
    public  $value;
    public  $currencies;
    public $name;

    public function __construct($value = null, $name = null)
    {
        $this->currencies = Currency::all();
        $this->value = $value;
        $this->name = $name;
    }

    public function render()
    {
        return view('catalog::cms.components.currency.item-list');
    }

    public function setSelected($id)
    {
        if($id == $this->value || $id == old($this->name)){
            return 'selected';
        }
    }
}
