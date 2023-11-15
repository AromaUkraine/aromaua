<?php

namespace App\View\Components\Cms\Fields;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class Select extends BaseCmsComponent
{


    public function render() {
        return view('components.cms.fields.select');
    }

}

