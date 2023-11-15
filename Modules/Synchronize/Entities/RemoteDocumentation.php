<?php

namespace Modules\Synchronize\Entities;

use Illuminate\Database\Eloquent\Model;

class RemoteDocumentation extends Model
{
    protected $fillable = [];

    protected $connection = 'mysql_remote';

    protected $table = 'documentations';


    public function product()
    {
        $this->belongsTo(RemoteNomenclature::class, 'kod_kartochki_nomenklature', 'kod_kartochki_nomenklature');
    }
}
