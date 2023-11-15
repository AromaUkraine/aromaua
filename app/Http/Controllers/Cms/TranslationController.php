<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Barryvdh\TranslationManager\Manager;
use Barryvdh\TranslationManager\Models\Translation;

class TranslationController extends Controller
{
    /** @var \Barryvdh\TranslationManager\Manager  */
    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param null $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($group = null)
    {

        $locales = config('translatable.locales');

        $groups = Translation::groupBy('group');

        $excludedGroups = $this->manager->getConfig('exclude_groups');

        if($excludedGroups){
            $groups->whereNotIn('group', $excludedGroups);
        }

        $groups = $groups->select('group')->orderBy('group')->get()->pluck('group', 'group');

        if ($groups instanceof Collection) {
            $groups = $groups->all();
        }

        $numChanged = Translation::where('group', $group)->where('status', Translation::STATUS_CHANGED)->count();
        $allTranslations = Translation::where('group', $group)->orderBy('id', 'desc')->orderBy('key', 'asc')->get();
        $numTranslations = count($allTranslations);
        $translations = [];

        foreach($allTranslations as $translation){
            $translations[$translation->key][$translation->locale] = $translation;
        }

        if($group && !in_array($group, $groups)){
            $groups[$group] = $group;
        }

        return view('cms.translation.index')->with([
            'numTranslations'=>$numTranslations,
            'translations'=>$translations,
            'numChanged'=>$numChanged,
            'locales'=>$locales,
            'groups'=>$groups,
            'group'=>$group,
        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish($group = '*') {

        $json = false;

        if($group === '_json'){
            $json = true;
        }

        $this->manager->exportTranslations($group, $json);

        \Illuminate\Support\Facades\Artisan::call('trans:json');

        toastr()->success( __("toastr.updated.message"), __("translation.Done importing!") );

        return response()->json(['status' => 'ok']);
    }

    /**
     * Show index by group
     * @param null $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($group = null){
        return $this->index($group);
    }

    public function store(){

        \Artisan::call('translations:import');

        toastr()->success( __("toastr.updated.message"), __("translation.Done importing!") );
        return response()->json(['status' => 'ok']);
    }

    public function create($group = null){

        $keys = explode("\n", request()->get('keys'));

        foreach($keys as $key){
            $key = trim($key);
            if($group && $key){
                $this->manager->missingKey('*', $group, $key);
            }
        }
        return response()->json(['status' => 'ok']);
    }


    public function update( $group = null)
    {
        if(!in_array($group, $this->manager->getConfig('exclude_groups'))) {
            $name = request()->get('name');
            $value = request()->get('value');

            list($locale, $key) = explode('|', $name, 2);
            $translation = Translation::firstOrNew([
                'locale' => $locale,
                'group' => $group,
                'key' => $key,
            ]);
            $translation->value = (string) $value ?: null;
            $translation->status = Translation::STATUS_CHANGED;
            $translation->save();
            return response()->json(['status' => 'ok']);
        }
    }



    public function destroy( Translation $translation)
    {
        $translation->delete();
        toastr()->success( __('toastr.deleted.message') );
        return response()->json(['status' => 'ok']);

    }
}
