<?php


namespace Modules\Developer\Http\Controllers;


use App\Models\Menu;
use App\Services\PublishAttribute;
use Modules\Developer\DataTables\FrontendMenuRootDataTable;
use Modules\Developer\Http\Requests\FrontendMenuRootRequest;

class FrontendMenuRootController
{
    public function index(FrontendMenuRootDataTable $dataTable)
    {
        return $dataTable->render('developer::frontend_menu.index');
    }

    public function create()
    {
        return view('developer::frontend_menu.create');
    }

    public function store(FrontendMenuRootRequest $request)
    {
        $data = app(PublishAttribute::class)->make($request->all());

        Menu::create($data);
        toastr()->success(__('toastr.created.message'));

        return redirect(route('developer.frontend_menu_root.index'));
    }

    public function edit(Menu $menu)
    {
        return view('developer::frontend_menu.edit', compact('menu'));
    }


    public function update(FrontendMenuRootRequest $request, Menu $menu)
    {
        $data = app(PublishAttribute::class)->make($request->all());
        $menu->update($data);
        toastr()->success(__('toastr.updated.message'));

        return redirect(route('developer.frontend_menu_root.index'));
    }



    public function destroy(Menu $menu)
    {
        $menu->children->each->delete();
        $menu->forceDelete();

        return response()->json(['message'=>__('toastr.deleted.message')]);
    }
}
