<?php

namespace App\Listeners;

use App\Events\DeleteRoleEvent;
use App\Helpers\ArrayHelper;
use App\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class DeleteRoleListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DeleteRoleEvent  $event
     * @return void
     */
    public function handle(DeleteRoleEvent $event)
    {
        try{

            \DB::beginTransaction();

            // Если роль не админа и не гостя
            if(  $event->role->slug !== Role::DEFAULT_ROLE ||  $event->role->slug !== Role::ADMINISTRATION_ROLE ){

                // Пользователи с удаляемой ролью
                $users = $event->role->users;

                // Роль по умолчанию (гость)
                $defaultRole = Role::where('slug', Role::DEFAULT_ROLE)->first();
                // Доступы по умолчанию
                $defaultPermission = $defaultRole->permissions;

                if(!ArrayHelper::cnt($users->toArray(), 0)) {

                    // Переопределяем роли и доступы
                    foreach ($users as $user) {

                        $user->roles()->attach($defaultRole);
                        $user->permissions()->detach();
                        $user->permissions()->attach($defaultPermission);
                    }
                }

                // Удаляем все связанные с этой ролью достыпы и удаляем роль
                $event->role->permissions()->detach();
                $event->role->delete();

            }

            \DB::commit();
        }catch (Throwable $e){

            dump($e->getMessage());
            \DB::rollback();
        }

    }
}
