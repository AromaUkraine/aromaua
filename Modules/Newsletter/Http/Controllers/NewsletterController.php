<?php

namespace Modules\Newsletter\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Newsletter\DataTables\NewsletterDataTable;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(NewsletterDataTable $dataTable)
    {
        return $dataTable->render('newsletter::index');
    }
}