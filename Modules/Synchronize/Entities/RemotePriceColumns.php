<?php

namespace Modules\Synchronize\Entities;

use Illuminate\Database\Eloquent\Model;

class RemotePriceColumns extends Model
{
    protected $fillable = [];

    protected $connection= 'mysql_remote';

    protected $table = 'price_colums';


}
