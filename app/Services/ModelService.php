<?php


namespace App\Services;


use App\Models\EntityComponent;

class ModelService
{
    private $record = null;

    private function setRecord($table)
    {
        $this->record = EntityComponent::where('table',$table)->first();
    }

    protected function getRecord()
    {
        return $this->record;
    }


    public function getClassFromTable($table)
    {
        $this->setRecord($table);

        if($this->record) :
            $class = $this->record->model;

            if(class_exists($class)) :
                if( is_subclass_of($class, 'Illuminate\Database\Eloquent\Model' ) ) :
                    $model = new $class;
                    if ($model->getTable() === $table)
                        return $class;
                endif;
            endif;

        endif;

       /* foreach( get_declared_classes() as $class ) {
            if( is_subclass_of( $class, 'Illuminate\Database\Eloquent\Model' ) ) {
                $model = new $class;
                if ($model->getTable() === $table)
                    return $class;
            }
        }*/
        return false;
    }

    /**
     * Возвращает запить найденую по имени таблицы и id
     * @param $table
     * @param $id
     * @return mixed
     */
    public function findEntityByTableId($table, $id)
    {
        // находим модель по имени таблицы в базе данных
        $class = $this->getClassFromTable($table);

        return $class::findOrFail($id);
    }


    /**
     * @param string $field
     * @param string|null $class
     * @param object|null $model
     * @param string|null $table
     * @return bool
     */
    public function checkIsFieldExist( string $field,  ?object $model=null, ?string $class = null, ?string $table = null) :bool
    {
        if(!$model) :

            if($class)
                $model = new $class;

            if($table) :
                $class = $this->getClassFromTable($table);

                if($class)
                    $model = new $class;
            endif;

        endif;


        if($model) :

            $fields = $model->getFillable();
            return in_array($field, $fields);

        endif;

        return false;
    }
}
