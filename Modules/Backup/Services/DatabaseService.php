<?php

namespace Modules\Backup\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseService
{
    public function dropAll()
    {
        try{ 
            DB::beginTransaction();

            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            foreach ($tables as $table) {
                Schema::drop($table);
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            DB::commit();

            return true;
        }catch(Exception $e){

            DB::rollback();
            dump($e->getMessage());
        }

        return false;
    }
}
