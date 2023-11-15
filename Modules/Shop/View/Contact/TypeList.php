<?php

namespace Modules\Shop\View\Contact;

use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\View\Component;
use Modules\Shop\Entities\EntityContact;

class TypeList extends Component
{

    public $model;

    public $label;

    public $name;

    public $options;

    public $items = [
        'phone'=>'phone',
        'email'=>'email',
    ];

    public function __construct($model = null, $label = '', $name='', $options = null)
    {
        $this->items = (new EntityContact())->static_types;
        $this->model = $model;
        $this->label = $label;
        $this->name = $name;
        $this->options = $options;
    }

    public function render()
    {
        return view('shop::components.contact.item-list');
    }

    public function setSelected($item)
    {
        if($this->model && $this->model->type === $item):
            return 'selected';
        endif;

        return '';
    }
}
