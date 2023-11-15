<?php

namespace App\View\Components\Web\Contact;

use App\View\Components\Web\WebComponents;


class ContactFooter extends WebComponents
{
    
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->items = app()->settings->group('footer-contact');
    }

    public function getValue($key)
    {
        $this->items->each(function ($item) use ($key, &$value) {
            if ($item->key === $key) {
                $value = $item->translateOrDefault()->value;
            }
        });
        return $value;
    }

    public function getLink($key)
    {
        $phone = $this->getValue($key);
        return parent::getPhoneLink($phone);
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.contact.contact-footer');
    }
}
