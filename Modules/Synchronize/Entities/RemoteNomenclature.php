<?php

namespace Modules\Synchronize\Entities;

use Illuminate\Database\Eloquent\Model;

class RemoteNomenclature extends Model
{
    protected $fillable = [];

    protected $connection= 'mysql_remote';

    protected $table = 'nomenclature';


    public function price_colums()
    {
        return $this->hasOne(RemotePriceColumns::class, 'kod_kartochki_price', 'kod_katochki_price');

    }
}
