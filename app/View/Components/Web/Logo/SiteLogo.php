<?php

namespace App\View\Components\Web\Logo;

use App\Services\PictureService;
use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class SiteLogo extends WebComponents
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public $href;
    public $logo;

    public $image;

    public $webp;
    /**
     * @var mixed
     */
    public $options;

    /**
     * Create a new component instance.
     *
     * @param $key
     * @param null $href
     * @param null $options
     */
    public function __construct($key, $href=null, $options = null)
    {
        if($options)
            $this->options = json_decode($options, true);

        $lang = '';
        if(app()->getLocale() !== config('app.fallback_locale'))
            $lang = app()->getLocale();

        if(!$href)
            $this->href = \Route::has('main') ? route('main') : url('/'.$lang);

        $this->logo = app()->settings->key($key);
        $this->image = $this->logo->translateOrDefault()->value;
        $this->webp = $this->getWebp($this->image);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.logo.site-logo');
    }

}
