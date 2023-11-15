<?php

namespace Modules\Newsletter\Entities;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['email','token'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


}