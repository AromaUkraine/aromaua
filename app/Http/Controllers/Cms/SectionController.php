<?php

namespace App\Http\Controllers\Cms;

use App\DataTables\PageDataTable;
use App\Events\CreatePageEvent;
use App\Events\DestroyPageEvent;
use App\Events\ToggleActivePageEvent;
use App\Events\UpdatePageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

use App\Listeners\ResetPagesCacheListener;
use App\Models\Page;
use App\Services\TranslateOrDefaultService;
use Modules\Developer\Entities\Template;


class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SectionDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(PageDataTable $dataTable)
    {

        return $dataTable->render('cms.section.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View

    public function create()
    {
        $templates = Template::all();
        return view('cms.section.create', compact( 'templates'));
    }
     */

    /**
     * @param PageRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector

    public function store(PageRequest $request)
    {

        event(new CreatePageEvent($request->all()));

        toastr()->success(__('toastr.created.message'));

        return redirect(route('section.section.index'));
    }
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View

    public function edit(Page $page)
    {
        $templates = Template::all();
        return view('cms.section.edit', compact('page', 'templates'));
    }
     */

    public function active(Page $page)
    {
        event(new ToggleActivePageEvent($page));

        return response()->json(['message'=>__('toastr.updated.message')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PageRequest $request
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse

    public function update(PageRequest $request, Page $page)
    {
        event(new UpdatePageEvent($request->all(), $page));

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('section.section.index'));
    }
     */

    public function destroy(Page $page)
    {
        event(new DestroyPageEvent( $page ));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }

}
