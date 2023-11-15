<?php

namespace Modules\Catalog\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    use Cachable;

    public $timestamps = false;

    protected $fillable = ['name','short_name'];
}
