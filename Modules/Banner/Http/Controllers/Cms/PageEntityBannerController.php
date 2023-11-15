<?php


namespace Modules\Banner\Http\Controllers\Cms;


use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ModelService;
use Modules\Banner\DataTables\PageEntityBannerDataTable;


class PageEntityBannerController extends Controller
{
    public function index(Page $page, $table, $id, PageEntityBannerDataTable $dataTable)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return $dataTable->render('banner::page_entity_banner.index', compact('page','entity', 'table', 'id'));
    }

    public function create(Page $page, $table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('banner::page_entity_banner.create', compact('page','table', 'id', 'type', 'entity'));
    }
}
