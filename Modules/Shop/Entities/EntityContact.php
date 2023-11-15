<?php

namespace Modules\Shop\Entities;


use App\Traits\Sortable;
use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class EntityContact extends Model implements TranslatableContract
{

    // Трейт для "мягкого удаления"
    use SoftDeletes;

   // Трейт для автоматического перевода
    use Translatable;

    // Трейт для автоматическое кеширование
    //use Cachable;

    // Трейт для сортировки
    use Sortable;

    const TYPE_PHONE = 'phone';
    const TYPE_EMAIL = 'email';
    const TYPE_WEBSITE = 'website';

    protected $fillable = ['contactable_type','contactable_id', 'value', 'type', 'order', 'active'];

    public  $translatedAttributes = [ 'name', 'description', 'publish'];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public $static_types = [ self::TYPE_PHONE,  self::TYPE_EMAIL,  self::TYPE_WEBSITE ];


    public function getTranslationModelName(): string
    {
        return EntityContactTranslation::class;
    }

    public function contactable()
    {
        return $this->morphTo();
    }


    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }


    protected static function booted()
    {
        static::addGlobalScope(new OrderScope());
    }


}
