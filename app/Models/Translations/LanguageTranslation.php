<?php

namespace App\Models\Translations;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class LanguageTranslation extends Model
{
    use Cachable;

    public $timestamps = false;

    protected $fillable = ['name','short_name'];

    // configuration logger
    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
}
