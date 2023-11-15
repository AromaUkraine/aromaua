<?php

namespace App\Http\Controllers\Web;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Modules\Catalog\Entities\ProductCategory;

class CatalogController extends Controller
{
    public function index(Page $page)
    {
        $categories = ProductCategory::joinPage()
            ->withGallery()
            ->whereNull('parent_id')
            ->paginate(20);

        return view('web.catalog.index', compact('page', 'categories'));
    }
}
