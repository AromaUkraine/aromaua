<?php


namespace Modules\Developer\Http\Controllers;


use App\DataTables\PageDataTable;
use App\Events\CreatePageEvent;
use App\Events\DestroyPageEvent;
use App\Events\ToggleActivePageEvent;
use App\Events\UpdatePageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use Modules\Developer\Entities\Template;

class PageController extends Controller
{

    public function index(PageDataTable $dataTable)
    {
        return $dataTable->render('developer::page.index');
    }

    public function create()
    {
        $templates = Template::all();
        return view('developer::page.create', compact( 'templates'));
    }

    public function store(PageRequest $request)
    {
        event(new CreatePageEvent($request->all()));

        toastr()->success(__('toastr.created.message'));

        return redirect(route('developer.page.index'));
    }

    public function edit(Page $page)
    {
        $templates = Template::all();
        return view('developer::page.edit', compact('page', 'templates'));
    }

    public function update(PageRequest $request, Page $page)
    {
        event(new UpdatePageEvent($request->all(), $page));

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('developer.page.index'));
    }

    public function active(Page $page)
    {
        event(new ToggleActivePageEvent($page));

        return response()->json(['message'=>__('toastr.updated.message')]);
    }

    public function destroy(Page $page)
    {
        event(new DestroyPageEvent( $page ));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }
}
