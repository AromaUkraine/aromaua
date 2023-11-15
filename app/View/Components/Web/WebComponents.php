<?php


namespace App\View\Components\Web;


use Carbon\Carbon;
use App\Models\Page;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use App\Services\WebpService;
use App\Services\ImageService;
use Illuminate\View\Component;

class WebComponents extends Component
{

    public function render()
    {
        return null;
    }

    public function getMainRoute()
    {
        return \Route::has('main') ? route('page', 'main') : url('/');
    }

    protected function getMainPage()
    {
        return Page::whereTranslation('slug', 'main')->first();
    }

    public function getTitle()
    {
        return __('web.go_to_page');
    }


    // содает webp ссылку для картинок
    public function getWebp($image)
    {
        if($image){
            return app(WebpService::class)->make($image);
        }
        return '';
    }

    public function getBigImage($image)
    {
        return app(ImageService::class)->makeBigImage($image);
    }

    public function getDate($item, $field, $format = 'd.m.Y')
    {
        if (isset($item->$field)) {
            return Carbon::parse($item->$field)->format($format);
        }
    }

    public function cropWords($string, $words = 20,  $atEnd = '...')
    {
        return \Str::words($string, $words) . $atEnd;
    }

    public function cropSymbols($string, $symbols = 20, $atEnd = '...')
    {
        return \Str::limit($string, $symbols) . $atEnd;
    }

    public function getPreviewWebpImage($item)
    {
        if ($item->gallery->count()) :
            return $this->getWebp($item->gallery->first()->image);
        endif;

        return null;
    }



    public function getPreviewImage($item)
    {
        if ($item->gallery->count()) :
            return $item->gallery->first()->image;
        endif;

        return null;
    }

    public function getPhoneLink($phone): string
    {
        return "tel:+" . preg_replace('~\D~', '', $phone);
    }


    public function getRoute($slug)
    {
        if (!$slug)
            return "#";

        if ($slug == 'main') {
            return route('page');
        }
        return route('page', $slug);
    }

    /**
     * Возвращает slug текущей страницы (без языка)
     * @return \Illuminate\Support\Stringable
     */
    public function getCurrentPageSlug()
    {
        if (app()->getLocale() !== config('app.fallback_locale')) {
            $trim = app()->getLocale() . '/';
        } else {
            $trim = '/';
        }
        return \Str::of(request()->getPathInfo())->ltrim($trim);
    }


    /**
     * Undocumented function
     *
     * @param string|null $text
     * @param array $allowed_tags
     * @return string
     */
    public function stripTags(?string $text, $allowed_tags = ['<span>']): string
    {
        return ($text) ? strip_tags($text, $allowed_tags) : '';
    }

    public function setImageOrDefault($model, $name)
    {
        if(!$model)
            return null;

        $image = null;
        if($model->hasTranslation()){
            $image = $model->translateOrDefault()->$name;
        }else{
            $image = $model->$name;
        }
        return asset($image);
    }

    public function getDefaultProductImage($product)
    {
        $path = "/uploads/photos/products/{$product->product_code}.jpg";
        $public_path = public_path($path);
        if (\Illuminate\Support\Facades\File::exists($public_path)) {
            return $path;
        } else {
            return false;
        }

    }
}
