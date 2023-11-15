<?php

namespace Modules\Developer\Entities;

use App\Models\Page;
use App\Traits\JsonDataTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use JsonDataTrait;

    use Cachable;

    protected $casts = [
        'data' => 'array',
    ];

    public $fillable = ['name','data', 'type'];

    const RESOURCE_WEB_CONTROLLER_PATH = "App\\Http\\Controllers\\Web\\";
    const RESOURCE_CMS_CONTROLLERS_PATH = "App\\Http\\Controllers\\Cms\\";

    public $timestamps = false;

    public function page()
    {
        return $this->morphOne(Page::class, 'pageable');
    }

    public function scopeIsMain()
    {
        return $this->where('is_main', true);
    }


}
