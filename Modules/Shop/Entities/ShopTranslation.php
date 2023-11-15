<?php

namespace Modules\Shop\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ShopTranslation extends Model
{
    use Cachable;

    protected $fillable = ['name', 'address', 'info', 'schedule', 'publish'];
}
