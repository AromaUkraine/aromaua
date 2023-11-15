<?php

namespace App\Models;

use App\Traits\JsonDataTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    //
    use JsonDataTrait;

    use Cachable;

    public $timestamps = false;

    protected $fillable = ['name','alias','description','type','data'];

}
