<?php

namespace App\Models;

use App\Scopes\OrderScope;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;

class EntityComponent extends Model
{

    use Sortable;

    protected $fillable = ['table','model','name','slug','route_key','relation','icon','order'];

    public $timestamps = false;
    //
    public function scopeMenu($query, $table)
    {
        return $query->where('table', $table);
    }

    public function scopeRelation($query, $table)
    {
        return $query->where('table', $table)->where('relation_with_category','!=','')->first();
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

    /***
     *  Глобальный scope сортировки
     */
    protected static function booted()
    {
        static::addGlobalScope(new OrderScope());
    }
}
