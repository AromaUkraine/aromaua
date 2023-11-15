<?php

namespace App\Http\Controllers\Cms;

use App\DataTables\FrontendMenuPageDataTable;
use App\Events\CreateFrontendMenuItemEvent;
use App\Events\PushTreeToMenuTreeEvent;
use App\Events\UpdateFrontendMenuItemEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\FrontendMenuRequest;
use App\Http\Resources\FrontendMenuResource;
use App\Http\Resources\MenuResource;
use App\Listeners\ResetCacheFrontendMenuListener;
use App\Models\Menu;
use App\Models\Page;
use App\Services\PublishAttribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;
use Modules\Developer\Entities\Template;

class FrontendMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\View\View
     */
    public function index()
    {
        if(isset(request()->parent_id) ) {
            $menu = null;
            if( request()->parent_id == 0 ) {

                $query = Menu::with(['permission'])
                    ->frontend()
                    ->defaultOrder()
                    ->translated()
                    ->newQuery();

                $menu = $query->get()->toTree();
            }

            if(collect($menu)->count()){
               return FrontendMenuResource::collection($menu);
            }
            return $menu;
        }

        return view('cms.menu.frontend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Menu $menu
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Menu $menu, FrontendMenuPageDataTable $dataTable)
    {

        return $dataTable->render('cms.menu.frontend.create');
    }


    public function addTree(Request $request)
    {


        if($request->has('model') &&  $request->has('root_id')):

            $root = Menu::where('id', $request->root_id)->first();

            if(!$root)
                return response()->json(['message'=>__('Не выбран пункт меню')], 403);

            $model = new $request->model;
            $root = Menu::where('id', $request->root_id)->firstOrFail();
            $tree = $model->with(['page'])->get()->toTree();

            event(new PushTreeToMenuTreeEvent($root, $tree));

            return response()->json(['message'=>__('toastr.updated.message')]);
        endif;

    }
    /**
     * Store a newly created resource in storage.
     * @param Menu $menu
     * @param Page $page
     * @param $status
     * @return JsonResponse
     */
    public function store(Menu $menu, Page $page, $status)
    {
        event( new UpdateFrontendMenuItemEvent($menu, $page, $status) );
        return response()->json(['message'=>__('toastr.updated.message')]);
    }


    public function edit(Menu $menu)
    {
        return view('cms.menu.frontend.edit',compact('menu'));
    }

    public function update(FrontendMenuRequest $request, Menu $menu)
    {

        $menu->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return view('cms.menu.frontend.index');
    }

    /**
     * @param Menu $menu
     * @return JsonResponse
     */
    public function active(Menu $menu)
    {
        $menu->update(['active'=>!$menu->active]);

        (new ResetCacheFrontendMenuListener())->handle();

        return response()->json(['message'=>__('toastr.updated.message')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Menu $menu)
    {
        $menu->children->each->delete();
        $menu->forceDelete();

        return response()->json(['message'=>__('toastr.deleted.message')]);
    }
}
