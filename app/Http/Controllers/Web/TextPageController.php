<?php

namespace App\Http\Controllers\Web;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Modules\Gallery\Entities\Gallery;

class TextPageController extends Controller
{
    //
    public function index(Page $page)
    {

        // галлерея на странице
        $component = $page->widgets->where('alias', 'page-gallery')->first();

        if ($component) :
            $page->text = $this->putVideoIntoText($page, $component, $page->text);
        endif;


        return view('web.text_page.index', compact('page', 'component'));
    }


    protected function putVideoIntoText($page, $component, $text)
    {
        $video = Gallery::where('parent_page_id', $page->id)
            ->where('page_component_id', $component->id)
            ->where('type', Gallery::TYPE_VIDEO)
            ->active()
            ->published()
            ->first();

        if ($video) :

            if (strpos($page->text, "<p><code>{video}</code></p>")) {
                $view = View::make("components.web.video.video-preview", compact('video', 'page'))->render();
                $page->text = str_replace('<p><code>{video}</code></p>', $view, $page->text);
            }

        endif;

        return $page->text;
    }
}