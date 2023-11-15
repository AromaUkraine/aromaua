<?php

namespace App\View\Components\Cms\Menu;

use App\Events\PushTreeToMenuTreeEvent;
use Illuminate\View\Component;

class FrontendAddTree extends Component
{
    /**
     * @var bool
     */
    public $exist;
    /**
     * @var array
     */
    public $options;

    public $table;

    public $model;

    public $menu;


    public $root;

    /**
     * Create a new component instance.
     *
     * @param $model
     * @param array $options
     */
    public function __construct($model, $options = [])
    {
        $this->options = $options;
        $this->table = (new $model)->getTable();
        $this->model = $model;

        $this->exist = (bool) $this->checkExistModelItemsInMenu();


        $this->menu = $this->getMenu();

    }


    protected function checkExistModelItemsInMenu()
    {
        return \App\Models\Menu::frontend()->whereHas('page', function ($query) {
            $query->where('pageable_type', $this->model);
        })->count();
    }

    protected function getMenu()
    {
        return \App\Models\Menu::frontend()->defaultOrder()->get()->toTree();
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.menu.frontend-add-tree');
    }

    public function indent($level)
    {
        $in = '';
        if($level){
            for($i = $level; $i > 0; $i--){
                $in .= '--';
            }
        }

        return $in;
    }

//     private function test()
//     {
//         $model = new $this->model;
//         $tree = $model->with(['page'=>function($query){
//             $query->translated();
//         }])->get()->toTree();

//         $root = \App\Models\Menu::where('id', 45)->first();



// //        $locales = app()->languages->all()->slug();
// //        //last menu id 70
// //
// //        $traverse = function ($items, $root) use (&$traverse, $locales) {
// //            foreach ($items as $item) {
// //
// //               $node = $this->add($item, $root, $locales);
// //
// //                $traverse($item->children, $node);
// //            }
// //        };
// //
// //        $traverse($tree, $root);
//         dd();
//     }


    private function add($item, $root, $locales)
    {
        $data = [
            'page_id' => $item->page->id,
            'parent_id' => $root->id,
            'from'=>\App\Models\Menu::FRONTEND
        ];

        // подготавливаем данные для сохранения
        foreach ( $locales as $locale )
        {
            if($item->page->hasTranslation($locale)) {
                // присваиваем имя и статус такой же как у страницы
                $data[$locale]['name'] = $item->page->translate($locale)->name;
                $data[$locale]['publish'] = $item->page->translate($locale)->publish;
            }
        }

        $node = \App\Models\Menu::create($data);
        $root->appendNode($node);

        return $node;
    }


}
