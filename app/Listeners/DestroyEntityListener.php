<?php

namespace App\Listeners;

use App\Models\EntityComponent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use ReflectionClass;

class DestroyEntityListener
{
    private $softDelete;
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {

        if(!$event->entity)
            return;

        try{
            \DB::beginTransaction();

            $this->softDelete = $event->softDelete ?? true;


            // если у записи есть страница - удаляем страницу
            if($event->entity->page) :
                $this->destroy($event->entity->page);
            endif;

            // если у записи есть компоненты - удаляем компоненты
            $entity_components = $this->findEntityComponents($event->entity);


            if($entity_components->count()) :
                $this->destroyEntityComponents($event->entity, $entity_components);
            endif;

           // dump($this->getAllRelations($event->entity));

            // удаляем саму запись
            $this->destroy($event->entity);

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }



    private function destroy($record)
    {
        if($this->softDelete):
            $record->delete();
        else :
            $record->forceDelete();
        endif;
    }



    private function destroyEntityComponents($entity, $entity_components)
    {
        // проходимся по всем компонентам подключенным записи
        foreach ($entity_components as $component)
        {
            // поле relation в таблице entity_components содержит имя метода для связи записи с компонентом
            $relation = $component->relation;

            // проверка существования метода-связи
            if(method_exists($entity, $relation))
            {

                // удаляем записи в модели компонента только если удаляется сама запись
                if($entity->$relation->count()):

                    // если записей несколько - запускаем цикл
                    if( is_array( $entity->$relation->toArray() ) ):

                        foreach ($entity->$relation as $rel){

                            $this->destroy($rel);
                        }

                    else:

                        $this->destroy($entity->$relation);

                    endif;

                endif;
            }
        }
    }

    private function destroyEntity($entity, $softDelete)
    {
        if($softDelete) :
            $entity->delete();
        else :
            $entity->forceDelete();
        endif;
    }


    private function findEntityComponents($entity)
    {
        return EntityComponent::where('table', $entity->getTable())->get();
    }


    public function getAllRelations(\Illuminate\Database\Eloquent\Model $model = null, $heritage = 'all')
    {
        $model = $model ?: $this;
        $modelName = get_class($model);
        $types = ['children' => 'Has', 'parents' => 'Belongs', 'all' => ''];
        $heritage = in_array($heritage, array_keys($types)) ? $heritage : 'all';
//        if (\Illuminate\Support\Facades\Cache::has($modelName."_{$heritage}_relations")) {
//            return \Illuminate\Support\Facades\Cache::get($modelName."_{$heritage}_relations");
//        }

        $reflectionClass = new \ReflectionClass($model);
        $traits = $reflectionClass->getTraits();    // Use this to omit trait methods


        dump($traits);
        $traitMethodNames = [];
        foreach ($traits as $name => $trait) {
            $traitMethods = $trait->getMethods();
            foreach ($traitMethods as $traitMethod) {
                $traitMethodNames[] = $traitMethod->getName();
            }
        }
        dump($traitMethodNames);

        // Checking the return value actually requires executing the method.  So use this to avoid infinite recursion.
        $currentMethod = collect(explode('::', __METHOD__))->last();
        $filter = $types[$heritage];
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);  // The method must be public
        $methods = collect($methods)->filter(function ($method) use ($modelName, $traitMethodNames, $currentMethod) {
            $methodName = $method->getName();
            if (!in_array($methodName, $traitMethodNames)   //The method must not originate in a trait
                && strpos($methodName, '__') !== 0  //It must not be a magic method
                && $method->class === $modelName    //It must be in the self scope and not inherited
                && !$method->isStatic() //It must be in the this scope and not static
                && $methodName != $currentMethod    //It must not be an override of this one
            ) {
                $parameters = (new \ReflectionMethod($modelName, $methodName))->getParameters();
                return collect($parameters)->filter(function ($parameter) {
                    return !$parameter->isOptional();   // The method must have no required parameters
                })->isEmpty();  // If required parameters exist, this will be false and omit this method
            }
            return false;
        })->mapWithKeys(function ($method) use ($model, $filter) {
            $methodName = $method->getName();
            $relation = $model->$methodName();  //Must return a Relation child. This is why we only want to do this once
            if (is_subclass_of($relation, \Illuminate\Database\Eloquent\Relations\Relation::class)) {
                $type = (new \ReflectionClass($relation))->getShortName();  //If relation is of the desired heritage
                if (!$filter || strpos($type, $filter) === 0) {
                    return [$methodName => get_class($relation->getRelated())]; // ['relationName'=>'relatedModelClass']
                }
            }
            return false;   // Remove elements reflecting methods that do not have the desired return type
        })->toArray();

        \Illuminate\Support\Facades\Cache::forever($modelName."_{$heritage}_relations", $methods);
        return $methods;
    }
}
