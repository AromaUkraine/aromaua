<?php

namespace Modules\Synchronize\Entities;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class ProductDocumentTranslation extends Model
{

    // use Cachable;

    public $fillable = ['name', 'href', 'date', 'publish'];
}
