<?php

namespace App\Models;



use App\Traits\Sortable;
use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Venturecraft\Revisionable\RevisionableTrait;


class Language extends Model implements TranslatableContract
{

    use Translatable,
        SoftDeletes,
        Cachable,
        Sortable;


    public $translatedAttributes = ['name','short_name'];

    protected $fillable = ['short_code','icon','sort', 'active'];

    protected $dates = ['deleted_at'];

    // configuration logger
    protected $historyLimit = 500; // устанавливает лимит записей этой модели
    protected $revisionCleanup = true; // перезаписывает старые записи после достижения лимита
    protected  $revisionCreationsEnabled = true ; // логирует создание записи


    protected static function boot()
    {
        parent::boot();

        Language::creating(function ($model) {
            $model->icon = (!$model->icon) ? $model->short_code : $model->icon;
            $model->order = Language::max('order') + 1;
        });
    }


    public function scopeActive()
    {
        return $this->whereActive(true);
    }


    protected static function booted()
    {
        static::addGlobalScope(new OrderScope());
    }
}
