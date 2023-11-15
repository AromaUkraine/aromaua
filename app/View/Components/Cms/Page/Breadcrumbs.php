<?php

namespace App\View\Components\Cms\Page;

use App\Models\Menu;
use App\Traits\CmsNamedHelperTrait;
use App\View\Components\Cms\Nav\NavConstructor;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * @var string|null
     */
    private static $name;
    /**
     * @var object|null
     */
    private static $model;
    /**
     * @var array|null
     */
    private static $attr;

    /**
     * @var array
     */
    public $breadcrumbs;

    public $title;

    protected $currentRouteName;
    /**
     * @var string
     */
    protected $defaultAction;


    use CmsNamedHelperTrait;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // коллекция хлебных крошек
        $this->breadcrumbs = collect();
        // устанавливает текущий роут
        $this->setCurrentRouteName();
        // устанавливает дефолтный метод (index) для текущего роута
        $this->setDefaultAction();
        // создает дерево хлебных крошек
        $this->setBreadcrumbs(self::$attr);

    }


    private function setBreadcrumbs(?array $attr)
    {
        // добавляет первый елемент если явно указан параметр prev
        $this->setPrevItems($attr);

        // создает крошки из items
        if (isset($attr['items'])) :
            $this->breadcrumbs = collect($attr['items']);
        // создает крошки для под меню записи на странице (например галлерея статьи на странице блог)
        elseif (isset($attr['page']) && isset($attr['entity'])) :
            $this->setPageEntityItems($attr);
        // создает крошки для под меню записи (статья, категория, товар и т.д.)
        elseif (isset($attr['entity']) ) :
            $this->setEntityItems($attr);
        // создает крошки для компонентов страницы (баннер, статьи, категории и т.д.)
        elseif (isset($attr['page'])) :
            $this->setPageItems($attr);
        else:
            // автоматическое создание хлебных крошек
            $this->setItems($attr);
        endif;

        // добавляет последний елемент если явно указан параметр last
        $this->setLastItems($attr);
        // создает заголовок для хлебных крошек
        $this->setTitle($attr);

    }


    public static function make(?array $attributes = [], ?string $name = '', ?object $model = null)
    {

        self::$name = $name;
        self::$model = $model;
        self::$attr = $attributes;
    }

    /**
     * формирует роутинг
     * @param $item
     * @return string|null
     */
    public function setRoute($item)
    {

        if (isset($item['slug'])) :
            if (isset($item['params'])) :
                return route($item['slug'], $item['params']);
            else :
                return route($item['slug']);
            endif;
        endif;

        return null;
    }


    // получает текущий route name
    private function setCurrentRouteName()
    {
        $this->currentRouteName = \Request::route()->getName();
    }

    // берет текущий route name и заменяет последний сегмент на index
    private function setDefaultAction()
    {
        $segment = \Str::beforeLast($this->currentRouteName, '.');
        $this->defaultAction = $segment . '.index';
    }

    // Создание хлебных крошек под меню записи  не на странице (галлерея для категории товаров, характерискика для товара и т.д.).
    private function setEntityItems(?array $attr)
    {
        $item = new NavConstructor(null,$attr['entity']);

        $this->addPageItem($item);

        if(isset($item->entity_menu[$this->defaultAction])) :

            $this->findAndAddPageComponent($item);
            $this->addEntityItem($item);
            $this->addInnerEntityComponent($item);

        endif;
    }

    // Создание хлебных крошек под меню записи на  страницы.
    private function setPageEntityItems(?array $attr)
    {
        // Сегмент раздела сайта
        //$this->breadcrumbs->add(['name' => 'breadcrumbs.site_sections']);

        $item = new NavConstructor($attr['page'], $attr['entity']);

        $this->addPageItem($item);

        if(isset($item->entity_menu[$this->defaultAction])) :

            $this->findAndAddPageComponent($item);
            $this->addEntityItem($item);
            $this->addInnerEntityComponent($item);

        endif;
    }

    // Создание хлебных крошек для страницы.
    private function setPageItems(?array $attr)
    {

        // Сегмент раздела сайта
        $this->breadcrumbs->add(['name' => 'breadcrumbs.site_sections']);

        $item = new NavConstructor($attr['page']);

        $this->addPageItem($item);
        $this->addPageComponent($item, $this->defaultAction);
    }

    // Создание дефолтных хлебных крошек.
    private function setItems(?array $attr)
    {
        // ищет пункт меню по дефолтному экшену
        $menuItem = Menu::whereHas('permission', function ($query) {
            $query->where('slug', $this->defaultAction);
        })->first();

        // если пункт есть в меню
        if ($menuItem) :

            // ищем дерево родителей
            $parents = $menuItem->ancestors->toTree();

            // если найдет хотя бы один родитель
            if ($parents->count()) :

                //собираем коллекцию предков
                $items = collect($parents->map(function ($item) {
                    return [
                        'slug' => ($item->permission_id) ? $item->permission->slug : null,
                        'name' => $item->name
                    ];
                }));

                // помещаем в конец пункт меню
                $items->add(['slug' => $this->defaultAction, 'name' => $menuItem->name]);

                if (!$this->breadcrumbs->count()) :
                    // присваиваем в хлебные крошки
                    $this->breadcrumbs = $items;
                endif;

            else:
                $this->breadcrumbs->add(['slug' => $this->defaultAction, 'name' => $menuItem->name]);
            endif;

        endif;
    }

    //

    /**
     * Добавляет сегмент в начало
     * @param array|null $attr
     */
    private function setPrevItems(?array $attr)
    {
        if (isset($attr['prev'])) :
            $this->breadcrumbs->push($attr['prev']);
        endif;
    }

    /**
     * Добавляет сегмент в конец
     * @param array|null $attr
     */
    private function setLastItems(?array $attr)
    {
        if (isset($attr['last'])) :
            $this->breadcrumbs->push($attr['last']);
        endif;
    }

    /**
     * Сегмент заголовка (самый первый)
     * @param array|null $attr
     */
    private function setTitle(?array $attr)
    {
        if (!isset($attr['title'])) :

            if ($this->breadcrumbs->count()) :
                $this->title = $this->breadcrumbs[0]['name'];
                $this->breadcrumbs->pull(0);
            endif;

        else :
            $this->title = $attr['title'];
        endif;
    }

    /**
     * Сегмент страницы
     * @param NavConstructor $item
     */
    private function addPageItem(NavConstructor $item)
    {
        if(isset($item->page_menu) && isset($item->page_menu['general'])):
            $this->breadcrumbs->add($item->page_menu['general']);
        endif;
    }

    /**
     * Найти и добавить сегмент компонента страницы внутри записи
     * @param NavConstructor $item
     */
    private function findAndAddPageComponent(NavConstructor $item)
    {
        if (isset($item->entity_menu[$this->defaultAction]['route_key'])) :
            $route_key = $item->entity_menu[$this->defaultAction]['route_key'].'.index';
            $this->addPageComponent($item, $route_key);
        endif;
    }

    /**
     * Сегмент компонента страницы (статьи, категории и т.д.)
     * @param NavConstructor $item
     */
    private function addPageComponent(NavConstructor $item,$key)
    {
        if(isset($item->page_menu[$key])) :
            $this->breadcrumbs->add($item->page_menu[$key]);
        endif;
    }

    /**
     * Сегмент самого компонента на странице (статья категория и т.д.)
     * @param NavConstructor $item
     */
    private function addEntityItem(NavConstructor $item)
    {
        $key = $item->entity->page->slug ?? get_class($item->entity);
        if(isset($item->entity_menu[$key])) :
            $this->breadcrumbs->add($item->entity_menu[$key]);
        endif;
    }

    /**
     * Сегмент внутренней навигации у компонента страницы (галлерея статьи, галлерея категории и т.д.)
     * @param NavConstructor $item
     */
    private function addInnerEntityComponent(NavConstructor $item)
    {
        if(isset($item->entity_menu[$this->defaultAction])) :
            $this->breadcrumbs->add($item->entity_menu[$this->defaultAction]);
        endif;
    }

    public function render()
    {
        return view('components.cms.page.breadcrumbs');
    }

}
