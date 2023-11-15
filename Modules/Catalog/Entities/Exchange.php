<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = ['currency_id', 'rate'];

    public function currency()
    {
        return $this->hasOne(Currency::class);
    }
}
