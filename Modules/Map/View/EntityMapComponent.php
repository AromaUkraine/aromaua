<?php


namespace Modules\Map\View;


use Illuminate\View\Component;

class EntityMapComponent extends Component
{
    public $address;

    public $lat;

    public $lng;

    public $table;

    public $id;

    public $model;


    public function __construct($model, $table, $id)
    {

        $this->model = $model;
        $this->address = $model->address ?? null;
        $this->lat = $model->map->lat ?? null;
        $this->lng = $model->map->lng ?? null;

        $this->table = $table;
        $this->id = $id;
    }


    public function setRoute()
    {
        if(!$this->model->map)
           return array('module.entity_map.create', $this->table, $this->id);//array('module.entity_map.create', ['table'=>$this->table, 'id'=>$this->id]);// ('module.entity_map.create',[  ]);
        else
           return array('module.entity_map.update', $this->table, $this->id);
    }

    public function setMethod()
    {

        if(!$this->model->map)
            return 'post';
        else
            return 'patch';
    }

    public function render()
    {
        return view('map::components.entity_map.index');
    }
}
