<?php

namespace Modules\Synchronize\Listeners\Api;

use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Entities\FeatureValue;
use Modules\Synchronize\Service\FeatureCollectionService;
use Modules\Synchronize\Traits\DatabaseLogTrait;
use Modules\Synchronize\Service\ClearDataService;
use Modules\Synchronize\Service\ReadJsonFileService;

class FeatureSynchronizeListener
{

    use DatabaseLogTrait;

    protected $file = 'features.json';

    protected $file_path = '';

    public function handle($event)
    {
        // полный путь к файлу
        $this->file_path = $event->getPath($this->file);

        // json-данные из файла
        $data = app(ReadJsonFileService::class)->make($this->file_path);

        // создаем коллекцию категории
        $collection = app(FeatureCollectionService::class)->make($data);

        $event->features = collect();
        $event->feature_values = collect();

        if ($collection->count()) {

            try {
                \DB::beginTransaction();
                $collection->each(function ($item) use ($event) {

                    // подготавливает массив данных для сохранения в базе данных
                    $data = $this->prepareDataBeforeSave($item, $event);
                    $values = $data['values'];
                    unset($data['values']);

                    $feature = $this->saveFeature($data);

                    if ($feature) {

                        $event->features->push($feature);

                        if (count($values)) {
                            foreach ($values as $value) {
                                $data = $this->prepareDataBeforeSave($value, $event);
                                $data['feature_kind_id'] = $feature->feature_kind_id;
                                $this->saveFeatureValue($data);
                            }
                        }
                    }
                });
                \DB::commit();

            } catch (\Exception $e) {
                \DB::rollback();
                $this->logToDb($e->getMessage(), $e->getTrace());
            }
        } else {

            $this->logToDb("Feature collection is empty");
        }
    }

    /**
     * Создание или обновление характеристики
     *
     * @param array $data
     * @return void
     */
    protected function saveFeature($data)
    {
        try {

            // ищем в базе данных характеристику по code_1c
            $feature = Feature::where('code_1c', trim($data['code_1c']))->first();

            if (!$feature) {

                $dataKind = $data;
                $dataKind['key'] = $this->makeFeatureKindKey($dataKind);

                $featureKind = FeatureKind::create($dataKind);

                unset($data['key']);
                $data['feature_kind_id'] = $featureKind->id;

                $feature = Feature::create($data);

            } else {
                $feature->feature_kind->update($data);
                $feature->update($data);
            }

            return $feature;
        } catch (\Exception $e) {

            $this->logToDb($e->getMessage(), $e->getTrace());
        }

        return null;
    }

    /**
     * Создание или обновление значения характеристики
     *
     * @param array $data
     * @return void
     */
    protected function saveFeatureValue($data)
    {
        try {

            // ищем в базе данных значение характеристики по code_1c
            $featureValue = FeatureValue::where('code_1c', trim($data['code_1c']))
                ->where('feature_kind_id', $data['feature_kind_id'])
                ->first();

            if (!$featureValue) {

                $featureValue = FeatureValue::create($data);

            } else {

                $featureValue->update($data);

            }

            return $featureValue;
        } catch (\Exception $e) {

            $this->logToDb($e->getMessage(), $e->getTrace());
        }

        return null;
    }



    protected function makeFeatureKindKey($data)
    {
        $key = false;
        if (isset($data['en']['name'])) {
            $key = \Transliterate::make($data['en']['name']);
        } elseif (isset($data['ru']['name'])) {
            $key = \Transliterate::make($data['ru']['name']);
        }
        if ($key) {
            $key = preg_replace("/\s+/ums", "_", strtolower($key));
        } else {
            throw new \Exception("Feature from json data doesn't have en/ru name.");
        }
        return $key;
    }

    protected function prepareDataBeforeSave($item, $event)
    {
        // ключи необходимые для синхронизации (слева названия ключей в json-файле)
        $code_1c = 'id';

        if (!isset($item[$code_1c])) {
            $this->logToDb("Feature from json data doesn't have '{$code_1c}' field.");
            return null;
        }
        $item = app(ClearDataService::class)->make($item);
        $item['code_1c'] = $item['id'];
        unset($item['id']);

        foreach ($event->locales as $locale) {
            if (isset($item[$locale])) {
                $item[$locale]['publish'] = true;
            }
        }
        $item['active'] = true;

        return $item;
    }

}
