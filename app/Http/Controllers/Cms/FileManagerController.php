<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    //
    public function index()
    {
        return view('cms.filemanager.index');
    }

    public function view()
    {
        return view('cms.filemanager.view');
    }
}
