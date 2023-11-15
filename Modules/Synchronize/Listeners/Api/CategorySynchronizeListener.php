<?php

namespace Modules\Synchronize\Listeners\Api;

use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Developer\Entities\Template;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Synchronize\Traits\DatabaseLogTrait;
use Modules\Synchronize\Service\ClearDataService;
use Modules\Synchronize\Service\ReadJsonFileService;
use Modules\Synchronize\Service\CategoryCollectionService;

class CategorySynchronizeListener
{

    use DatabaseLogTrait;

    protected $file = 'categories.json';

    protected $file_path = '';

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
        // полный путь к файлу
        $this->file_path = $event->getPath($this->file);

        // json-данные из файла
        $data = app(ReadJsonFileService::class)->make($this->file_path);


        // создаем коллекцию категории
        $collection = app(CategoryCollectionService::class)->make($data);


        $event->product_categories = collect();

        if ($collection->count()) {

            try {

                \DB::beginTransaction();


                $collection->each(function ($item) use ($event) {

                    // добавляем значения в $item если они пусты
                    $item = $this->updateItemData($item);

                    $category = $this->createOrUpdateCategory($item, $event->parent_page);

                    if ($category) {
                        $this->createOrUpdatePageCategory($item, $category, $event);
                        $event->product_categories->push($category);
                    }
                });


                \DB::commit();
            } catch (\Exception $e) {

                \DB::rollback();
                $this->logToDb($e->getMessage(), $e->getTrace());
            }
        } else {

            $this->logToDb("Category collection is empty");
        }
    }

    /**
     * Добавляет отсутствующие значения
     *
     * @param array $item
     * @return array
     */
    protected function updateItemData($item)
    {
        // добавим в поле description если оно пустое значения из поля name
        if (empty($item['description'])) {
            $item['description'] = $item['name'];
        }


        return $item;
    }

    /**
     * Создание или обновление категории
     *
     * @param array $item
     * @param object $parent_page
     * @return void
     */
    protected function createOrUpdateCategory($item, $parent_page)
    {
        try {

            // ищем в базе данных категорию по code_1c
            $category = ProductCategory::where('code_1c', trim($item['code_1c']))->first();

            // подготавливает массив данных для сохранения в базе данных
            $data = $this->prepareDataBeforeSave($item, $parent_page);



            if (!$category) {
                $category = ProductCategory::create($data);
            } else {
                $category->update($data);
            }

            return $category;
        } catch (\Exception $e) {

            $this->logToDb($e->getMessage(), $e->getTrace());
        }

        return null;
    }


    protected function prepareDataBeforeSave($item, $parent_page)
    {
        // ключи необходимые для синхронизации (слева названия ключей в json-файле)
        $code_1c = 'code_1c';
        $parent_code_1c = 'parent';


        if (!isset($item[$code_1c])) {
            $this->logToDb("Category from json data doesn't have {$code_1c} field.");
            return null;
        }

        if (!isset($item[$parent_code_1c])) {
            $this->logToDb("Category from json data doesn't have {$parent_code_1c} field.");
            return null;
        }


        return [
            'parent_page_id' => $parent_page->page->id,
            'code_1c' => trim($item[$code_1c]),
            'parent_code_1c' => trim($item[$parent_code_1c]),
            'data' => app(ClearDataService::class)->make($item)
        ];
    }


    protected function createOrUpdatePageCategory($item, $category, $event)
    {

        // собираем данные для таблицы pages
        $page_data = $this->prepareDefaultPageData();

        // собираем данные для таблицы page_translations
        $translate_data = $this->makePageTranslateData($item, $event);

        if ($translate_data) {

            $page_data = array_merge($page_data, $translate_data);

            if (!$category->page) {
                $category->page()->create($page_data);
            } else {
                $category->page->update($page_data);
            }
        } else {

            $this->logToDb("Page from category data has been not created or updated.", $item);
        }
    }




    /**
     * Подготавливает дефолтные значения для таблицы pages
     *
     * @return array
     */
    protected function prepareDefaultPageData()
    {
        return array_merge(['active' => true], config('catalog.routes.product_category.web.view', []));
    }


    /**
     * Undocumented function
     *
     * @param array $item
     * @param object $event
     * @return array
     *  Пример отрывка категории в json-файле. По которому формируются переводы
     * "name": [
            {
                "lang": "ru",
                "text": "Средства для стирки"
            }
        ],
     *  Такое же содержание должно быть в массивах description, text
     */
    protected function makePageTranslateData($item, $event)
    {
        // ключ в файле для поля name в базе данных
        $key_name = 'name';
        // ключ в файле для поля description в базе данных
        $key_description = 'description';
        // ключ в файле для поля text в базе данных
        $key_text = 'text';
        // поле lang в массивах по ключам $key_name, $key_description, $key_text по которому будут организовыватся переводы
        $lang = 'lang';
        // поле text в массивах по ключам $key_name, $key_description, $key_text по которому будут организовыватся содержание перевода
        $name = 'text';

        $data = null;

        // добавление название категории, h1, slug
        if (isset($item[$key_name]) && is_array($item[$key_name])) {

            foreach ($item[$key_name] as $key) {

                if (isset($key[$lang])) {

                    $locale = $event->setUkranianValidCode($key[$lang]);

                    $data[$locale] = [
                        'name' => $key[$name] ?? '',
                        'slug' => \Transliterate::slugify($key[$name]) ?? '#',
                        'h1' => $key[$name] ?? '',
                        'publish' => (isset($key[$name]) ?? !empty($key[$name])),
                    ];
                }
            }
        }

        // добавление description к категории
        if (isset($item[$key_description]) && is_array($item[$key_description])) {

            foreach ($item[$key_description] as $key) {

                if (isset($key[$lang])) {

                    $locale = $event->setUkranianValidCode($key[$lang]);
                    $data[$locale]['description'] = $key[$name] ?? '';
                }
            }
        }

        // добавление text к категории
        if (isset($item[$key_text]) && is_array($item[$key_text])) {

            foreach ($item[$key_text] as $key) {

                if (isset($key[$lang])) {

                    $lang = $event->setUkranianValidCode($key[$lang]);
                    $data[$lang]['text'] = $key[$name] ?? '';
                }
            }
        }

        if (count($data) !== 0) {
            // добалвяет копию первого попавшегося перевода как перевода для остальных языков, если перевода на языке не нашлось.
            // $data = $event->addTranslationsIfNotExist($data);
        }

        return $data;
    }
}
