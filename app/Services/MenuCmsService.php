<?php


namespace App\Services;


class MenuCmsService
{

    public function getByEvent($event)
    {

        if(!$event->permissions)
            return null;

        $data = [];
        foreach ($event->permissions as $key=>$permission)
        {
            if($permission['action'] == 'index') {

                $data[$key] = [
                    'type'=>$permission->type,
                    'icon'=>'far fa-file',
                    'permission_id' => $permission->id
                ];

                foreach ($event->locales as $locale){
                    if($event->page->translate($locale))
                    {
                        $data[$key][$locale] = [
                            'name'=>$event->page->translate($locale)->name
                        ];
                    }
                }
                unset($event->permissions[$key]);
                return $data;
            }
        }
    }

}
