<?php

namespace App\Models\Translations;

use App\Models\Page;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;


class PageTranslation extends Model
{
    use Cachable;

    public $fillable = [
        'name',
        'slug',
        'text',
        'description',
        'h1',
        'title',
        'meta_description',
        'meta_keywords',
        'breadcrumbs',
        'anchor',
        'publish',
    ];

}
