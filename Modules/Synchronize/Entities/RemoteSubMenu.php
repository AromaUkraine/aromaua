<?php

namespace Modules\Synchronize\Entities;

use Illuminate\Database\Eloquent\Model;

class RemoteSubMenu extends Model
{
    protected $fillable = [];

    protected $connection= 'mysql_remote';

    protected $table = 'subMenu';

    public function nomenklature()
    {
        return $this->hasMany(RemoteNomenclature::class,'kod_katochki_price','menuKodChilren');
    }
}
