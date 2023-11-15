<?php

namespace Modules\Banner\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{

   use Cachable;

    protected $fillable = ['image','name','description','publish', 'link', 'button_name'];

}
