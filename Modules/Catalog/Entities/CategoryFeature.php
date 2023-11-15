<?php


namespace Modules\Catalog\Entities;


use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryFeature extends Model
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    public $timestamps = false;

    // автоматическое кеширование
//    use Cachable;

    protected $fillable = ['categorable_type', 'categorable_id', 'feature_id'];

    protected $dates = ['deleted_at'];

    public function categorable()
    {
        return $this->morphTo();
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }



}
