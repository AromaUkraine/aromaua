<?php

namespace Modules\Synchronize\Listeners\Api;

use App\Models\Language;
use App\Events\CreateLanguageEvent;
use App\Events\UpdateLanguageEvent;

use Modules\Synchronize\Service\ReadJsonFileService;

class LangSynchronizeListener
{

    protected $file = 'lang.json';

    protected $file_path = '';


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $this->file_path = $event->getPath($this->file); //$event->path . DIRECTORY_SEPARATOR .  . $this->file;

        $data = app(ReadJsonFileService::class)->make($this->file_path);

        // программист присылает языки обернутые ключом lng в массиве
        if ($data && isset($data[0]['lng'])) {

            $this->createOrUpdateLanguage($data[0]['lng'], $event);
        }

        // список всех локалей на сайте, для дальнейших добавлений переводов
        $event->locales = app()->languages->all()->slug();
    }


    protected function createOrUpdateLanguage($data, $event)
    {
        // сохраняем (обновляем) сами языки
        foreach ($data as $key => $item) {

            if (isset($item['short_code']) && isset($item['name']) && is_array($item['name'])) {

                $short_code = $event->setUkranianValidCode($item['short_code']);

                $lang = [
                    'short_code' => $short_code,
                    'icon' => $short_code,
                    'active' => $item['active'] ?? true
                ];

                $language = Language::where('short_code', $short_code)->first();

                if (!$language) {
                    Language::create($lang);
                    event(new CreateLanguageEvent($short_code));
                } else {
                    $language->update($lang);
                }
            }
        }


        // сохраняем (обновляем) переводы для языков
        foreach ($data as $key => $item) {
            if (isset($item['short_code']) && isset($item['name']) && is_array($item['name'])) {


                $short_code = $event->setUkranianValidCode($item['short_code']);

                $language = Language::where('short_code', $short_code)->first();

                if ($language) {
                    $translateData = $this->makeTranslateData($short_code, $item['name'], $event);
                    $language->update($translateData);
                }
            }
        }

        event(new UpdateLanguageEvent());
    }

    protected function makeTranslateData($short_code, $data, $event)
    {

        $result = [];
        foreach ($data as $short_name => $name) {

            $short_name = $event->setUkranianValidCode($short_name);

            $result[$short_name] = [
                'name' => trim($name),
                'short_name' => trim($short_code)
            ];
        }

        return $result;
    }
}
