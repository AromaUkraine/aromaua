<?php

namespace Modules\Shop\Http\Controllers;

use App\Events\DestroyEntityEvent;
use Illuminate\Http\Request;
use App\Services\ModelService;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Shop\DataTables\EntityContactDataTable;
use Modules\Shop\Entities\EntityContact;
use Modules\Shop\Http\Requests\EntityContactRequest;

class EntityContactController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($table, $id, EntityContactDataTable $dataTable)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return $dataTable->render('shop::entity_contact.index',compact('entity','table','id'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        return view('shop::entity_contact.create',compact('entity','table','id'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EntityContactRequest $request, $table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        $entity->contacts()->create($request->all());
        toastr()->success(__('toastr.created.message'));

        return redirect(route('module.entity_contact.index', [$table, $id]));
    }

    /**
     * Show the form for editing the specified resource.
     * @param $table
     * @param int $id
     * @param EntityContact $contact
     * @return Renderable
     */
    public function edit( $table, $id, EntityContact $contact)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        return view('shop::entity_contact.edit', compact('contact','entity', 'table', 'id'));
    }

    /**
     * Update the specified resource in storage.
     * @param EntityContactRequest $request
     * @param $table
     * @param int $id
     * @param EntityContact $contact
     * @return \Illuminate\Contracts\Foundation\Application|Renderable|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EntityContactRequest $request, $table, $id, EntityContact $contact)
    {
        $contact->update($request->all());
        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.entity_contact.index', [$table, $id]));
    }


    public function active(EntityContact $contact)
    {
        $contact->update(['active'=>!$contact->active]);
        return response()->json(['message'=>__('toastr.updated.message')]);
    }

    /**
     * Remove the specified resource from storage.
     * @param EntityContact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EntityContact $contact)
    {
        event(new DestroyEntityEvent($contact));
        return response()->json(['message'=>__('toastr.deleted.message')]);
    }

    public function restore($table, $id, $contact_id)
    {
        $contact = EntityContact::withTrashed()->findOrFail($contact_id);
        $contact->restore();

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.entity_contact.index', [$table, $id]));
    }
}
