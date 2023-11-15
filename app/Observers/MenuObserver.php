<?php

namespace App\Observers;


use App\Models\Menu;

class MenuObserver
{

    /**
     * Handle the menu before "create" event
     *
     * @param Menu $menu
     */
    public function creating(Menu $menu)
    {
        if(!$menu->icon && !$menu->permission_id){
            $menu->icon = "fas fa-folder";
        }
        if(!$menu->icon && $menu->permission_id){
            $menu->icon = "far fa-file";
        }
    }
    /**
     * Handle the menu "created" event.
     *
     * @param Menu $menu
     */
    public function created(Menu $menu)
    {
        //
    }

    /**
     * Handle the menu "updated" event.
     *
     * @param Menu $menu
     */
    public function updated(Menu $menu)
    {
        //
    }

    /**
     * Handle the menu before "delete" event
     *
     * @param Menu $menu
     */
    public function deleting(Menu $menu)
    {
        // Потомков удаляемого элемента меню перемещаем в корень меню сохраняя иерархию
        $menu->moveChildrenBeforeDelete($menu);
    }

    /**
     * Handle the menu "deleted" event.
     *
     * @param Menu $menu
     */
    public function deleted(Menu $menu)
    {

    }


    /**
     * Handle the menu "restored" event.
     *
     * @param Menu $menu
     */
    public function restored(Menu $menu)
    {
        //
    }


    /**
     * Handle the menu "force deleted" event.
     *
     * @param Menu $menu
     */
    public function forceDeleted(Menu $menu)
    {
        //
    }
}
