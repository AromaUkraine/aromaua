<?php

namespace Modules\Map\Entities;

use Illuminate\Database\Eloquent\Model;

class EntityMap extends Model
{
    protected $table = 'entities_map';

    protected $fillable = ['mapable_type','mapable_id','lat','lng'];
}
