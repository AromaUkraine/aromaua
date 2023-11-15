<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


class HomeController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view('cms.home.index');
    }
}
