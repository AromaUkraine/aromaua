<?php

namespace Modules\Gallery\Http\Controllers;

use App\Events\DestroyEntityEvent;
use App\Models\Page;
use App\Services\ModelService;
use App\Services\PublishAttribute;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\DataTables\GalleryDataTable;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Events\CreatePhotoGalleryEvent;
use Modules\Gallery\Events\CreateVideoGalleryEvent;
use Modules\Gallery\Events\UpdatePhotoGalleryEvent;
use Modules\Gallery\Events\UpdateVideoGalleryEvent;
use Modules\Gallery\Http\Requests\GalleryRequest;


class GalleryController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param $table
     * @param $id
     * @param GalleryDataTable $dataTable
     * @return void
     */
    public function index( $table, $id, GalleryDataTable $dataTable)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return $dataTable->render('gallery::default.index', compact('table','id', 'entity'));
    }

    /**
     * Show the form for creating a new resource.
     * @param $type
     * @param $table
     * @param $id
     * @return Renderable
     */
    public function create( $table, $id, $type)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('gallery::default.create', compact('table','id', 'type', 'entity'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @param $table - имя таблицы в базе данных (к кому будет прикрепленна гпллерея)
     * @param $id - id записи к которой создается галлерея
     * @param $type - тип записи в галлереи (фото, видео)
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(GalleryRequest $request, $table, $id,  $type)
    {

        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        if($type && $type === Gallery::TYPE_VIDEO)
            event( new CreateVideoGalleryEvent( $request->all(), $entity) );

        if($type && $type === Gallery::TYPE_PHOTO)
            event( new CreatePhotoGalleryEvent( $request->all(), $entity) );

        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.gallery.index',[$table, $id]));

    }

    /**
     * Show the form for editing the specified resource.
     * @param $table
     * @param int $id
     * @param Gallery $gallery
     * @return Renderable
     */
    public function edit( $table, $id, Gallery $gallery )
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);


        return view('gallery::default.edit',compact('table','id',  'entity', 'gallery'));
    }


    /**
     * Update gallery entity
     * @param GalleryRequest $request
     * @param $table
     * @param $id
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(GalleryRequest $request, $table, $id, Gallery $gallery)
    {

        if($gallery->type === Gallery::TYPE_VIDEO)
            event( new UpdateVideoGalleryEvent( $request->all(), $gallery) );

        if($gallery->type === Gallery::TYPE_PHOTO)
            event( new UpdatePhotoGalleryEvent( $request->all(), $gallery) );

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.gallery.index',[$table, $id]));
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


    public function restore( $table, $id, $item_id)
    {
        $gallery = Gallery::withTrashed()->findOrFail($item_id);
        $gallery->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.gallery.index',[$table, $id]));
    }
}
