<?php


namespace Modules\Gallery\Http\Controllers;


use App\Events\DestroyEntityEvent;
use App\Models\Page;
use App\Services\ModelService;
use App\Services\PublishAttribute;
use Modules\Gallery\DataTables\EntityGalleryDataTable;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Events\CreatePhotoGalleryEvent;
use Modules\Gallery\Events\CreateVideoGalleryEvent;
use Modules\Gallery\Events\UpdatePhotoGalleryEvent;
use Modules\Gallery\Events\UpdateVideoGalleryEvent;
use Modules\Gallery\Http\Requests\GalleryRequest;

class EntityGalleryController
{

    /**
     *  Display a listing of the resource.
     * @param Page $page
     * @param $table
     * @param $id
     * @param EntityGalleryDataTable $dataTable
     * @return mixed
     */
    public function index(Page $page, $table, $id, EntityGalleryDataTable $dataTable)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return $dataTable->render('gallery::entity.index', compact('page','entity', 'table', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Page $page
     * @param $table
     * @param $id
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Page $page, $table, $id, $type)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('gallery::entity.create', compact('page','table', 'id', 'type', 'entity'));
    }


    /**
     * Store a newly created resource in storage.
     * @param GalleryRequest $request
     * @param Page $page
     * @param $table
     * @param $id
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(GalleryRequest $request, Page $page,  $table, $id,  $type)
    {
        // подготавливаем данные для сохранения
        $data = app(PublishAttribute::class)->make($request);

        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        if($type && $type === Gallery::TYPE_VIDEO)
            event( new CreateVideoGalleryEvent( $data, $entity) );

        if($type && $type === Gallery::TYPE_PHOTO)
            event( new CreatePhotoGalleryEvent( $data, $entity) );

        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.entity_gallery.index',compact('page', 'table', 'id')));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Page $page
     * @param $table
     * @param $id
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( Page $page, $table, $id, Gallery $gallery)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('gallery::entity.edit',compact('page', 'table','id', 'entity', 'gallery'));
    }


    /**
     * Update gallery entity
     * @param GalleryRequest $request
     * @param Page $page
     * @param $table
     * @param $id
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(GalleryRequest $request, Page $page, $table, $id, Gallery $gallery)
    {
        // подготавливаем данные для сохранения
        $data = app(PublishAttribute::class)->make($request);

        if($gallery->type === Gallery::TYPE_VIDEO)
            event( new UpdateVideoGalleryEvent( $data, $gallery) );

        if($gallery->type === Gallery::TYPE_PHOTO)
            event( new UpdatePhotoGalleryEvent( $data, $gallery) );

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.entity_gallery.index',compact('page', 'table', 'id')));
    }

    /**
     * Enabled / disabled article
     * @param Gallery $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(Gallery $gallery)
    {
        $gallery->update(['active'=>!$gallery->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }


    /**
     * @param Gallery $gallery
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Gallery $gallery)
    {
        // событие удаления записи, по параметру softDelete, удаления если есть связанной страницы и связанных компонентов
        event(new DestroyEntityEvent($gallery, config('banner.softDelete') ?? false));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }

    public function restore( Page $page, $table, $id, $item_id)
    {
        $gallery = Gallery::withTrashed()->findOrFail($item_id);
        $gallery->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.entity_gallery.index',compact('page', 'table', 'id')));
    }

}