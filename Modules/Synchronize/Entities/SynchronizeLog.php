<?php



namespace Modules\Synchronize\Entities;

use danielme85\LaravelLogToDB\Models\LogToDbCreateObject;
use Illuminate\Database\Eloquent\Model;

class SynchronizeLog extends Model
{
    use LogToDbCreateObject;

    protected $table = 'log';

    protected $connection = 'mysql';

    protected $fillable = [
        'message',
        'channel',
        'level',
        'level_name',
        'unix_time',
        'datetime',
        'context',
        'extra',
    ];

    public function scopeLatest($query)
    {
        return $query->sortBy('id', 'desc');
    }
}
