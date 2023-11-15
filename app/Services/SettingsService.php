<?php


namespace App\Services;


use App\Models\Settings;

class SettingsService
{

    protected $settings;

    protected $setting;


    protected $field = 'value';

    public function __construct()
    {
    }

    /**
     * @param string $key
     */
    public function val($key)
    {
        return $this->key($key)->value ?? null;
    }

    public function key($key, $all = false)
    {
        return Settings::where('key', $key)->first();
    }

    public function group($group, $all = false)
    {
        return Settings::where('group', $group)->get();
    }

    /**
     * Получение объекта таблицы settings вместе со значениями из таблицы переводов
     * по текущему языку или дефолтное значение, в случае если значение в таблице переводов не найдено
     *
     * @param string $key
     * @param string $field
     * @return object
     */
    public function getTranslateByKey($key, string $field = 'value')
    {
        $setting = $this->key($key);

        if (!$setting)
            return $setting;

        $setting->$field = app(TranslateOrDefaultService::class)->get($setting, $field);
        return $setting;
    }
}
