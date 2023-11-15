<?php

namespace App\View\Components\Cms\Menu;

use Illuminate\View\Component;

class MenuNestedTree extends Component
{

    private $routes = [
        'backend'=>'admin.backend_menu.index',
        'frontend'=>'root.frontend_menu.index'
    ];

    public $route = null;
    /**
     * Create a new component instance.
     *
     * @param string $from
     */
    public function __construct($from="backend")
    {
        if(isset($this->routes[$from]))
            $this->route = $this->routes[$from];

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.menu.menu-nested-tree');
    }
}
