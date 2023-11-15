<?php

namespace Modules\Synchronize\Events;

use Modules\Catalog\Entities\Product;
use Illuminate\Queue\SerializesModels;
use Modules\Developer\Entities\Template;
use Modules\Synchronize\Traits\DatabaseLogTrait;

class ApiSynchronizeEvent
{
    use SerializesModels;

    use DatabaseLogTrait;


    public $path = '';
    public $default_language = '';
    public $folder_name = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($folder_name)
    {

        ini_set('max_execution_time', 2700);

        // название папки текущей синхронизации (dmY)
        $this->folder_name = $folder_name;

        // путь к директории в поторой храниться эта папка
        $this->path = public_path() . '/synchronize';

        //язык сайта по умолчанию
        $this->default_language = config('app.fallback_locale', 'ru');

        // список всех языков сайта
        $this->locales = app()->languages->all()->slug();

        // находим основную родительскую страницу (каталог) к ней будут привязыватся категории
        $this->parent_page = Template::with(['page'])->where('type', 'catalog')->first();
    }

    /**
     * Программист периодически неверно указывает код украинского языка,
     * в одном файле он указан как uk в другом же указан как ua
     * Метод приводит к одному значению
     *
     * @param string $code
     * @return string
     */
    public function setUkranianValidCode($code)
    {
        $code = trim($code);
        return ($code == 'uk') ? 'ua' : $code;
    }


    /**
     * Получение пути к файлу
     *
     * @param string $filename
     * @return string
     */
    public function getPath($filename)
    {
        if(strlen($this->folder_name))
            $filePath = $this->path . DIRECTORY_SEPARATOR . $this->folder_name . DIRECTORY_SEPARATOR . $filename;
        else
            $filePath = $this->path . DIRECTORY_SEPARATOR . $filename;

        // if(!\File::exists($filePath)){
        //     $message = "Файла по пути [{$filePath}] не существует.";
        //     $this->logToDb($message);
        //     throw new \Exception($message);
        // }

        return $filePath;
    }


    /**
     * Добавляет данные перевода языка по умолчанию для других языков если в данных переданных по api этой информации нет
     *
     * @param array $array
     * @return array
     */
    public function addTranslationsIfNotExist($array)
    {
        $key = array_key_first($array);
        foreach ($this->locales as $locale) {
            if ($locale !== $key && !array_key_exists($locale, $array)) {
                $array[$locale] = $array[$key];
            }
        }

        return $array;
    }


    /**
     * Используем поиск товара по артикулу
     * @param $group - поле для группировки, он же артикул
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findProduct($group)
    {
        return Product::with('category')
            ->where('group', trim($group))
            ->first();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
