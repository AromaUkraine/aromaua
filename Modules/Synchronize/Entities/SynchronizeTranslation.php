<?php

namespace Modules\Synchronize\Entities;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class SynchronizeTranslation extends Model
{
    use Cachable;

    protected $fillable = ['name', 'metaphone_key'];
}
