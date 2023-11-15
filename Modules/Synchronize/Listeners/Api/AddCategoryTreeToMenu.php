<?php

namespace Modules\Synchronize\Listeners\Api;

use App\Models\Menu;
use App\Events\PushTreeToMenuTreeEvent;

class AddCategoryTreeToMenu
{

    /**
     * Ключ определяющий основной (рутовый) пункт в таблице menus отвечающий за отображение основного меню на фронтенде
     * Все его наследники имеют parent_id - eго id, таким образом можно найти страницу каталог вложенной в это меню и привязать
     * дерево категории к этому каталогу
     *
     * @var string
     */
    protected $main_menu_root_key = 'main-menu';

    public function handle($event)
    {
        // находим корневой пункт основного меню !!! обязан быть
        $root = Menu::where('type', $this->main_menu_root_key)->first();

        if ($root) {

            //находим пункт каталог в основом меню, если его нет создаем иначе обновляем (переводы) в меню
            $catalog_on_main_menu = $this->createOrUpdateCatalogItemOnMenu($event, $root);

            // берем дерево категории
            $category_tree = \Modules\Catalog\Entities\ProductCategory::with(['page'])->get()->toTree();

            // обновляет дерево фронтенд меню помещает дерево категории как наследника $catalog_on_main_menu
            event(new PushTreeToMenuTreeEvent($catalog_on_main_menu, $category_tree));
        }
    }


    protected function createOrUpdateCatalogItemOnMenu($event, $root)
    {
        $catalog_on_main_menu = Menu::where('page_id', $event->parent_page->page->id)
            ->where('parent_id', $root->id)
            ->first();

        // подготавливает массив данных для сохранения в базе данных
        $data = $this->prepareDataBeforeSave($event, $root, $catalog_on_main_menu);

        if (!$catalog_on_main_menu) {
            $catalog_on_main_menu = Menu::create($data);
            $root->appendNode($catalog_on_main_menu);
        } else {
            $catalog_on_main_menu->update($data);
        }

        return $catalog_on_main_menu;
    }

    /**
     * Подготавливаем данные для пункта меню страницы каталога
     *
     * @param object $event
     * @param object $root
     * @param object $catalog_on_main_menu
     * @return array
     */
    protected function prepareDataBeforeSave($event, $root, $catalog_on_main_menu)
    {
        $data = [
            'page_id' => $event->parent_page->page->id,
            'parent_id' => $root->id,
            'from' => Menu::FRONTEND
        ];

        return $this->makeMenuTranslateData($event, $catalog_on_main_menu, $data);
    }

    /**
     * Находим на каких языках создана страница каталога
     * если в меню нет записи названия на текущем языке
     * добавляем в таблицу переводов меню:
     * - название пункта меню итакое же как название страницы
     * - указываем статус опубликованности как у страницы
     *
     * @param object $event
     * @param object $catalog_on_main_menu
     * @param array $data
     * @return array
     */
    protected function makeMenuTranslateData($event, $catalog_on_main_menu, $data)
    {

        foreach ($event->locales as $locale) {
            if ($catalog_on_main_menu->page->hasTranslation($locale)) {
                $data[$locale]['name'] = $catalog_on_main_menu->translate($locale)->name ?? $catalog_on_main_menu->page->translate($locale)->name;
                $data[$locale]['publish'] = $catalog_on_main_menu->translate($locale)->publish ?? $catalog_on_main_menu->page->translate($locale)->publish;
            }
        }

        return $data;
    }
}
