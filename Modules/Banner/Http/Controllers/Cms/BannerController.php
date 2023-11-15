<?php

namespace Modules\Banner\Http\Controllers\Cms;

use App\Models\Page;
use App\Models\PageComponent;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Banner\DataTables\BannerDataTable;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Http\Requests\BannerRequest;

class BannerController extends Controller
{

    public function index( )
    {

    }


    public function create()
    {

    }

    public function store(BannerRequest $request)
    {

    }


    public function edit(Banner $banner)
    {

    }


    public function update(BannerRequest $request, Banner $banner)
    {


    }

    public function active(Banner $banner)
    {

    }


    public function destroy(Banner $banner)
    {

    }

    public function restore($id)
    {

    }
}
