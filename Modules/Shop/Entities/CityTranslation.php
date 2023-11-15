<?php

namespace Modules\Shop\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{
    use Cachable;

    protected $fillable = ['name','publish'];
}
