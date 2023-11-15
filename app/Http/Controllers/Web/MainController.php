<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Transliterate;

class MainController extends Controller
{
    public function index(Page $page )
    {
        return view('web.main.index', compact('page'));
    }
}
