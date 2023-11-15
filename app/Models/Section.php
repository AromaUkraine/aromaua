<?php

namespace App\Models;


use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    use Cachable;

    protected $fillable = ['template_id', 'active'];

    protected $dates = ['deleted_at'];


    // Связь с таблицей Template
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function scopeActive($query)
    {
        return $query->whereActive(true);
    }

}
