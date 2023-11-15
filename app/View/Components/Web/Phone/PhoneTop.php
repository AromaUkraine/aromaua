<?php

namespace App\View\Components\Web\Phone;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class PhoneTop extends WebComponents
{
    public $phones;

    public function __construct()
    {
        // получаем все телефоны
        $this->phones = app()->settings->group('contact-phones', true);
    }

    public function getNumber($phone){
        return $phone->translateOrDefault()->value;
    }

    public function getLink($phone)
    {
        return parent::getPhoneLink($phone->translateOrDefault()->value);
    }

    public function getTrans($phone){
        return __('web.'.$phone->key);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.phone.phone-top');
    }
}
