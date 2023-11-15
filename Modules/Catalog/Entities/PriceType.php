<?php

namespace Modules\Catalog\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceType extends Model
{

    // Трейт "мягкого удаления"
    use SoftDeletes;

    const DEFAULT_KEY = 'default';

    // автоматическое кеширование
//    use Cachable;

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    protected $fillable = ['currency_id','name','key','active'];

    public function currency()
    {
       return $this->belongsTo(Currency::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active',true);
    }

    public function scopeDefault($query)
    {
        return $query->where('key', self::DEFAULT_KEY);
    }
}
