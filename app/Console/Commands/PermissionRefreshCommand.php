<?php

namespace App\Console\Commands;

use App\Helpers\ArrayHelper;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\PermissionService;
use App\Traits\ConsoleMessageTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class PermissionRefreshCommand extends Command
{

    use ConsoleMessageTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new, remove if not exist permission items';

    protected $permissions = [];

    protected $slugs = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(Schema::hasTable('permissions')){
            $this->refresh();
        }

        $this->message('Refresh permissions completed successfully.');
    }


    /**
     *  Обновление доступов
     */
    public function refresh()
    {
        $keys = (new Permission())->keys;

        // реальные доступы
        $permissions = app( PermissionService::class)->get($keys);
        // доступы из базы
        $DbPermissions = Permission::whereIn('type',$keys)->get()->toArray();

        $this->createdNew($permissions, $DbPermissions);
        $this->removedNotExist($permissions, $DbPermissions);
    }


    /**
     * Создает новые доступы отсутствующие в базе данных
     * @param $permissions - существующие доступы
     * @param $records - доступы в базе данных
     */
    private function createdNew($permissions, $records)
    {
        foreach ($permissions as $item) {

            if (isset($item['as'])) {

                if(!ArrayHelper::multiArraySearch($records, 'slug', $item['as'])){

                    $permission = app(PermissionService::class)->createPermissionByData($item);
                    app(PermissionService::class)->assignment($permission);
                }
            }
        }
    }


    /**
     * Удаляет отсутствующие доступы из базы данных
     *
     * @param $permissions - существующие доступы
     * @param $records - доступы в базе данных
     */
    private function removedNotExist($permissions, $records)
    {
        $slugs =[];
        foreach ($records as $item){

            if(!ArrayHelper::multiArraySearch($permissions, 'as', $item['slug']))
            {
                $slugs[] = $item['slug'];
            }
        }

        Permission::whereIn('slug', $slugs)->delete();
    }

}
