<?php

namespace App\Http\Controllers\Cms;


use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\BackendMenuResource;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Models\Role;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;


class BackendMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|View
     */
    public function index()
    {

        if (isset(request()->parent_id)) {
            $menu = [];
            if (request()->parent_id == 0) {

                $query = Menu::with(['permission'])
                    ->backend()
                    ->defaultOrder()
                    ->translated()
                    ->newQuery();

                // Разработчику доступен полный список пунков в меню, остальным же все исключая меню разработчика
                if (\Auth::user()->role->slug !== Role::DEVELOPER_ROLE) {
                    $query->where('type', '!=', Role::DEVELOPER_ROLE)
                        ->orWhereNull('type');
                }

                $menu = $query->get()->toTree();
            }

            return BackendMenuResource::collection($menu);
        }

        return view('cms.menu.backend.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('cms.menu.backend.create');
    }


    /**
     *  Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(MenuRequest $request)
    {
        $data = app(PublishAttribute::class)->make($request);
        $data['from'] = Menu::BACKEND;
        Menu::create($data);

        toastr()->success(__('toastr.created.message'));

        return redirect(route('admin.backend_menu.index'));
    }

    /**
     * @param Menu $menu
     * @return Application|Factory|View
     */
    public function edit(Menu $menu)
    {
        return view('cms.menu.backend.edit', compact('menu'));
    }


    /**
     * @param MenuRequest $request
     * @param Menu $menu
     * @return Application|RedirectResponse|Redirector
     */
    public function update(MenuRequest $request, Menu $menu)
    {

        // dd($request->all());
        $request->offsetUnset('enable');

        $menu->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.backend_menu.index'));
    }


    /**
     * @param Menu $menu
     * @return JsonResponse
     */
    public function active(Menu $menu)
    {
        $menu->update(['active' => !$menu->active]);

        return response()->json(['message' => __('toastr.updated.message')]);
    }


    /**
     *  Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json(['message' => __('toastr.deleted.message')]);
    }
}
