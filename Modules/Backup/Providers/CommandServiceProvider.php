<?php

namespace Modules\Backup\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Backup\Console\BackupDb;
use Modules\Backup\Console\BackupRestore;

class CommandServiceProvider extends ServiceProvider
{

    public function boot()
    {


    }

    public function register()
    {
        $this->commands([
            BackupRestore::class,
            BackupDb::class,
        ]);
    }

}
