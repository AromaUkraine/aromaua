<?php


namespace App\Traits;

/**
 *  Добавляет модифицированые, универсальные запросы
 * Trait QueryTrait
 * @package App\Traits
 */
trait QueryTrait
{
    // получение вложенных записей по условию, заменяет 2 метода это whereHas and with
    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }


    /***
     * Проверка активности
     * @param $query
     * @return mixed
     */
    public function scopeActive($query, $active = true)
    {
        return $query->where('active', $active);
    }


    /***
     * Проверка что перевод опубликован
     * @param $query
     * @param null $lang
     * @return mixed
     */
    public function scopePublished($query, $lang = null)
    {
        $lang = $lang ?? app()->getLocale();

        return $query->whereTranslation('publish',true, $lang);
    }
}
