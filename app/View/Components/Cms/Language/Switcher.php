<?php


namespace App\View\Components\Cms\Language;


use Illuminate\View\Component;

class Switcher extends Component
{

    public $languages;
    /**
     * @var string
     */
    public $current;

    public function __construct()
    {
        $this->languages = app()->languages->all()->get();
        $this->current = app()->getLocale();
    }


    public function getFlag($short_code)
    {
        return $this->languages->where('short_code',$short_code)->first()->icon;
    }

    public function getName($short_code)
    {
        return $this->languages->where('short_code',$short_code)->first()->name;
    }



    public function render()
    {
        return view('components.cms.language.switcher');
    }
}
