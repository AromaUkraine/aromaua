<?php

namespace App\View\Components\Cms\Menu;

use App\Models\Permission;
use App\Models\Role;
use App\Services\TranslateOrDefaultService;
use Illuminate\View\Component;
use App\Models\Menu;

class MenuConstructor extends Component
{

    public $menu;
    /**
     * @var string
     */
    public $ulClass;
    /**
     * @var string
     */
    public $ulChildrenClass;
    /**
     * @var string
     */
    public $liClass;
    /**
     * @var string
     */
    public $liChildrenClass;
    /**
     * @var string
     */
    public $spanClass;
    /**
     * @var string
     */
    public $spanChildrenClass;


    public $current;

    /**
     * Create a new component instance.
     *
     * @param $page
     */
    public function __construct($page = null)
    {
        if ($page) {
            $this->current = Permission::pageSlug($page);
        }

        $this->ulClass = "navigation navigation-main";
        $this->ulChildrenClass = "menu-content";
        $this->liClass = "nav-item";
        $this->liChildrenClass = "";
        $this->spanClass = "menu-title";
        $this->spanChildrenClass = "menu-item";


        $query = Menu::with(['permission'])
            ->defaultOrder()
            ->backend()
            ->where('active', true)
            ->translated()->newQuery();

        // Разработчику доступен полный список пунков в меню, остальным же все исключая меню разработчика
        if (\Auth::user()->role->slug !== Role::DEVELOPER_ROLE) {
            $query->where('type', '!=', Role::DEVELOPER_ROLE)
                ->orWhereNull('type');
        }

        $this->menu = $query->get()->toTree();
    }


    public function getActive($item)
    {
        if ($item->permission_id) {

            $str = \Str::afterLast($item->permission->slug, '.');
            $term = str_replace('.' . $str, '', $item->permission->slug);

            if ($this->current && $this->current == $item->permission->slug) {
                return 'active';
            } else {

                return (\Request::routeIs($term . ".*")) ? 'active' : '';
            }
        }
    }




    public function getUrl($item)
    {

        if ($item->permission_id) {

            if($item->permission->data && $item->permission->data['page_id']){
                return route($item->permission->slug, $item->permission->data['page_id']);
            }else {
                return route($item->permission->slug);
            }
        }

        return  "#";
    }

    public function getName($item)
    {
        return $item->name ?? app(TranslateOrDefaultService::class)->get($item, 'name');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        throw new \Exception('This is just a class constructor');
    }
}
