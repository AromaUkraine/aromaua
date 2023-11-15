<?php

namespace App\Http\Controllers\Cms;

use App\DataTables\LanguageDataTable;
use App\Events\CreateLanguageEvent;
use App\Events\UpdateLanguageEvent;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Listeners\ResetCachePagesRouteListener;
use App\Models\Language;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param LanguageDataTable $dataTable
     * @return mixed
     */
    public function index(LanguageDataTable $dataTable) {

        return $dataTable->render(PermissionHelper::CMS.'.language.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view(PermissionHelper::CMS.'.language.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param LanguageRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LanguageRequest $request)
    {
        $language = Language::create($request->all());

        event( new CreateLanguageEvent($language->short_code) );

        toastr()->success(__('toastr.created.message'));

        return redirect( route('admin.language.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Language $language
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $language = Language::withTrashed()->find($id);

        return view(PermissionHelper::CMS.'.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LanguageRequest $request
     * @param Language $language
     * @return \Illuminate\Routing\Redirector
     */
    public function update(LanguageRequest $request, Language $language)
    {
        $language->update($request->all());

        event(new UpdateLanguageEvent());

        toastr()->success(__('toastr.updated.message'));

        return redirect( route('admin.language.index'));
    }


    public function active(Language $language)
    {
        $language->update(['active'=>!$language->active]);

        event(new UpdateLanguageEvent());

        return response()->json(['message'=>__('toastr.updated.message')]);
    }
}
