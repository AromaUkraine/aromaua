<?php


namespace Modules\Catalog\View\Cms\PageComponent;


use App\Models\PageComponent;
use Illuminate\View\Component;

class ItemList extends Component
{
    /**
     * @var object|null
     */
    public $model;

    /**
     * @var
     */
    public $page_components;

    public $name;

    /**
     * ItemList constructor.
     * @param object|null $model
     * @param string $alias
     */
    public function __construct(?object $model = null, ?string $name='', $alias= 'catalog')
    {
        $this->model = $model;
        $this->name = (!$name) ? 'parent_page_id' : $name;

        /** пока не используем **/
//        $this->page_components = PageComponent::where('alias', $alias)->get();

        $this->page_components = PageComponent::where('alias', $alias)->first();
    }

    /**
     * @return \Closure|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        /** пока не используем **/
        //return view('catalog::cms.components.page_component.item-list');
        return view('catalog::cms.components.page_component.item');
    }

    /**
     * @param $item
     * @return string|null
     */
    public function setSelected($item){

        if(!$this->model)
            return null;

        if($item->page_id == $this->model->parent_page_id){
            return 'selected';
        }
    }
}
