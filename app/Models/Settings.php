<?php

namespace App\Models;

use App\Traits\ThumbsTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model implements TranslatableContract
{
    use Translatable;

    use SoftDeletes;

    use Cachable;

    // Трейт для миникартинок
    use ThumbsTrait;


    public $translatedAttributes = [ 'default', 'value' ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'key', 'component', 'group'];
}
