<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\EntityFeature;
use Modules\Catalog\Events\ProductFeatureCreateFeatureValueEvent;

class ProductFeatureUpdateFeatureValueListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {

        $product = $event->product ?? null;

        $feature_values = collect($event->feature_values ?? []);

        $feature_ids = $product->entity_features
            ->whereNotNull('feature_value_id')
            ->unique('feature_id')
            ->pluck('feature_id');


        $feature_values->map(function ($values, $feature_id) use ($product, $event, &$feature_ids) {

            // убираем из списка ипользуемые хар-ки
            $feature_ids->map(function ($item, $id) use($feature_ids, $feature_id){
               if($item === $feature_id){
                   $feature_ids->forget($id);
               }
            });

            // если у товара нет такой хар-ки
//            if (!$product->entity_features->contains('feature_id', $feature_id)) :
//                dump('create new');
//                (new ProductFeatureCreateFeatureValueListener)->handle($event);
//            endif;

            // ищем совпадения хар-ки
            $exist_by_feature_id = $product->entity_features->where('feature_id', $feature_id);

            $this->updateExist($exist_by_feature_id, $values, $feature_id, $product);

        });



        // если остались не использумые хар-ки.
        if($feature_ids->count()):
            $product->entity_features
                ->whereIn('feature_id', $feature_ids)
                ->where('modify_value', false)->map(function ($entity_feature){
                    $entity_feature->delete();
                });
        endif;


    }

    private function updateExist($exist_by_feature_id, $values, $feature_id, $product)
    {

        // если кол-во совпадает - просто меняем значение !!! Модификация не учитывается - просто меняет значения
        if ($exist_by_feature_id->count() == count($values)):
            $this->updateEntityFeature($exist_by_feature_id, $values);

        // если кол-во $exist_by_feature меньше чем $values - нужно добавить недостающие !!! Модификация не учитывается - просто меняет значения
        elseif ($exist_by_feature_id->count() < count($values)):

            $exist_values_id = [];
            foreach ($values as $key => $feature_value_id):
                // находим совпадения - уменьшаем кол-во $values, увеличиваем $exist_values_id
                if ($exist_by_feature_id->contains('feature_value_id', $feature_value_id)):
                    $exist_values_id[$key] = $feature_value_id;
                    unset($values[$key]);
                endif;
            endforeach;

            // если одна или несколько записей совпадают
            if (count($exist_values_id)) :
                // находим сколько нужно обновить
                $need_updated_entity_features = $exist_by_feature_id->whereNotIn('feature_value_id', $exist_values_id);

                // если есть записи которые можно обновить
                if ($need_updated_entity_features->count()) :

                    // массив для обновления
                    $updated_values = array_slice($values, 0, $need_updated_entity_features->count());
                    // массив для создания
                    $created_values = array_slice($values, $need_updated_entity_features->count());

                    if (count($updated_values)):
                        $this->updateEntityFeature($exist_by_feature_id, $updated_values);
                    endif;

                    if (count($created_values)):
                        $this->createEntityFeature($product, $feature_id, $created_values);
                    endif;

                // иначе просто добавляем новые
                else:
                    $this->createEntityFeature($product, $feature_id, $values);
                endif;

            // иначе нужно перезаписать не совпадающие и если останется создать новые
            else:
                // массив для обновления
                $updated_values = array_slice($values, 0, $exist_by_feature_id->count());
                // массив для создания
                $created_values = array_slice($values, $exist_by_feature_id->count());

                if(count($updated_values)):
                    $this->updateEntityFeature($exist_by_feature_id, $updated_values);
                endif;

                if(count($created_values)):
                    $this->createEntityFeature($product, $feature_id, $created_values);
                endif;

            endif;

        // если кол-во $exist_by_feature больше чем $values - одна лишняя
        elseif ($exist_by_feature_id->count() > count($values)):

            $exist_values_id = [];
            foreach ($values as $key => $feature_value_id):
                // находим совпадения - уменьшаем кол-во $values, увеличиваем $exist_values_id
                if ($exist_by_feature_id->contains('feature_value_id', $feature_value_id)):
                    $exist_values_id[$key] = $feature_value_id;
                    unset($values[$key]);
                endif;
            endforeach;


            // если появились новые и остались записи без изменения
            if (count($values) > 0 && count($exist_values_id) > 0) :

                // находим сколько нужно обновить
                $need_updated_entity_features = $exist_by_feature_id->whereNotIn('feature_value_id', $exist_values_id);

                // хар-ки для обновления
                $updated = $need_updated_entity_features->splice(count($values));

                if ($updated->count()):
                    $this->updateEntityFeature($updated, $values);
                endif;

                // оставшиеся - на удаление
                $need_updated_entity_features->map(function ($entity_feature) {
                    $entity_feature->delete();
                });


            // если $values не осталось, значит все $values - уже существуют в entity_feature,
            // осталось удалить только лишние которые не являются модификацией
            elseif(count($values) === 0) :
                $exist_by_feature_id->whereNotIn('feature_value_id', $exist_values_id)
                    ->where('modify_value', false)->map(function ($entity_feature) {
                        $entity_feature->delete();
                    });

            // если $values осталось - а $exist_values_id равно 0. Нужно проапдейтить с не верным $feature_value_id
            // и удалить лишние которые не являются модификацией
            elseif (count($values) > 0 && count($exist_values_id) == 0) :

                // находим сколько нужно обновить исключая модификацию
                $need_updated_entity_features = $exist_by_feature_id->where('modify_value', false);

                // хар-ки для обновления
                $updated = $need_updated_entity_features->splice(0, count($values));

                if ($updated->count()):
                    $this->updateEntityFeature($updated, $values);
                endif;

                // оставшиеся - на удаление
                $need_updated_entity_features->map(function ($entity_feature) {
                    $entity_feature->delete();
                });

            endif;

        endif;

    }

    // добавление
    private function createEntityFeature($product, $feature_id, $values)
    {
        foreach ($values as $key => $feature_value_id) {
            $product->entity_features()->create([
                'feature_id' => $feature_id,
                'feature_value_id' => $feature_value_id
            ]);
        }
    }

    // обновление
    private function updateEntityFeature($entity_features, $values)
    {
        // сбрасываем индексы
        $entity_features = $entity_features->values();
        $values = array_values($values);

        $entity_features->map(function ($entity_feature, $key) use ($values) {
            $entity_feature->update(['feature_value_id' => $values[$key]]);
        });

    }

    // удаление
    private function deleteEntityFeature($entity_features, $values)
    {
        $entity_features->whereNotIn('feature_value_id', $values)
            ->where('modify_value', false)->map(function ($entity_feature) {
                $entity_feature->delete();
            });
    }


}
