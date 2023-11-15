<?php

namespace App\Models;

use App\Scopes\OrderScope;
use App\Traits\JsonDataTrait;
use App\Traits\Sortable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    // автоматическое кеширование
    use Cachable;
    //
    use JsonDataTrait;

    // сортировка
    use Sortable;

    const TYPE_MODULE = 'module';
    const TYPE_WIDGET = 'widget';

    protected $fillable = ['name', 'alias', 'description', 'type', 'data', 'order', 'active'];


    /**
     * Связь со страницей
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     *  При создании увеличивается порядок компонентов
     */
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->order = self::max('order') + 1;
        });
    }

////    protected $primaryKey = 'alias';
    public function getRouteKeyName(){
        return 'alias';
    }

    /**
     * Возвращает результат проверки, является ли компонент виджетом
     * @return bool
     */
    public function isWidget()
    {
        return $this->type === self::TYPE_WIDGET;
    }

    /**
     * Возвращает результат проверки, является ли компонент модулем
     * @return bool
     */
    public function isModule()
    {
        return $this->type === self::TYPE_MODULE;
    }

    /**
     *
     * @return mixed
     */
    public function scopeActive()
    {
        return $this->whereActive(true);
    }


    /***
     *  Глобальный scope сортировки
     */
    protected static function booted()
    {
        static::addGlobalScope(new OrderScope());
    }
}
