<?php

namespace Modules\Information\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class InformationTranslation extends Model
{
    use Cachable;

    protected $fillable = ['title', 'name', 'description', 'text', 'publish'];
}
