<?php

namespace App\Http\Controllers\Cms;


use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Models\Permission;
use App\Services\PublishAttribute;


class PagesController extends Controller
{
    public function index( Page $page )
    {
        return view('cms.page.index', compact('page'));
    }

    /**
     *  Update the specified resource in storage.
     *
     * @param PageRequest $request
     * @param Page $page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update( PageRequest $request, Page $page)
    {
        $page->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route(Permission::pageSlug($page), $page->id));
    }
}
