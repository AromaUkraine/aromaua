<?php


namespace App\View\Components\Cms\Nav;


use App\Models\EntityComponent;
use App\Models\Permission;
use App\Traits\CmsNamedHelperTrait;
use Illuminate\View\Component;

class NavConstructor extends Component
{
    public $permissions;

    public $action;
    /**
     * @var object|null
     */
    public $page;
    /**
     * @var mixed
     */
    public $options;
    /**
     * @var mixed
     */
    public $form = [];

    public $page_menu = [];

    public $entity_menu = [];
    /**
     * @var object
     */
    public $entity;

    use CmsNamedHelperTrait;

    public function __construct(
        object $page = null,
        object $entity = null,
        string $form = null,
        string $options = null
    ) {

        $this->options = json_decode($options, true);
        $this->form = json_decode($form, true);

        if ($page) {
            $this->page = $page;
            $this->setPageMenu();
        }

        if ($entity) {
            $this->entity = $entity;
            $this->setEntityMenu();
        }

        $this->setOptions();
        $this->setFormOptions();
    }

    /**
     *  создает меню внутри страницы из самой страницы + виджеты и модули страницы
     */
    protected function setPageMenu()
    {
        $this->getPageDefaultItem();

        if (method_exists($this->page, 'components')) {
            // находим активные подключенные компоненты
            $components = $this->page->components()->get();

            // если добавлен хотя бы один компонент
            if ($components->count()) {

                // добавляем пункты субменю из подключенных к странице компонентов
                foreach ($components as $component) {

                    // подключаем виджет
                    if ($component->isWidget()) {
                        $this->createWidgetItem($component);
                    }
                    // подключам модуль
                    if ($component->isModule()) {
                        $this->createModuleItem($component);
                    }
                }
            }
        }
    }

    /**
     * Устанавливает дефолтный пункт меню - родительскую страницу
     */
    protected function getPageDefaultItem()
    {

        $this->permissions = Permission::withCondition($this->page->pageable->id, $this->page->id)->get();

        $permission = $this->permissions->where('action', 'index')->first();

        $this->page_menu['general'] = [
            'name' => $this->page->name,
            'icon' => 'bx bx-cog',
            'slug' => $permission->routes['slug'],
            'params' => $this->page->id
        ];
    }

    /**
     * создает вкладку в меню для виджета страницы
     * @param $widget
     * @return array
     */
    protected function createWidgetItem($widget)
    {
        $alias = $widget['alias'];
        $name = $widget['name'];

        // если у виджета есть элемент навигации
        if (isset($widget->data['cms_navigation'])) {


            foreach ($widget->data['cms_navigation'] as $nav) {
                $this->page_menu[$alias] = [
                    'name' => $nav['label'] ?? $name,
                    'icon' => $nav['icon'] ?? '',
                    'slug' => $nav['slug'],
                    'params' => [$widget->page->id, $widget->alias]
                ];
            }
        }

        return [];
    }

    /**
     * создает вкладку в меню для модуля страницы
     * @param $module
     */
    protected function createModuleItem($module)
    {

        if (isset($module->data['cms_navigation'])) {

            foreach ($module->data['cms_navigation'] as $nav) {
                $key = $nav['slug'];
                $this->page_menu[$key] = [
                    'name' => $nav['label'],
                    'icon' => $nav['icon'] ?? '',
                    'slug' => $nav['slug'],
                    'params' => $module->page->id
                ];
            }
        }
    }

    /**
     * создает меню внутри модуля, виджета их собственных под-меню
     * (например у статьи добавляет пункт галерея самой этой статьи)
     */
    protected function setEntityMenu()
    {
        $entity_components = EntityComponent::where('table', $this->entity->getTable())->get();

        $this->getEntityDefaultItem($entity_components->first());
        $entity_components = $entity_components->toArray();


        // если не переданна страница
        if (!$this->page && $this->entity) :
            $params = ['table' => $this->entity->getTable(), 'id' => $this->entity->id];
        else :
            $params = ['page' => $this->page->id, 'table' => $this->entity->getTable(), 'id' => $this->entity->id];
        endif;


        // создараем пункты меню
        foreach ($entity_components as $item) :
            foreach ($item as $key => $value) :
                $this->entity_menu[$item['slug']]['params'] = $params;
                $this->entity_menu[$item['slug']][$key] = $value;
            endforeach;
        endforeach;
    }



