<?php

namespace App\View\Components\Web\Language;

use App\Models\Page;
use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class LanguageSwitcher extends WebComponents
{
    /**
     * @var string|null
     */
    public $name;
    public $languages;
    public $pageData = null;
    public $page = null;


    public function __construct($page = null)
    {
        $this->page = $page;

        // получаем все языки
        $this->languages = app()->languages->active()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.language.language-switcher');
    }


    public function getUrl($locale)
    {

        //URL предыдущей страницы
        // $referer = \Redirect::back()->getTargetUrl();

        // добавляем префикс языка
        if ($locale == config('app.fallback_locale')) {
            $url = '/';
        } else {
            $url = '/' . $locale . '/';
        }



        if (!$this->page) {

            return $url .= request()->route()->getName();
        } else {

            // если страница не является главной добавляем url страницы
            if (!$this->page->pageable->is_main) {

                // $slug = $this->pageData->translations->where('locale', $locale)->first()->slug;
                $url .= $this->page->translate($locale)->slug;
            }

            // если были еще GET-параметры - добавляем их
            /* if (parse_url($referer, PHP_URL_QUERY)) {
                $url .= '?' . parse_url($referer, PHP_URL_QUERY);
            }*/

            // Request::root()  - основной адрес сайта
            return url($url);
        }
    }


    public function getActive($lang)
    {
        return ($lang->short_code == app()->getLocale()) ? '__current' : '';
    }


    public function pageActiveAndPublish($locale)
    {

        if ($this->page->translate($locale)) {
            return $this->page->translate($locale)->publish && $this->page->active;
        }

        return false;
    }
}