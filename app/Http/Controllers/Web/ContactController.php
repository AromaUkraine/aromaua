<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shop\Entities\Shop;

class ContactController extends Controller
{
    /**
     * Undocumented function
     *
     * @param Page $page
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index($page)
    {
        return view('web.contact.index', compact('page'));
    }
}