    /**
     * Устанавливает дефолтный пункт меню - саму запись (например название статьи)
     * @param $component
     * @throws \Exception
     */
    protected function getEntityDefaultItem($component)
    {

        if( $component ) :

            if(!$this->page && $this->entity) :

                // если нет родительской страницы например как в категории товаров
                // $component->route_key - метод в модели этой запись
                // находим имя роута в доступах
                $default = $component->route_key.'.index';

                $perm = Permission::where('slug', $default)->first();

                // добавляем в меню страницы пункт на список (метод index) этой сущности
                $this->page_menu['general'] = [
                    'name' => $perm->menu->name,
                    'icon' => '',
                    'slug' => $perm->slug,
                    'params' =>''
                ];


                // добавляем пункт на редактирование (метод edit) этой сущности
                if(!isset($this->entity->page)) :

                    $this->entity_menu[get_class($this->entity)] = [
                        'name' => $this->entity->name,
                        'icon' => '',
                        'slug' => $component->route_key.'.edit',
                        'params' => [ $this->entity->id]
                    ];
                else:

                    $this->entity_menu[$this->entity->page->slug]= [
                        'name' => $this->entity->page->name,
                        'icon' => '',
                        'slug' => $component->route_key.'.edit',
                        'params' =>  $this->entity->id
                    ];
                endif;

            else :

                // по умолчанию этот пункт меню возвращает на редактирование самой записи
                // $this->entity->route - метод в модели этой запись
                // например module.article в модели Article
                // (возможно в последствии заменить)
                $this->entity_menu[$this->entity->page->slug]= [
                    'name' => $this->entity->page->name,
                    'icon' => '',
                    'slug' => $component->route_key.'.edit',
                    'params' => [$this->page->id, $this->entity->id]
                ];

            endif;
        else:

            //создаем новый пункт в меню - самой записи и подсвечиваем его
            if(!isset($this->entity->page)) :
                $this->entity_menu[get_class($this->entity)] = [
                    'name' => $this->entity->name,
                    'icon' => '',
                    'slug' => \Request::route()->getName(),
                    'params' => [ $this->entity->id]
                ];
            else:
                $this->entity_menu[$this->entity->page->slug]= [
                    'name' => $this->entity->page->name,
                    'icon' => '',
                    'slug' => \Request::route()->getName(),
                    'params' => [$this->entity->page->id, $this->entity->id]
                ];
            endif;


        endif;
    }
















    protected function addLinkToEntity($name, $route_key, $action = 'edit', $params = null)
    {
        if(!$params)
            $params = [$this->entity->id];

        //get_class($this->entity)
        $this->entity_menu[$route_key] = [
            'name' => $name,
            'icon' => '',
            'slug' => $route_key . '.' . $action,
            'params' => $params
        ];
    }


    protected function addLinkToListItems($perm, $params = '')
    {
        $this->page_menu['general'] = [
            'name' => $perm->menu->name,
            'icon' => '',
            'slug' => $perm->slug,
            'params' => $params
        ];
    }




    /**
     * Возвращает параметры для формы
     */
    public function setFormOptions()
    {
        //
        if ($this->form && !isset($this->form['route'])) {
            $permission = $this->permissions->where('action', $this->options['action'])->first();

            if ($permission) {
                $this->form = [];
                $this->form['route'] = [$permission->routes['slug'], $this->page->id];
            } else {
                $this->form = null;
            }
        }

        if ($this->form && !isset($this->form['method'])) {
            $this->form['method'] = $this->getMethodForRoute($this->form['route'][0]);
            $this->form['novalidate'] = 'novalidate';
        }
    }

    /**
     *  возвращает метод передачи данных для формы (post, patch)
     * @param $name
     * @return string
     */
    protected function getMethodForRoute($name)
    {
        $router = app('Illuminate\Routing\Router');

        if (!is_null($route = $router->getRoutes()->getByName($name))) {
            $methods = $route->methods();
            return $methods[0];
        }
        return 'GET';
    }

    /**
     *  Устанавливает дополнительные опции для формы
     */
    protected function setOptions()
    {
        if (isset($this->options['class']))
            $this->options['class'] = $this->options['class'] . ' form';
        else
            $this->options['class'] = 'form';

        if (!isset($this->options['action'])) {
            $this->options['action'] = 'update';
        }
    }


    

    /**
     *  подсветка активной вкладки
     * @param $slug
     * @param $params
     * @return string
     */
    public function getActive($slug, $params = [])
    {
        if (request()->routeIs($slug)) {
            return 'active';
        }
    }

    public function render()
    {
        return view('components.cms.nav.nav-constructor');
        // throw new \Exception('This is just a class constructor');
    }
}