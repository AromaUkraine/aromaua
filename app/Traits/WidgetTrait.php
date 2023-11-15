<?php


namespace App\Traits;

use App\Models\Page;
use App\Models\PageComponent;

/**
 * Trait WidgetTrait - трейт для работы с моделями виджетов страницы
 * @package App\Traits
 */
trait WidgetTrait
{
    /***
     * Связь со страницей
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(Page::class);
    }

    /***
     * Связь с компонентами страницы
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function component()
    {
        return $this->belongsTo(PageComponent::class,'page_component_id');
    }


//    public function scopeWithAndWhereHas($query, $relation, $constraint){
//        return $query->whereHas($relation, $constraint)
//            ->with([$relation => $constraint]);
//    }


    /**
     * Связь со страницей и компонентом по алиас
     * @param $query
     * @param $alias
     * @return mixed
     */
    public function scopeWithPageComponent($query, $alias)
    {
        return $query->whereHas('component',function($query) use($alias) {
            $query->where('alias',$alias);
        })->with(['parent']);
    }
}
