<?php

namespace Modules\Catalog\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class FeatureValueTranslation extends Model
{
    use Cachable;

    protected $fillable = ['name','publish'];
}
