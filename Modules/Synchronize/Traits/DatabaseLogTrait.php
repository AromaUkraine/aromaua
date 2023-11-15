<?php


namespace Modules\Synchronize\Traits;

use Illuminate\Support\Facades\Log;

trait DatabaseLogTrait
{
    public function logToDb($message, $context = [], $level = 'info', $channel = 'database')
    {
        Log::error($message);
        Log::channel($channel)->$level($message, $context);
    }
}