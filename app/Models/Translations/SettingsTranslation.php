<?php

namespace App\Models\Translations;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class SettingsTranslation extends Model
{
    use Cachable;

    public $fillable = ['default', 'value'];
}
