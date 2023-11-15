<?php

namespace Modules\Synchronize\Entities;

use Illuminate\Database\Eloquent\Model;

class RemoteCategory extends Model
{
    protected $fillable = [];

    protected $connection= 'mysql_remote';

    protected $table = 'categories';


    public function children()
    {
        return $this->hasMany(RemoteSubMenu::class,'menuKodParent','kod_katochki_price');
    }

    public function nomenklature()
    {
        return $this->hasMany(RemoteNomenclature::class,'kod_katochki_price','kod_katochki_price');
    }
}
