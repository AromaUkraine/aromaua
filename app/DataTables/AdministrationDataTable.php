<?php


namespace App\DataTables;


use App\Models\Role;
use App\View\Components\Cms\Buttons\DataTableButton;

class AdministrationDataTable extends UsersDataTable
{

    protected function setRoles()
    {
        $this->roles = Role::administration()->pluck('slug');
    }

    /**
     * @param $data
     * @return string|null
     */
    protected function getActionColumn($data)
    {
        $buttons = null;

        if(\Auth::user()->can('admin.administration.edit')){
            $buttons .= DataTableButton::make()->edit(route('admin.administration.edit', $data->id));
        }

        if(\Auth::user()->can('admin.user_permissions.update')){
            $buttons .= DataTableButton::make([
                'name'=>__('cms.buttons.permission'),
                'icon'=>'bx bxs-check-shield',
                'class'=>'success'
            ])->edit(route('admin.user_permissions.show', $data->id));
        }

        if(\Auth::user()->can('admin.administration.destroy')){
            //|| (\Auth::user()->role->slug == Role::ADMINISTRATION_ROLE \Auth::user()->id == $data->id
            if($data->role->slug == Role::ADMINISTRATION_ROLE ){
                $buttons .= DataTableButton::make(['class'=>'danger'])->disabled()->delete();
            }else{
                $buttons .= DataTableButton::make()->delete(route('admin.administration.destroy', $data->id));
            }
        }

        return $buttons;
    }
}
